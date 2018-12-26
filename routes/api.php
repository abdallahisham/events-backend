<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'UsersController@login');
Route::post('register', 'UsersController@register');
Route::get('profile', 'UsersController@getProfile');
Route::post('profile', 'UsersController@updateProfile');

// Search and image
Route::post('events/image', 'EventsController@storeImage');
Route::post('events/search', 'EventSearchController@index');
// Bookmarks
Route::get('events/bookmarks', 'EventBookmarksController@bookmarks');
Route::post('events/bookmark', 'EventBookmarksController@bookmark');
// Booking
Route::get('events/bookings', 'EventBookingController@index');
Route::post('events/book', 'EventBookingController@bookEvent');
// Restful events api routes
Route::apiResource('events', 'EventsController');

Route::get('test', function () {
	return [
		'message' => 'Hello world'
	];
});