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



Route::get('theme', 'ThemeController@index')->name('theme.index');

Route::prefix('images')
    ->group(function () {
        Route::get('', 'ImageController@get')->name('images.get');
        Route::post('', 'ImageController@post')->name('images.upload');
    });