<?php

Route::group(['prefix' => 'semesters'], function () {
    Route::get('/', 'SemesterController@index')
        ->name('dashboard.semesters.index')
        ->middleware(['permission:show_semesters']);

    Route::get('datatable', 'SemesterController@datatable')
        ->name('dashboard.semesters.datatable')
        ->middleware(['permission:show_semesters']);

    Route::get('create', 'SemesterController@create')
        ->name('dashboard.semesters.create')
        ->middleware(['permission:add_semesters']);

    Route::post('/', 'SemesterController@store')
        ->name('dashboard.semesters.store')
        ->middleware(['permission:add_semesters']);

    Route::get('{id}/edit', 'SemesterController@edit')
        ->name('dashboard.semesters.edit')
        ->middleware(['permission:edit_semesters']);

    Route::put('{id}', 'SemesterController@update')
        ->name('dashboard.semesters.update')
        ->middleware(['permission:edit_semesters']);

    Route::delete('{id}', 'SemesterController@destroy')
        ->name('dashboard.semesters.destroy')
        ->middleware(['permission:delete_semesters']);

    Route::get('deletes', 'SemesterController@deletes')
        ->name('dashboard.semesters.deletes')
        ->middleware(['permission:delete_semesters']);

    Route::get('{id}', 'SemesterController@show')
        ->name('dashboard.semesters.show')
        ->middleware(['permission:show_semesters']);
});
