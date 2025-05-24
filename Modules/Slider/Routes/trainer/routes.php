<?php

Route::group(['prefix' => 'sliders'], function () {
    Route::get('/', 'SliderController@index')
    ->name('trainer.sliders.index');

    Route::get('datatable', 'SliderController@datatable')
    ->name('trainer.sliders.datatable');

    Route::get('create', 'SliderController@create')
    ->name('trainer.sliders.create');

    Route::post('/', 'SliderController@store')
    ->name('trainer.sliders.store');

    Route::get('{id}/edit', 'SliderController@edit')
    ->name('trainer.sliders.edit');

    Route::put('{id}', 'SliderController@update')
    ->name('trainer.sliders.update');

    Route::delete('{id}', 'SliderController@destroy')
    ->name('trainer.sliders.destroy');

    Route::get('deletes', 'SliderController@deletes')
    ->name('trainer.sliders.deletes');

    Route::get('{id}', 'SliderController@show')
    ->name('trainer.sliders.show');
});
