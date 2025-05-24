<?php
use Illuminate\Support\Facades\Route;

Route::name('trainer.')->group( function () {

    Route::get('states/datatable'	,'StateController@datatable')
        ->name('states.datatable');

    Route::get('states/deletes'	,'StateController@deletes')
        ->name('states.deletes');

    Route::resource('states','StateController')->names('states');
});
