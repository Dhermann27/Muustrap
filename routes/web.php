<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('/workshops', 'WorkshopController@read');

Route::get('/contact', 'ContactController@index');
Route::post('/contact', 'ContactController@store');

Route::get('/household', 'HouseholdController@index')->middleware('auth');
Route::post('/household', 'HouseholdController@store')->middleware('auth');
Route::get('/camper', 'CamperController@index')->middleware('auth');
Route::post('/camper', 'CamperController@store')->middleware('auth');
Route::get('/payment', 'PaymentController@index')->middleware('auth');
Route::post('/payment', 'PaymentController@store')->middleware('auth');
Route::get('/workshopchoice', 'WorkshopController@index')->middleware('auth');
Route::post('/workshopchoice', 'WorkshopController@store')->middleware('auth');

Route::group(['middleware' => 'auth', 'prefix' => 'data'], function () {
    Route::get('churchlist', 'DataController@churches');
});

Route::get('/cost', function () {
    return view('campcost');
});
Route::get('/excursions', function () {
    return view('excursions', ['workshops' => \App\Workshop::where('timeslotid', '1005')->get()]);
});
Route::get('/themespeaker', function () {
    return view('themespeaker');
});
Route::get('/programs', function () {
    return view('programs', ['programs' => \App\Program::whereNotNull('blurb')->orderBy('age_min')->orderBy('grade_min')->get()]);
});
Route::get('/housing', function () {
    return view('housing', ['buildings' => \App\Building::whereNotNull('blurb')->get()]);
});
