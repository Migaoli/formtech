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

Route::get('cms', 'HomeController@index');
Route::get('cms/{any}', 'HomeController@index')->where('any', '.*');

Route::get('images', 'ImageController@get');
Route::post('images', 'ImageController@post');

Route::get('test', 'TestController@index');
