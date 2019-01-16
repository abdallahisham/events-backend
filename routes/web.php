<?php

Route::get('/', function () {
    return view('welcome');
});
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('command/migrate', function () {
    Artisan::call('migrate');
    return Artisan::output();
});
