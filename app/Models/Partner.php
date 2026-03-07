<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        if (!$this->logo) {
            return asset('img/default-partner.png');
        }
        $path = $this->logo;
        if (!str_starts_with($path, 'http') && !str_starts_with($path, 'img/') && !str_starts_with($path, 'storage/')) {
            $path = 'storage/' . ltrim($path, '/');
        }
        return asset($path);
    }
}
