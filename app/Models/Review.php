<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['eatery_id', 'user_id', 'rating', 'body'];

    // Inverse of Eatery hasMany Review
    public function eatery()
    {
        return $this->belongsTo(Eatery::class);
    }

    // Inverse of User hasMany Review (the reviewer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
