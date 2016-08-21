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

Route::get('/home', ['uses' => 'ProductController@index', 'as' => 'home']);

// User Registration & Login
Route::auth();
Route::group(['middleware' => ['web']], function () {
    // Admin Registration Routes...
    Route::get('/register/admin', 'Auth\AuthController@showAdminRegistrationForm');
    Route::post('/register/admin', 'Auth\AuthController@registerAdmin');
});

// Products APIs
Route::resource('product', 'ProductController');
