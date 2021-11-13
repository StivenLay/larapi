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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', 'RegisterController@register');
Route::post('/login', 'LoginController@login');
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/user', 'UserController@user');

    // kategori
    Route::get('/kategori', 'KategoriController@index'); //read all
    Route::get('/kategori/{id}', 'KategoriController@show'); //read detail
    Route::post('/kategori', 'KategoriController@store'); //create
    Route::post('/kategori/{id}', 'KategoriController@update'); //update
    Route::delete('/kategori/{id}', 'KategoriController@destroy'); //delete


    // barang
    Route::get('/barang', 'BarangController@index');
    Route::get('/barang/{id}', 'BarangController@show');
    // Route::post('/barang', 'BarangController@store');
});
