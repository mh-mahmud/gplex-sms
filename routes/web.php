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

Auth::routes();

Route::middleware('auth')->get('/', 'DashboardController@index')->name('dashboard');
Route::middleware('auth')->get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/alogin','Auth\LoginController@adminLogin');
Route::get('/logout','Auth\LoginController@logout');
Route::middleware('auth')->get('/users','UsersController@index')->name('users');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/authCheck/{account_id}/{extn}', 'DashboardController@getAuthCheck');
