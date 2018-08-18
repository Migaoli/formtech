<?php

use Illuminate\Http\Request;

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


Route::middleware('auth:api')
    ->prefix('pages')
    ->group(function () {
        Route::get('{id}', 'PagesController@get')->name('pages.get');
        Route::post('', 'PagesController@create')->name('pages.create');
    });

Route::prefix('blocks')
    ->group(function () {
        Route::get('', 'BlockController@index')->name('blocks.index');
        Route::post('', 'BlockController@create')->name('blocks.create');
        Route::get('{name}', 'BlockController@get')->name('blocks.get');
    });