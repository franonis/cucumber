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

Route::group(['prefix' => '/tools'], function () {
    Route::group(['prefix' => 'blast'], function () {
        Route::get('/', 'HomeController@getBlast')->name('blast');
        Route::get('config', 'HomeController@getBlastConfig');
        Route::any('sequence/validation', 'HomeController@validateBlastSeq');
        Route::post('dispatch', 'HomeController@dispatchBlastJob');
        Route::get('result/{jobname}', 'HomeController@showBlastResult')->name('blastresultview');
        Route::get('download/{jobname}/', 'HomeController@downloadBlastResult');
        Route::get('validate/jobname/{jobname}', 'HomeController@validateBlastJobName');
        Route::get('redo/{jobname}', 'HomeController@redoBlastJob');
    });
});
