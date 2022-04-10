<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Http\Request;
use Livewire\Component;

class ProductBrowser extends Component
{
    public $category;

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

        return view('livewire.product-browser', [
            'products'=> $products,
        ]);
    }
}
