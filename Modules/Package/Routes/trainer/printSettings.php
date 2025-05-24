<?php

Route::group(['prefix' => 'print-settings'], function () {
    Route::get('/', 'PrintSettingController@index')
        ->name('trainer.print-settings.index');

    Route::get('datatable', 'PrintSettingController@datatable')
        ->name('trainer.print-settings.datatable');

    Route::get('create', 'PrintSettingController@create')
        ->name('trainer.print-settings.create');

    Route::post('/', 'PrintSettingController@store')
        ->name('trainer.print-settings.store');

    Route::get('{id}/edit', 'PrintSettingController@edit')
        ->name('trainer.print-settings.edit');

    Route::put('{id}', 'PrintSettingController@update')
        ->name('trainer.print-settings.update');

    Route::delete('{id}', 'PrintSettingController@destroy')
        ->name('trainer.print-settings.destroy');

    Route::get('deletes', 'PrintSettingController@deletes')
        ->name('trainer.print-settings.deletes');

    Route::get('{id}', 'PrintSettingController@show')
        ->name('trainer.print-settings.show');
});

Route::group(['prefix' => 'print'], function () {

  	Route::get('/' ,'PrintController@index')
  	->name('trainer.print.index');

     Route::any('/render-print' ,'PrintController@renderPrint')
     ->name('trainer.print.render.print');
});
