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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'ProductController@index');

// User/Admin Registration & Login
Route::group(['middleware' => ['web'], 'as' => 'user_auth'], function () {
    // Auth Routes...
    Route::auth();
    // Admin Registration Routes...
    Route::get('/register/admin', 'Auth\AuthController@showAdminRegistrationForm');
    Route::post('/register/admin', 'Auth\AuthController@registerAdmin');
});

// Products APIs
Route::resource('product', 'ProductController');
