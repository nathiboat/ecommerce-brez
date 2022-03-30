<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Variation extends Model implements HasMedia
{
    use HasFactory;
    use HasRecursiveRelationships;
    use InteractsWithMedia;

    public function formattedPrice()
    {
        echo money($this->price); // $5.00
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inStock()
    {
        return $this->stockCount() > 0;
    }

    public function outOfStock()
    {
        return !$this->inStock();
    }

    public function lowStock()
    {
        return !$this->outOfStock() && $this->stockCount() < 6;
    }

    public function stockCount()
    {
        return $this->descendantsAndSelf->sum(fn ($variation) => $variation->stocks->sum('amount'));
    }

    public function stocks()
    {
        return $this->hasmany(Stock::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {   
        $this->addMediaConversion('thumb200x200')
        ->fit(Manipulations::FIT_CROP,200,200);
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')->useFallbackUrl('/storage/no-product-image.png');
    }
}
