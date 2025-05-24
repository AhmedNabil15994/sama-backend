<?php

Route::group(['prefix' => 'semesters'], function () {
    Route::get('/', 'SemesterController@index')
        ->name('trainer.semesters.index')
        ->middleware(['permission:show_semesters']);

    Route::get('datatable', 'SemesterController@datatable')
        ->name('trainer.semesters.datatable')
        ->middleware(['permission:show_semesters']);

    Route::get('create', 'SemesterController@create')
        ->name('trainer.semesters.create')
        ->middleware(['permission:add_semesters']);

    Route::post('/', 'SemesterController@store')
        ->name('trainer.semesters.store')
        ->middleware(['permission:add_semesters']);

    Route::get('{id}/edit', 'SemesterController@edit')
        ->name('trainer.semesters.edit')
        ->middleware(['permission:edit_semesters']);

    Route::put('{id}', 'SemesterController@update')
        ->name('trainer.semesters.update')
        ->middleware(['permission:edit_semesters']);

    Route::delete('{id}', 'SemesterController@destroy')
        ->name('trainer.semesters.destroy')
        ->middleware(['permission:delete_semesters']);

    Route::get('deletes', 'SemesterController@deletes')
        ->name('trainer.semesters.deletes')
        ->middleware(['permission:delete_semesters']);

    Route::get('{id}', 'SemesterController@show')
        ->name('trainer.semesters.show')
        ->middleware(['permission:show_semesters']);
});
