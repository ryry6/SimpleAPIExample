<?php

namespace App\Http\Controllers\API;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Customer::all(), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'firstname' => 'string',
            'lastname' => 'string',
            'email' => 'email|nullable',
            'mobile' => 'integer'
        ]);

        $customer = Customer::create($validated_data);

        return response()->json($customer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return response()->json($customer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validated_data = $request->validate([
            'firstname' => 'string',
            'lastname' => 'string',
            'email' => 'email|nullable',
            'mobile' => 'integer'
        ]);

        $customer->update($validated_data);

        return response()->json($customer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(null, 204);
    }

    /**
     * Returns all bookings for a customer
     * @param Customer $customer 
     * @return \Illuminate\Http\Response
     */
    public function bookings(Customer $customer)
    {
        $bookings = $customer->bookings()->get();

        return response()->json($bookings, 200);
    }
}
