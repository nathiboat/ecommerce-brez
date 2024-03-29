<?php

namespace App\Models;

use App\Models\Scopes\LiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Searchable;

    public static function booted()
    {
        static::addGlobalScope(new LiveScope());
    }


    public function formattedPrice()
    {
        echo money($this->price); // $5.00
    }

    
    public function variations()
    {
        return $this->hasMany(Variation::class);
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

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug, 
            'price' => $this->price,
            //'category_ids' => $this->categories->pluck('id')->toArray(),
        ];
    }

}
