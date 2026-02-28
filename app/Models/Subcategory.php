<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $guarded = [];

    public function category() { return $this->belongsTo(Category::class); }
    public function businesses() { return $this->hasMany(Business::class); }
    public function products() { return $this->hasMany(Product::class); }
    //
}
