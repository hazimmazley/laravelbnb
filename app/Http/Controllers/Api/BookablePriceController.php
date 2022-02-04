<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BookablePriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Bookable $bookable, Request $request)
    {
        $bookable;

        $data = request()->validate([
            'from' => 'required|date_format:Y-m-d',
            'to' =>'required|date_format:Y-m-d'
        ]);

        $days = (new Carbon($data['from']))->diffInDays(new Carbon($data['to'])) + 1;
        $price = $days * $bookable->price;

        return response()->json([
            'data' => [
                'total' => $price,
                'breakdown' => [
                    $bookable->price => $days
                ]
            ]
        ]);
    }
}
