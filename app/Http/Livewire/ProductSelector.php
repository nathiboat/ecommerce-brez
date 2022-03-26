<?php

namespace App\Http\Livewire;

use App\Models\Variation;
use Livewire\Component;

class ProductSelector extends Component
{
    public $product;
    public $initialVariation;
    public $skuVariant;

    protected $listeners = [
        'skuVariatSelected'
    ];

    public function mount()
    {
        $this->initialVariation = $this->product->variations->sortBy('order')->groupBy('type')->first();
    }

    public function skuVariatSelected($varianId)
    {
        if(!$varianId){
            $this->skuVariant = null;
            return;
        }
        $this->skuVariant = Variation::find($varianId);
    }

    public function addToCart()
    {
        dd('s');
    }

    public function render()
    {
        return view('livewire.product-selector');
    }
}
