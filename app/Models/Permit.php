<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;

    protected $fillable = ['eatery_id', 'permit_no', 'expires_on'];

    // expires_on becomes a Carbon date, so we can call ->isPast() or ->format()
    protected function casts(): array
    {
        return [
            'expires_on' => 'date',
        ];
    }

    // Inverse of Eatery hasOne Permit
    public function eatery()
    {
        return $this->belongsTo(Eatery::class);
    }
}
