<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eatery extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'name',
        'slug',
        'address',
        'price_range',
        'specialty',
        'is_open',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
        ];
    }

    // Route model binding uses the slug instead of the id,
    // so /eateries/carinderia-ni-perez finds the eatery by its slug.
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ----- Relationships -----

    // Inverse of District hasMany: each eatery belongs to one district
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // One eatery has one permit (permits.eatery_id is unique)
    public function permit()
    {
        return $this->hasOne(Permit::class);
    }

    // One eatery has many dishes
    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }

    // One eatery has many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Many-to-many with features through the eatery_feature pivot table
    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    // ----- Helpers used by the views -----

    // Shows the price range as peso signs: budget = ₱, mid = ₱₱, splurge = ₱₱₱
    public function priceSigns()
    {
        if ($this->price_range == 'splurge') {
            return '₱₱₱';
        } elseif ($this->price_range == 'mid') {
            return '₱₱';
        }

        return '₱';
    }
}
