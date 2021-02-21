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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');
Route::get('/google',[App\Http\Controllers\Auth\LoginController::class,'loginGoogle'])->name('google.login');
Route::get('/callback',[App\Http\Controllers\Auth\LoginController::class,'loginGoogleCallback']);

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
	return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth','namespace' => 'App\Http\Controllers'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile','ProfileController@edit')->name('profile.edit');
	Route::put('profile','ProfileController@update')->name('profile.update');
	Route::put('profile/password','ProfileController@password')->name('profile.password');


  // Estimate Routes
  Route::get('estimate', 'EstimateController@index')->name('estimate.index');
  Route::post('estimate/store', 'EstimateController@store')->name('estimate.store');
  Route::post('estimate/update', 'EstimateController@update')->name('estimate.update');
  Route::post('estimate/get', 'EstimateController@get')->name('estimate.get');
  Route::post('estimate/get/one', 'EstimateController@getOne')->name('estimate.get.one');
  Route::post('estimate/delete', 'EstimateController@destroy')->name('estimate.delete');
  


  //estimate item routes
  Route::get('estimate/item/{id}','EstimateItemController@index')->name('estimate.item.add');
  Route::post('estimate/item/get','EstimateItemController@getAllEstimateItemData')->name('estimate.items.get');
  Route::post('estimate/item/get/one','EstimateItemController@getOne')->name('estimate.item.get.one');
  Route::post('estimate/item/store','EstimateItemController@store')->name('estimate.item.store');
  

  // jbs management routes start


  // maap routes
  

  // jbs management routes end

});
