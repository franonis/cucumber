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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => '/search'], function () {
    Route::get('/', 'PublicController@showSearchPage');
    Route::post('/', 'PublicController@searchResult');
    Route::get('/gene/{name}', 'PublicController@searchGene');

    Route::post('/', 'PublicController@searchResult');
    Route::get('/protein/{name}', 'PublicController@searchProtein');
});
