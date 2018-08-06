<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'firstname', 'lastname', 'email', 'mobile',
    ];

    public function bookings()
    {
    	return $this->hasMany(Booking::class);
    }
}
