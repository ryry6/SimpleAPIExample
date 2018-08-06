<?php

namespace App\Http\Controllers\API;

use App\Booking;
use Illuminate\Http\Request;
use App\Services\FilterService;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    protected $filter;

    function __construct(FilterService $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = $this->filter->byDate(
            Booking::query(), request()
        );

        return response()->json($query->get(), 200);
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
            'date' => 'date',
            'time' => 'string',
            'description' => 'string|nullable',
            'customer_id' => 'integer'
        ]);

        $booking = Booking::create($validated_data);

        return response()->json($booking, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\booking  $Booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return response()->json($booking, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\booking  $Booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $validated_data = $request->validate([
            'date' => 'date',
            'time' => 'time',
            'description' => 'string|nullable',
            'customer_id' => 'integer'
        ]);

        $booking->update($validated_data);

        return response()->json($booking, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json(null, 204);
    }
}
