<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getImageUrlAttribute()
    {
        $path = $this->image;
        if (!$path) {
            return asset('img/carousel-bg-1.jpg');
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        $path = ltrim($path, '/');
        // Handle images stored in storage/app/public/...
        if (!str_starts_with($path, 'img/') && !str_starts_with($path, 'uploads/') && !str_starts_with($path, 'storage/')) {
            $path = 'storage/' . $path;
        }

        return asset($path);
    }
}
