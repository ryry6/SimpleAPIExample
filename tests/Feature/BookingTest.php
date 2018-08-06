<?php

namespace Tests\Feature;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{

	use RefreshDatabase;

	public function setUp()
	{
		parent::setUp();

    	$user = factory(\App\User::class)->create();
	    $this->actingAs($user, 'api');

	    $this->withHeaders([
    	    'Accept' => 'application/json',
    	]);
	}

    public function testCreateNewBooking()
    {
        $data = [
            'date' => "2018-06-08",
            'time' => "10:00:00",
            'description' => "Booking description",
            'customer_id' => factory(\App\Customer::class)->create()->id,
        ];

        $response = $this->json('POST','/api/bookings', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
        	'id',
        	'customer_id',
        	'date',
        	'description',
        	'time',
        	'created_at',
        	'updated_at'
        ]);
    }

    public function testGettingAllBookings()
    {
    	factory(\App\Booking::class, 5)->create();
    	$response = $this->json('GET','/api/bookings');
    	$response->assertStatus(200);
    	$response->assertJsonCount(5);
    	$response->assertJsonStructure([
    		[
	    		'id',
	    		'customer_id',
	    		'date',
	    		'description',
	    		'time',
	    		'created_at',
	    		'updated_at',
	    		'customer' => [
	    			'id',
	    			'firstname',
	    			'lastname',
	    			'mobile',
	    			'email',
	    			'created_at',
	    			'updated_at'
	    		]
	    	]
    	]);
    }

    public function testUpdateBooking()
    {
    	$booking = factory(\App\Booking::class)->create();
    	$data = ['description' => 'updated by test'];
    	$response = $this->json('PUT','/api/bookings/'.$booking->id, $data);
    	$response->assertStatus(200);
    	$response->assertJsonFragment([
    		'description' => 'updated by test'
    	]);
    }

    public function testDeleteBooking()
    {
    	$booking = factory(\App\Booking::class)->create();
    	$response = $this->json('DELETE','/api/bookings/'.$booking->id);
    	$response->assertStatus(204);
    }

    public function testGetBookingByID()
    {
    	$booking = factory(\App\Booking::class)->create();
    	$response = $this->json('GET','/api/bookings/'.$booking->id);
    	$response->assertStatus(200);
    	$response->assertJsonFragment([
    		'id' => $booking->id
    	]);
    	$response->assertJsonStructure([
    		'id',
    		'customer_id',
    		'date',
    		'description',
    		'time',
    		'created_at',
    		'updated_at',
    		'customer' => [
    			'id',
    			'firstname',
    			'lastname',
    			'mobile',
    			'email',
    			'created_at',
    			'updated_at'
    		]
    	]);
    }
}
