<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function images()
    {
        return $this->hasMany(BusinessImage::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->cover_image) {
            return asset('public/img/carousel-bg-1.jpg');
        }
        $path = $this->cover_image;
        if (!str_starts_with($path, 'public/') && !str_contains($path, 'http')) {
            $path = 'public/' . ltrim($path, '/');
        }
        return asset($path);
    }

    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return asset('public/img/default-logo.png');
        }
        $path = $this->logo;
        if (!str_starts_with($path, 'public/') && !str_contains($path, 'http')) {
            $path = 'public/' . ltrim($path, '/');
        }
        return asset($path);
    }
}
