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


//Route::middleware('auth:api')
    Route::prefix('pages')
    ->group(function () {
        Route::get('', 'PagesController@index')->name('pages.index');
        Route::post('', 'PagesController@create')->name('pages.create');
        Route::get('{id}', 'PagesController@get')->name('pages.get');
        Route::put('{id}', 'PagesController@update')->name('pages.update');

        Route::prefix('{pageId}/blocks')
            ->group(function () {
                Route::get('', 'PageBlockController@index')->name('pages.blocks.index');
                Route::post('', 'PageBlockController@create')->name('pages.blocks.create');
                Route::put('', 'PageBlockController@updateOrder')->name('pages.blocks.order');
                Route::get('{id}', 'PageBlockController@get')->name('pages.blocks.get');
                Route::put('{id}', 'PageBlockController@update')->name('pages.blocks.update');
            });
    });

Route::prefix('blocks')
    ->group(function () {
        Route::get('', 'BlockController@index')->name('blocks.index');
        Route::post('', 'BlockController@create')->name('blocks.create');
        Route::get('{name}', 'BlockController@get')->name('blocks.get');
    });

Route::get('theme', 'ThemeController@index')->name('theme.index');