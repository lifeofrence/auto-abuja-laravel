<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('public/img/carousel-bg-1.jpg');
        }
        $path = $this->image;
        if (!str_starts_with($path, 'public/') && !str_contains($path, 'http')) {
            $path = 'public/' . ltrim($path, '/');
        }
        return asset($path);
    }
}
