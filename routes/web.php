<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@show');

// Route::get('/home', 'HomeController@show');

// from previous version
Route::get('/about', function () { return view('about'); });
Route::get('/pricing', function () { return view('pricing'); });
Route::get('/contact', function () { return view('contact'); });
Route::get('/privacy', 'WelcomeController@privacy')->name('privacy');

Route::get('/credits', function () { return view('credits'); });
Route::get('/glossary', function () { return view('glossary'); });

Route::get('/pre-assessment','PreAssessmentController@index')->name('pre.assessment');

//Aliased route, auth middleware on the controller
Route::get('/home','App\AssessmentController@index')->name('home');

//Company profile information
Route::put('/settings/teams/{team}/info', 'Settings\Teams\TeamInfoController@update');
//One-Off Purchases
Route::put('/settings/oneoff/{team}/purchase', 'Settings\OneOffPurchaseController@purchase');

Route::group([
    'namespace' => 'App',
    'prefix' => 'app',
    'middleware' => 'auth'
], function() {
    Route::get('/home','AssessmentController@index')->name('home');

    Route::get('/assessments',                    'AssessmentController@index')->name('app');
    Route::get('/assessments/section/{section}',  'AssessmentController@section')->name('app.section');
    Route::get('/assessments/control/{control}',  'AssessmentController@control')->name('app.control');
    Route::post('/assessments/control/{control}', 'AssessmentController@answer')->name('app.answer');

    Route::get('/assessments/file/{answer}/{upload}', 'AssessmentController@download')->name('app.download');
    Route::get('/assessments/file/{control}/{answer}/{upload}/del', 'AssessmentController@deleteupload')->name('app.upload.delete');

    Route::get('/report/poam',  'ReportController@poam')->name('report.poam');
    Route::post('/report/poam',  'ReportController@poamGenerate')->name('report.poam.generate');
    Route::get('/report/missing',  'ReportController@missingDocumentation')->name('report.missing');
    Route::get('/report/ssp',   'ReportController@ssp')->name('report.ssp');
    Route::post('/report/ssp',  'ReportController@sspGenerate')->name('report.ssp.generate');
    Route::get('/report/zip',  'ReportController@zip')->name('report.zip');


    Route::get('/manage/uploads',       'ManageController@uploads')->name('manage.uploads');
});


Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'middleware' => 'dev' //only devs should access
], function() {
    Route::get('/home','AdminController@index')->name('admin.home');

    Route::get('/sections','SectionController@index')->name('admin.sections');
    Route::get('/sections/create','SectionController@create')->name('admin.sections.create');
    Route::patch('/sections/{section}','SectionController@update')->name('admin.section.update');
    Route::post('/sections','SectionController@store')->name('admin.section.create');
    Route::delete('/sections/{section}','SectionController@destroy')->name('admin.section.delete');
    Route::get('/section/{section}/edit','SectionController@edit')->name('admin.section.edit');
    Route::get('/section/{section}','SectionController@show')->name('admin.section');

    Route::get('/controls','ControlController@index')->name('admin.controls');
    Route::get('/controls/create/{section?}','ControlController@create')->name('admin.controls.create');
    Route::patch('/controls/{control}','ControlController@update')->name('admin.control.update');
    Route::post('/controls','ControlController@store')->name('admin.control.create');
    Route::delete('/controls/{control}','ControlController@destroy')->name('admin.control.delete');
    Route::get('/control/{control}/edit','ControlController@edit')->name('admin.control.edit');
    Route::get('/control/{control}','ControlController@show')->name('admin.control');

    Route::get('/control/{control}/options','OptionController@index')->name('admin.control.options');

    Route::get('/control/{control}/options/create','OptionController@create')->name('admin.options.create');
    Route::patch('/control/{control}/options/{option}','OptionController@update')->name('admin.options.update');
    Route::post('/control/{control}/options','OptionController@store')->name('admin.option.create');
    Route::delete('/control/{control}/options/{option}','OptionController@destroy')->name('admin.option.delete');
    Route::get('/control/{control}/option/{option}/edit','OptionController@edit')->name('admin.option.edit');
    Route::get('/control/{control}/option/{option}','OptionController@show')->name('admin.option');

    Route::get('/doom','AdminController@purgeUsers')->name('admin.purge');
});
