<?php

namespace Tests\Feature;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{

	use RefreshDatabase;

	public function setUp()
	{
		parent::setUp();

    	$user = factory(\App\User::class)->create();
	    $this->actingAs($user, 'api');

	    $this->withHeaders([
    	    'Accept' => 'application/json',
    	    'Content-Type' => 'application/json',
    	]);
	}

    public function testCreateNewCustomer()
    {
        $data = [
        	'firstname' => 'Ryan',
        	'lastname' => 'Sanney',
        	'email' => 'test@email.com',
        	'mobile' => '123456789',
        ];

        $response = $this->json('POST','/api/customers', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
        	'id',
        	'firstname',
        	'lastname',
        	'mobile',
        	'email',
        	'created_at',
        	'updated_at'
        ]);
    }

    public function testGettingAllCustomers()
    {
    	factory(\App\Customer::class, 5)->create();
    	$response = $this->json('GET','/api/customers');
    	$response->assertStatus(200);
    	$response->assertJsonCount(5);
    	$response->assertJsonStructure([
    		[
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

    public function testUpdateCustomer()
    {
    	$customer = factory(\App\Customer::class)->create();
    	$data = ['email' => 'fakeemail1234@fake.com'];
    	$response = $this->json('PUT','/api/customers/'.$customer->id, $data);
    	$response->assertStatus(200);
    	$response->assertJsonFragment($data);
    }

    public function testDeleteCustomer()
    {
    	$customer = factory(\App\Customer::class)->create();
    	$response = $this->json('DELETE','/api/customers/'.$customer->id);
    	$response->assertStatus(204);
    }

    public function testGetCustomerByID()
    {
    	$customer = factory(\App\Customer::class)->create();
    	$response = $this->json('GET','/api/customers/'.$customer->id);
    	$response->assertStatus(200);
    	$response->assertJsonFragment([
    		'id' => $customer->id
    	]);
    	$response->assertJsonStructure([
    		'id',
    		'firstname',
    		'lastname',
    		'mobile',
    		'email',
    		'created_at',
    		'updated_at'
    	]);
    }

    public function testGetAllCustomersBookings()
    {
    	$customer = factory(\App\Customer::class)->create();
    	factory(\App\Booking::class, 3)->create([
    		'customer_id' => $customer->id
    	]);
    	factory(\App\Booking::class, 5)->create();

    	$response = $this->json('GET','/api/customers/'.$customer->id.'/bookings');
    	$response->assertStatus(200);
    	$response->assertJsonCount(3);
    	$response->assertJsonFragment([
    		'id' => $customer->id
    	]);
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
}
