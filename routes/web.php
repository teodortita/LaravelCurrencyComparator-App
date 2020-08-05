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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('general.index');
})->name('general.index');

Route::group(['prefix' => 'rates'], function() {
    Route::get('{param1}/{param2}/{param3}/{startYear}/{endYear}', [
        'uses' => 'RateChartController@getIndex',
        'as' => 'rates.index'
    ]);

    Route::post('', [
        'uses' => 'RateChartController@index',
        'as' => 'rates.index'
    ]);
});

Route::group(['prefix' => 'crypto'], function() {
    Route::get('{param1}/{param2}', [
        'uses' => 'CryptoController@getIndex',
        'as' => 'crypto.index'
    ]);
    
    Route::post('', [
        'uses' => 'CryptoController@index',
        'as' => 'crypto.index'
    ]);
});

Route::group(['prefix' => 'calculate'], function() {
    Route::get('rates', [
        'uses' => 'RateChartController@calculate',
        'as' => 'rates.calculate'
    ]);
    
    Route::get('crypto', [
        'uses' => 'CryptoController@calculate',
        'as' => 'crypto.calculate'
    ]);
});
