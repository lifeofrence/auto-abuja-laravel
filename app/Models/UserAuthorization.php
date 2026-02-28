<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAuthorization extends Model
{
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function subcategory() { return $this->belongsTo(Subcategory::class); }
    public function authorizedBy() { return $this->belongsTo(User::class, 'authorized_by'); }
    //
}
