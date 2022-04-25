<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProductBrowser extends Component
{
    public $category;

    public $queryFilters = [];

    public function mount()
    {
        $this->queryFilters = $this->category->products->pluck('variations')->flatten()
        ->groupBy('type')
        ->keys()
        ->mapWithKeys(fn($key) =>[$key => []])
        ->toArray();
    }

    public function render()
    {

        //$b = Product::with(['categories'])->where('category_id', $this->category->id);
     
        $products = Product::search('', function ($search) {
           
            return $search;
        })->query(function ($query) {
            return $query->whereHas('categories', function ($categories) {
                $categories->where('category_id', $this->category->id);
            });
        })->get();
        
              
        $filters = DB::table('variations')->get()
            ->groupBy('type')->toArray(); 

        $attrs = [];

        foreach ($filters as $key => $value) {
            
            $attrs[$key] = [];
            foreach ($value as  $item_value){
                
                if(array_key_exists($item_value->title ,$attrs[$key]) ){
                    $attrs[$key][$item_value->title] = $attrs[$key][$item_value->title] + 1;
                }else {
                    $attrs[$key][$item_value->title] = 1;
                }
            }

        }   
 

        return view('livewire.product-browser', [
            'products'=> $products,
            'filters' => $attrs
        ]);
    }
}
