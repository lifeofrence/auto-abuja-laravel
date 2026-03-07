<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $guarded = [];

    protected $casts = [
        'business_hours' => 'array',
    ];

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
        return $this->hasMany(Product::class)->where('is_available', true);
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
        $path = ltrim($this->cover_image, '/');
        if (!$path) {
            return asset('img/carousel-bg-1.jpg');
        }
        if (str_starts_with($path, 'http')) {
            return $path;
        }
        if (!str_starts_with($path, 'img/') && !str_starts_with($path, 'uploads/') && !str_starts_with($path, 'storage/')) {
            $path = 'storage/' . $path;
        }
        return asset($path);
    }

    public function getLogoUrlAttribute()
    {
        $path = ltrim($this->logo, '/');
        if (!$path) {
            return asset('img/carousel-bg-1.jpg');
        }
        if (str_starts_with($path, 'http')) {
            return $path;
        }
        if (!str_starts_with($path, 'img/') && !str_starts_with($path, 'uploads/') && !str_starts_with($path, 'storage/')) {
            $path = 'storage/' . $path;
        }
        return asset($path);
    }
}
