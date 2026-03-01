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
        if (!$this->image) {
            return asset('public/img/default-product.jpg');
        }

        $path = $this->image;
        if (!str_starts_with($path, 'public/') && !str_contains($path, 'http')) {
            $path = 'public/' . ltrim($path, '/');
        }

        return asset($path);
    }
}
