<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
    public function business()
    {
        return $this->hasOne(Business::class)->latestOfMany();
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'vio_user_id',
        'role',
        'status',
        'phone',
        'address',
        'activation_token',
        'business_name',
        'business_address',
        'business_location',
        'association_or_union',
        'service_type',
        'service_category',
        'service_description',
        'license_start_date',
        'license_end_date',
        'license_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'license_start_date' => 'datetime',
            'license_end_date' => 'datetime',
        ];
    }
}
