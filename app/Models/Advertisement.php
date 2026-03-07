<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('img/carousel-bg-1.jpg');
        }
        $path = $this->image;
        if (!str_starts_with($path, 'http') && !str_starts_with($path, 'img/') && !str_starts_with($path, 'storage/')) {
            $path = 'storage/' . ltrim($path, '/');
        }
        return asset($path);
    }
}
