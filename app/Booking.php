<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
	protected $with = ['customer'];
	
	protected $fillable = [
        'date', 'time', 'description', 'customer_id'
    ];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }
}
