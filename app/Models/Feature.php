<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name'];

    // Other side of the many-to-many (same eatery_feature pivot table)
    public function eateries()
    {
        return $this->belongsToMany(Eatery::class);
    }
}
