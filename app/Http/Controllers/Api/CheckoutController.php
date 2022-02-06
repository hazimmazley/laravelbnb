<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Booking;
use App\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = request()->validate([
            'bookings' => 'required|array',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:bookings.*.from',

            'customer.first_name' => 'required',
            'customer.last_name' => 'required',
            'customer.street' => 'required',
            'customer.city' => 'required',
            'customer.email' => 'required',
            'customer.country' => 'required',
            'customer.state' => 'required',
            'customer.zip' => 'required',
        ]);

        $data = array_merge($data, request()->validate([
            'bookings.*' => ['required', function ($attribute, $value, $fail) {
                $bookable = Bookable::findOrFail($value['bookable_id']);

                if(!$bookable->availableFor($value['from'], $value['to'])) {
                    $fail("The object is not available in given dates!");
                }
            }],
        ]));

        $bookingsData = $data['bookings'];
        $addressData = $data['customer'];

        $bookings = collect($bookingsData)->map(function ($bookingData) use ($addressData) {
            $bookable = Bookable::findOrFail($bookingData['bookable_id']);

            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = $bookable->priceFor($booking->from, $booking->to)['total'];
            $booking->bookable()->associate($bookable);
            $booking->address()->associate(Address::create($addressData));

            $booking->save();

            return $booking;
        });

        return $bookings;
    }
}
