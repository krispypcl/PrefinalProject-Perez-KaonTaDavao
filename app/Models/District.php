<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['name'];

    // One district has many eateries (eateries.district_id)
    public function eateries()
    {
        return $this->hasMany(Eatery::class);
    }

    // hasManyThrough: District -> Eatery -> Review
    // Gets all reviews of all eateries inside this district without looping eateries.
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Eatery::class);
    }
}
