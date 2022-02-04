<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('bookables', 'Api\BookableController');
Route::get('bookables/{bookable}/availability', 'Api\BookableAvailabilityController')
    ->name('bookables.availability.show');

Route::get('bookables/{bookable}/reviews', 'Api\BookableReviewController')
->name('bookables.review.index');

Route::get('bookables/{bookable}/price', 'Api\BookablePriceController')
->name('bookables.price.show');


Route::get('/booking-by-review/{reviewKey}', 'Api\BookingByReviewController')
->name('booking.by-review.show');

Route::resource('reviews', 'Api\ReviewController');

