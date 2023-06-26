<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use \App\Http\Controllers\CustomerController;
use \App\Http\Controllers\InvoiceController;
use \App\Http\Controllers\InvoiceItemController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});


Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::prefix('customer')->name('customer.')->group(function(){
        Route::post('get',[CustomerController::class,'get'])->name('get');
        Route::post('store',[CustomerController::class,'store'])->name('store');
        Route::post('update/{customer}',[CustomerController::class,'update'])->name('update');
        Route::post('delete/{customer}',[CustomerController::class,'delete'])->name('delete');
    });

    Route::prefix('invoice')->name('invoice.')->group(function(){
        Route::post('get',[InvoiceController::class,'get'])->name('get');
        Route::post('show/{invoice}',[InvoiceController::class,'show'])->name('get');
        Route::post('store',[InvoiceController::class,'store'])->name('store');
        Route::post('update/{invoice}',[InvoiceController::class,'update'])->name('update');
        Route::post('delete/{invoice}',[InvoiceController::class,'delete'])->name('delete');
    });

    Route::prefix('invoice-item')->name('invoice-item.')->group(function(){
        Route::post('store/{invoice}',[InvoiceItemController::class,'store'])->name('store');
        Route::post('delete/{invoice}',[InvoiceItemController::class,'delete'])->name('delete');
    });

});
