<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('auth/login', 'Api\\AuthController@login');
Route::post('auth/refresh', 'Api\\AuthController@refresh');

Route::post('user/register', 'Api\\AppUsersController@store');

Route::group(['middleware' => ['apiJwt']], function() {
    
    Route::post('auth/logout', 'Api\\AuthController@logout');
    Route::post('auth/me', 'Api\\AuthController@me');
    
    Route::get('users', 'Api\\UserController@index');
    
    Route::get('products', 'Api\\ProductsController@index');

    Route::get('pickups', 'Api\\PickupsController@index');
    Route::get('pickups/location', 'Api\\PickupsController@location');
    Route::post('pickups/location', 'Api\\PickupsController@store');

    Route::get('pickups/users', 'Api\\PickupsController@users');
    Route::get('pickups/confirmation', 'Api\\PickupsController@confirmation');
    
    Route::get('user/list', 'Api\\AppUsersController@index');
});