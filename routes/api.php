<?php

use App\User;
use Illuminate\Http\Request;
use App\Transformers\AccessTokenResponse;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'UsersController@login');
Route::post('register', 'UsersController@register');
Route::post('login-social', function () {
    $id = request('id');
    $name = request('name');
    $email = "";
    if (ends_with($id, '@gmail.com')) {
        $email = $id;
    } elseif (!str_contains($id, '@')) {
        $email = "id{$id}@facebook.com";
    } else {
        die;
    }

    if (User::where('email', $email)->count() > 0) {
        $user = User::where('email', $email)->first();
    } else {
        $user = User::forceCreate([
            'token' => md5(request('id')),
            'name' => $name,
            'email' => $email,
            'password' => ''
        ]);
    }
    if ($user) {
        $token = ['access_token' => $user->createToken(null)->accessToken];
        return new AccessTokenResponse($token);
    } else {
        logger()->info('Shoud never happens');
    }
});
Route::get('profile', 'UsersController@getProfile');
Route::post('profile', 'UsersController@updateProfile');

// Search
Route::post('events/search', 'EventSearchController@index');
Route::post('events/search-by-type', 'EventSearchController@searchByType');
// Bookmarks
Route::get('events/bookmarks', 'EventBookmarksController@bookmarks');
Route::post('events/bookmark', 'EventBookmarksController@bookmark');
// Booking
Route::get('events/bookings', 'EventBookingController@index');
Route::post('events/book', 'EventBookingController@bookEvent');
// Featured
Route::get('events/featured', 'FeaturedEventsController@index');
// Restful events api routes
Route::post('events/image', 'EventsController@storeImage');
Route::post('events/delete', 'EventsController@destroy');
Route::post('events/update', 'EventsController@update');
Route::apiResource('events', 'EventsController')->only(['index', 'show', 'store']);

Route::get('my-events', 'UserEventsController@index');

Route::get('test', function () {
    logger()->info('Testing end point');
});
