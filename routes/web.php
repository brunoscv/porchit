<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('home');
}); */

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user/create', ['as' => 'user.form', 'uses' => 'UserController@create']);
Route::post('/user/store', 'UserController@store')->name('store');
Route::post('/user/edit', 'UserController@edit')->name('edit');
Route::post('/user/update', 'UserController@update')->name('update');
Route::get('/user/{id}/destroy', 'UserController@destroy');

Route::get('/clients', 'RecyclerController@index')->name('clients');

Route::get('/products', 'ProductsController@index')->name('products');
Route::get('/products/create', 'ProductsController@create')->name('products-create');
Route::post('/products/save', 'ProductsController@store')->name('store');
Route::get('/products/save', 'ProductsController@store');
Route::get('/products/edit/{id}', 'ProductsController@edit')->name('products-edit');
Route::post('/products/update/{id}', 'ProductsController@update')->name('products-update');
Route::get('/products/zipcode/{id}', 'ProductsController@zipcode');
Route::get('/products/productzipcode/{id}', 'ProductsController@productzipcode');
Route::get('/products/{id}/destroy', 'ProductsController@destroy')->name('product-delete');


Route::get('/pickups', 'PickupsController@index')->name('pickups');
Route::get('/pickups/productzipcode/{id}', 'PickupsController@productzipcode');
Route::get('/pickups/activepickup/{id}', 'PickupsController@activepickup');



Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

