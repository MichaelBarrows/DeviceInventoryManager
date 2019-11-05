<?php

use Illuminate\Http\Request;

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

// Routes for custom active and inactive methods on the controllers which
// provide a collection of active and inactive relations
Route::get('/users/{user}/devices/active', 'UserDeviceController@active');
Route::get('/users/{user}/devices/inactive', 'UserDeviceController@inactive');
Route::get('/devices/{device}/sim-cards/active', 'DeviceSimCardController@active');
Route::get('/devices/{device}/sim-cards/inactive', 'DeviceSimCardController@inactive');
Route::get('/sim-cards/{sim}/phone-numbers/active', 'SimCardPhoneNumberController@active');
Route::get('/sim-cards/{sim}/phone-numbers/inactive', 'SimCardPhoneNumberController@inactive');

// Routes for each of the entities
Route::resource('/users', 'UsersController')->except(['create', 'edit']);
Route::resource('/devices', 'DevicesController')->except(['create', 'edit']);
Route::resource('/sim-cards', 'SimCardsController')->except(['create', 'edit']);
Route::resource('/phone-numbers', 'PhoneNumbersController')->except(['create', 'edit']);

// Routes for the relations between two entities
Route::resource('/users/{user}/devices', 'UserDeviceController')->except(['create', 'edit', 'update']);
Route::resource('/devices/{device}/sim-cards', 'DeviceSimCardController')->except(['create', 'edit', 'update']);
Route::resource('/sim-cards/{sim}/phone-numbers', 'SimCardPhoneNumberController')->except(['create', 'edit', 'update']);
