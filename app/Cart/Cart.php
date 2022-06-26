<?php

namespace App\Cart;

use App\Cart\Contracts\CartInterface;
use App\Cart\Exceptions\QuantityNoLongerAvailable;
use App\Models\Cart as ModelsCart;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Session\SessionManager;

class Cart implements CartInterface
{
    protected $instance;

    public function __construct(protected SessionManager $session){}

    public function exists()
    {
        return $this->session->has(config('cart.session.key'));
    }

    public function contents()
    {
        return $this->instance()->variations;
    }

    public function contentsCount()
    {
        return $this->contents()->count();
    }

    public function subtotal()
    {
        return $this->instance()->variations
                ->reduce(function ($carry, $variation) {
                    return $carry + ($variation->price * $variation->pivot->quantity);
                });
    }

    public function formattedSubtotal()
    {
        return  money($this->subtotal());
    }



    public function create(?User $user = null)
    {
        $instance = ModelsCart::make();

        if($user){
            $instance->user()->associate($user);
        }

        $instance->save();

        $this->session->put(config('cart.session.key'), $instance->uuid); 
    }

    public function add(Variation $variation, $quantity = 1)
    {
        if($exisingVariation = $this->getVariation($variation)){
           $quantity += $exisingVariation->pivot->quantity;
        }

        
        $this->instance()->variations()->syncWithoutDetaching([
            $variation->id => [
                'quantity' => min($quantity, $variation->stockCount())
            ]
        ]);
    }

    public function changeQuantity(Variation $variation, $quantity)
    {
        $this->instance()->variations()->updateExistingPivot($variation->id, [
            'quantity' => min($quantity, $variation->stockCount())
        ]);
    }

    public function remove(Variation $variation)
    {
        $this->instance()->variations()->detach($variation);

    }

    public function isEmpty()
    {
        return $this->contents()->count() === 0;
    }

    public function verifyAvailableQuntities()
    {
        $this->instance()->variations->each(function ($variation) {
            if($variation->pivot->quantity > $variation->stocks->sum('amount')) {
                throw new QuantityNoLongerAvailable('Stock reduced');
            }
        });
    }

    public function syncAvailableQuantities()
    {
        $syncedQuantities = $this->instance()->variations->mapWithKeys(function ($variation) {
            $quanity = $variation->pivot->quantity > $variation->stocks->sum('count')
                ? $variation->stockCount()
                : $variation->pivot->quantity;

            return [
                $variation->id => [
                    'quantity' => $quanity
                ]
            ];    
        })
        ->reject(function ($syncQuantity) {
            return $syncQuantity['quantity'] === 0;
        })
        ->toArray();

    

        $this->instance()->variations()->sync($syncedQuantities);

        $this->clearInstanceCache();
    }


    public function removeAll(){
        $this->instance()->variations()->detach();
    }


    public function getVariation(Variation $variation)
    {
        return $this->instance()->variations->find($variation->id);
    }

    protected function clearInstanceCache()
    {
        $this->instance = null;
    }

    protected function instance()
    {
        if($this->instance){
            return $this->instance;
        }

        return $this->instance = ModelsCart::query()
            ->with('variations.product', 'variations.ancestorsAndSelf', 'variations.descendantsAndSelf.stocks', 'variations.media')
            ->whereUuid($this->session->get(config('cart.session.key')))
            ->first();
    }
    
}