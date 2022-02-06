<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    }
}
