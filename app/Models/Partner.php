<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        if (!$this->logo) {
            return asset('public/img/default-partner.png');
        }
        $path = $this->logo;
        if (!str_starts_with($path, 'public/') && !str_contains($path, 'http')) {
            $path = 'public/' . ltrim($path, '/');
        }
        return asset($path);
    }
}
