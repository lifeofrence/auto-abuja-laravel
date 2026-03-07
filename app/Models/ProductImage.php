<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute()
    {
        $path = $this->image_path;
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
