<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function subcategory() { return $this->belongsTo(Subcategory::class); }
    public function products() { return $this->hasMany(Product::class); }
    public function images() { return $this->hasMany(BusinessImage::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    //
}
