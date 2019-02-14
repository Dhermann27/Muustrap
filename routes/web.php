<?php

Route::get('/', 'WelcomeController@index');
Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/workshops', 'WorkshopController@display');
Route::get('/excursions', 'WorkshopController@excursions');

Route::get('/contact', 'ContactController@contactIndex');
Route::post('/contact', 'ContactController@contactStore');

Route::get('/confirm', 'ConfirmController@index')->middleware('auth');
Route::post('/confirm/y/{id}', 'ConfirmController@respond')->middleware('auth');
Route::get('/confirm/{i}/{id}', 'ConfirmController@read')->middleware('auth', 'role:admin|council');
Route::post('/confirm/y/{id}', 'ConfirmController@respond')->middleware('role:admin|council');
Route::get('/confirm/all', 'ConfirmController@all')->middleware('auth', 'role:admin');
Route::get('/confirm/letters', 'ConfirmController@letters')->middleware('auth', 'role:admin');

Route::get('/household', 'HouseholdController@index')->middleware('auth');
Route::post('/household', 'HouseholdController@store')->middleware('auth');
Route::get('/household/{i}/{id}', 'HouseholdController@read')->middleware('auth', 'role:admin|council');
Route::post('/household/f/{id}', 'HouseholdController@write')->middleware('auth', 'role:admin');

Route::get('/camper', 'CamperController@index')->middleware('auth');
Route::post('/camper', 'CamperController@store')->middleware('auth');
Route::get('/camper/{i}/{id}', 'CamperController@read')->middleware('auth', 'role:admin|council');
Route::post('/camper/f/{id}', 'CamperController@write')->middleware('auth', 'role:admin');

Route::get('/payment', 'PaymentController@index')->middleware('auth');
Route::get('/paypaltest', 'PaymentController@test');
Route::post('/payment', 'PaymentController@store')->middleware('auth');
Route::get('/payment/{i}/{id}', 'PaymentController@read')->middleware('auth', 'role:admin|council');
Route::post('/payment/f/{id}', 'PaymentController@write')->middleware('auth', 'role:admin');

Route::get('/workshopchoice', 'WorkshopController@index')->middleware('auth');
Route::post('/workshopchoice', 'WorkshopController@store')->middleware('auth');
Route::get('/workshopchoice/{i}/{id}', 'WorkshopController@read')->middleware('auth', 'role:admin|council');
Route::post('/workshopchoice/f/{id}', 'WorkshopController@write')->middleware('auth', 'role:admin');

Route::get('/volunteer', 'VolunteerController@index')->middleware('auth');
Route::post('/volunteer', 'VolunteerController@store')->middleware('auth');
Route::get('/volunteer/{i}/{id}', 'VolunteerController@read')->middleware('auth', 'role:admin|council');
Route::post('/volunteer/f/{id}', 'VolunteerController@write')->middleware('auth', 'role:admin');

Route::get('/roomselection', 'RoomSelectionController@index')->middleware('auth');
Route::post('/roomselection', 'RoomSelectionController@store')->middleware('auth');
Route::get('/roomselection/map', 'RoomSelectionController@map')->middleware('auth', 'role:admin|council');
Route::get('/roomselection/{i}/{id}', 'RoomSelectionController@read')->middleware('auth', 'role:admin|council');
Route::post('/roomselection/f/{id}', 'RoomSelectionController@write')->middleware('auth', 'role:admin');

Route::get('/nametag', 'NametagController@index')->middleware('auth');
Route::post('/nametag', 'NametagController@store')->middleware('auth');
Route::get('/nametag/{i}/{id}', 'NametagController@read')->middleware('auth', 'role:admin|council');
Route::post('/nametag/f/{id}', 'NametagController@write')->middleware('auth', 'role:admin');

Route::get('/museupload', 'ContactController@museIndex')->middleware('auth', 'role:admin|council');
Route::post('/museupload', 'ContactController@museStore')->middleware('auth', 'role:admin|council');
Route::get('/calendar/c/{id}', 'CalendarController@read')->middleware('auth', 'role:admin|council');
Route::get('/directory', 'DirectoryController@index')->middleware('auth');
Route::get('/coffeehouse/{day?}', 'CoffeeController@index')->middleware('auth');
Route::post('/coffeehouse', 'CoffeeController@store')->middleware('auth');

Route::get('/artfair', 'ContactController@artfairIndex');
Route::post('/artfair', 'ContactController@artfairStore')->middleware('auth');
Route::get('/calendar', 'CalendarController@index')->middleware('auth');

Route::get('/proposal', 'ContactController@proposalIndex')->middleware('auth');
Route::post('/proposal', 'ContactController@proposalStore')->middleware('auth');

Route::group(['middleware' => 'auth', 'prefix' => 'data'], function () {
    Route::get('camperlist', 'DataController@campers');
    Route::get('churchlist', 'DataController@churches');
});

Route::group(['middleware' => ['role:admin|council'], 'prefix' => 'reports'], function () {
    Route::get('campers', 'ReportController@campers');
    Route::get('campers/{year}.xls', 'ReportController@campersExport');
    Route::get('campers/{year?}/{order?}', 'ReportController@campers');
    Route::get('chart', 'ReportController@chart');
    Route::get('conflicts', 'ReportController@conflicts');
    Route::get('deposits', 'ReportController@deposits');
    Route::post('deposits/{id}', 'ReportController@depositsMark')->middleware('auth', 'role:admin');
    Route::get('firsttime', 'ReportController@firsttime');
    Route::get('guarantee', 'ReportController@guarantee');
    Route::get('outstanding', 'ReportController@outstanding');
    Route::get('outstanding/{filter?}', 'ReportController@outstanding');
    Route::post('outstanding/{id}', 'ReportController@outstandingMark')->middleware('auth', 'role:admin');
    Route::get('payments', 'ReportController@payments');
    Route::get('payments/{year}.xls', 'ReportController@paymentsExport');
    Route::get('payments/{year?}/name', 'ReportController@payments');
    Route::get('programs', 'ReportController@programs');
    Route::get('rates', 'ReportController@rates');
    Route::post('rates', 'ReportController@ratesMark')->middleware('auth', 'role:admin');;
    Route::get('roommates', 'ReportController@roommates');
    Route::get('rooms', 'ReportController@rooms');
    Route::get('rooms/{year}.xls', 'ReportController@roomsExport');
    Route::get('rooms/{year?}/name', 'ReportController@rooms');
    Route::get('states', 'ReportController@states');
    Route::get('volunteers', 'ReportController@volunteers');
    Route::get('workshops', 'ReportController@workshops');
});

Route::group(['middleware' => ['role:admin|council'], 'prefix' => 'tools'], function () {
    Route::get('cognoscenti', 'ToolsController@cognoscenti');
    Route::get('nametags', 'ToolsController@nametagsList');
    Route::post('nametags', 'ToolsController@nametagsPrint');
    Route::get('nametags/all', 'ToolsController@nametags');
    Route::get('nametags/{i}/{id}', 'ToolsController@nametagsFamily');
    Route::get('programs', 'ToolsController@programIndex');
    Route::post('programs', 'ToolsController@programStore');
    Route::get('staffpositions', 'ToolsController@positionIndex');
    Route::post('staffpositions', 'ToolsController@positionStore');
    Route::get('workshops', 'ToolsController@workshopIndex');
    Route::post('workshops', 'ToolsController@workshopStore');
});

Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
    Route::get('distlist', 'AdminController@distlistIndex');
    Route::post('distlist', 'AdminController@distlistStore');
    Route::get('master', 'AdminController@masterIndex');
    Route::post('master', 'AdminController@masterStore');
    Route::get('roles', 'AdminController@roleIndex');
    Route::post('roles', 'AdminController@roleStore');
    Route::get('positions', 'AdminController@positionIndex');
    Route::post('positions', 'AdminController@positionStore');
});

Route::get('/themuse', function () {
    $muses = Storage::files('public/muses');
    $muse = array_pop($muses);
    return redirect('/muses/' . substr($muse, strpos($muse, '/20') + 1));
});

Route::get('/registration', 'HouseholdController@index')->middleware('auth'); //HomeController@registration');
Route::get('/information', 'HouseholdController@index')->middleware('auth'); //HomeController@information');
Route::get('/cost', 'HomeController@campcost');
Route::get('/themespeaker', 'HomeController@themespeaker');
Route::get('/scholarship', 'HomeController@scholarship');
Route::get('/programs', 'HomeController@programs');
Route::get('/housing', 'HomeController@housing');

Route::get('/brochure', function () {
    $year = date('Y');
    if (!is_file(public_path('MUUSA_' . $year . '_Brochure.pdf'))) $year--;
    return redirect('MUUSA_' . $year . '_Brochure.pdf');
});