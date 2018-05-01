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
    Route::get('/protein/{name}', 'PublicController@searchProtein');
    Route::get('/uniprot/{name}', 'PublicController@searchUniprot');
    Route::get('/location/{location}', 'PublicController@searchLocation');
});

Route::get('/protein/{protein}/sequence/download', 'PublicController@downloadProteinSequence');
Route::get('/proteins/compare', 'PublicController@compareProteins');

Route::get('/tools/blast', 'PublicController@blastEntry');
Route::post('/tools/blast/run', 'PublicController@runBlast');
Route::get('/tools/blast/{job}', 'PublicController@checkBlastResult');
