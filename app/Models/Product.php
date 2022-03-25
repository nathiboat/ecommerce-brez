<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cknow\Money\Money;



class Product extends Model
{
    use HasFactory;


    public function formattedPrice()
    {
        echo money($this->price); // $5.00
    }

    
    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

}
