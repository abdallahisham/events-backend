<?php

Route::middleware('guest')->get('/', function () {
    return view('auth.login');
});
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('command/migrate', function () {
    Artisan::call('migrate');
    return Artisan::output();
});
Route::get('command/storage:link', function () {
    Artisan::call('storage:link');
    return Artisan::output();
});

Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('dashboard', 'Admin\DashboardController@index');
    Route::get('change-password', 'Admin\DashboardController@getChangePassword')->name('change-password.get');
    Route::post('change-password', 'Admin\DashboardController@postChangePassword')->name('change-password.post');
    Route::get('events/featured', 'Admin\FeaturedEventsController@index');
    Route::get('events/featured/toggle/{id}', 'Admin\FeaturedEventsController@toggle')->name('events.featured.toggle');
    Route::resource('events', 'Admin\EventsController');
    Route::resource('users', 'Admin\UsersController')->only(['index', 'destroy']);
});
