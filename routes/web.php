<?php

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
// Auth::routes();
Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function() {
	Route::get('/', 'DashboardController@index');
	Route::resource('products', 'ProductController');
	Route::get('products/{id}/gallery', 'ProductController@gallery')->name('products.gallery');
	Route::resource('product-galleries', 'ProductGalleryController');
	Route::resource('transactions', 'TransactionController');
	Route::get('transactions/{id}/set-status', 'TransactionController@setStatus')->name('transactions.status');
});


