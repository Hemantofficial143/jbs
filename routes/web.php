<?php

use Illuminate\Support\Facades\Auth;
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
	return (Auth::user())?redirect('/home'):view('welcome');
});
Route::get('/estimate-pdf',function(){
	$data = [];
	$data['name'] = 'Hemant Jangid';
	$data['mobile'] = '8200316776';
	$data['address'] = "Sola,Ahmedabad";
	$data['email'] = 'rj.hemantjangid@gmail.com';
	$data['created_date'] = '20-02-2021';
	return view('templates.estimate',['estimate' =>$data]);
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
  Route::get('estimate/export/{id}','EstimateItemController@exportPdf')->name('estimate.export');
  

  // customer routes
  Route::group(['prefix' => 'customer'],function(){
	Route::get('/','CustomerController@index')->name('customer.index');
	Route::post('store','CustomerController@store')->name('customer.store');
	Route::post('get','CustomerController@get')->name('customer.get');
	Route::post('get/one','CustomerController@getOne')->name('customer.get.one');
	Route::post('delete','CustomerController@destroy')->name('customer.delete');

	// customer bills list route
	Route::group(['prefix' => 'bills'],function(){
		Route::get('{id}','BillController@index')->name('bill.index');
		Route::post('store','BillController@store')->name('bill.store');
		Route::post('update','BillController@update')->name('bill.update');
		Route::post('get','BillController@get')->name('bill.get');
		Route::post('get/one','BillController@getOne')->name('bill.get.one');
		Route::post('delete','BillController@destroy')->name('bill.delete');
	});

	
	
  });

  // bill routes
  
  

  


  // jbs management routes start


  // maap routes
  Route::group(['middleware' => 'admin'],function(){

	Route::group(['prefix'=> 'setting'],function(){	
		Route::get('/maap','MaapController@index')->name('setting.maap');
		Route::post('/maap/get','MaapController@getAllData')->name('setting.maap.get');
		Route::post('/maap/get/one','MaapC	ontroller@getOne')->name('maap.get.one');
		Route::post('/maap/store','MaapController@store')->name('maap.store');
		Route::post('/maap/delete','MaapController@destroy')->name('maap.delete');
	});

  });
  
  

  // jbs management routes end

});
