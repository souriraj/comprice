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

/*Route::get('/', function(){
	return view('welcome');
});
*/
Route::get('/', 'HomeController@index');
Route::get('user/profile', 'UserController@index');
Route::post('user/profile', 'UserController@add');
Route::put('user/profile', 'UserController@edit');
Route::get('admin/affiliate-product', 'AffiliateProductController@index');
Route::get('admin/affiliate-product/update/{id}', 'AffiliateProductController@update');
Route::get('shop', 'ShopController@index');
Route::get('flipkart/categories', 'AffiliateProductController@getFlipkartCategoriesUrl');
Route::get('flipkart/categoryUrl', 'AffiliateProductController@callflipkartCategoriesUrl');
Route::get('flipkart/runNextUrl', 'AffiliateProductController@checkAndRunNextUrl');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
