<?php


Route::prefix('api/pages')
    ->namespace('App\Pages\Controllers')
    ->middleware('api')
    ->group(function () {
        Route::get('meta', 'PageMetaController@index')->name('pages.meta');

        Route::get('', 'PagesController@index')->name('pages.index');
        Route::post('', 'PagesController@create')->name('pages.create');
        Route::put('', 'PagesController@updateOrder')->name('pages.order');
        Route::get('{id}', 'PagesController@get')->name('pages.get');
        Route::put('{id}', 'PagesController@update')->name('pages.update');
        Route::delete('{id}', 'PagesController@delete')->name('pages.delete');

        Route::get('{id}/preview', 'PagePreviewController@get')->name('pages.preview.get');

        Route::prefix('{pageId}/blocks')
            ->group(function () {
                Route::get('', 'PageBlockController@index')->name('pages.blocks.index');
                Route::post('', 'PageBlockController@create')->name('pages.blocks.create');
                Route::put('', 'PageBlockController@updateOrder')->name('pages.blocks.order');
                Route::get('{id}', 'PageBlockController@get')->name('pages.blocks.get');
                Route::put('{id}', 'PageBlockController@update')->name('pages.blocks.update');
                Route::delete('{id}', 'PageBlockController@delete')->name('pages.blocks.delete');

                Route::get('{id}/preview', 'BlockPreviewController@show')->name('pages.blocks.preview');
            });
    });
