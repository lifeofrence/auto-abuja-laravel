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
        if (!$this->image_path) {
            return asset('public/img/default-product.jpg');
        }
        $path = $this->image_path;
        if (!str_starts_with($path, 'public/') && !str_contains($path, 'http')) {
            $path = 'public/' . ltrim($path, '/');
        }
        return asset($path);
    }
}
