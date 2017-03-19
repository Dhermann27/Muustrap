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
Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/workshops', 'WorkshopController@read');

Route::get('/contact', 'ContactController@contactIndex');
Route::post('/contact', 'ContactController@contactStore');
Route::get('/artfair', 'ContactController@artfairIndex');
Route::post('/artfair', 'ContactController@artfairStore')->middleware('auth');;

Route::get('/household', 'HouseholdController@index')->middleware('auth');
Route::post('/household', 'HouseholdController@store')->middleware('auth');
Route::get('/household/{i}/{id}', 'HouseholdController@read')->middleware('role:admin|council');
Route::post('/household/{id}', 'HouseholdController@write')->middleware('role:admin');

Route::get('/camper', 'CamperController@index')->middleware('auth');
Route::post('/camper', 'CamperController@store')->middleware('auth');
Route::get('/camper/{i}/{id}', 'CamperController@read')->middleware('role:admin|council');
Route::post('/camper/{id}', 'CamperController@write')->middleware('role:admin');

Route::get('/payment', 'PaymentController@index')->middleware('auth');
Route::post('/payment', 'PaymentController@store')->middleware('auth');
Route::get('/payment/{i}/{id}', 'PaymentController@read')->middleware('role:admin|council');
Route::post('/payment/{id}', 'PaymentController@write')->middleware('role:admin');

Route::get('/workshopchoice', 'WorkshopController@index')->middleware('auth');
Route::post('/workshopchoice', 'WorkshopController@store')->middleware('auth');

Route::get('/roomselection', 'RoomSelectionController@index')->middleware('auth');
Route::post('/roomselection', 'RoomSelectionController@store')->middleware('auth');
Route::get('/roomselection/{i}/{id}', 'RoomSelectionController@read')->middleware('role:admin|council');
Route::post('/roomselection/{id}', 'RoomSelectionController@write')->middleware('role:admin');

Route::group(['middleware' => 'auth', 'prefix' => 'data'], function () {
    Route::get('camperlist', 'DataController@campers');
    Route::get('churchlist', 'DataController@churches');
});

Route::group(['middleware' => ['role:admin|council'], 'prefix' => 'reports'], function () {
    Route::get('campers', 'ReportController@campers');
    Route::get('rates', 'ReportController@rates');
    Route::get('rooms', 'ReportController@rooms');
});

Route::group(['middleware' => ['role:admin|council'], 'prefix' => 'tools'], function () {
    Route::get('staffpositions', 'ToolsController@positionIndex');
    Route::post('staffpositions', 'ToolsController@positionStore');
});

Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
    Route::get('roles', 'AdminController@roleIndex');
    Route::post('roles', 'AdminController@roleStore');
    Route::get('positions', 'AdminController@positionIndex');
    Route::post('positions', 'AdminController@positionStore');
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
Route::get('/scholarship', function () {
    return view('scholarship');
});
Route::get('/programs', function () {
    return view('programs', ['programs' => \App\Program::whereNotNull('blurb')->orderBy('age_min')->orderBy('grade_min')->get()]);
});
Route::get('/housing', function () {
    return view('housing', ['buildings' => \App\Building::whereNotNull('blurb')->get()]);
});
