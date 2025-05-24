<?php
use Illuminate\Support\Facades\Route;


Route::name('trainer.')->group( function () {

    Route::get('countries/datatable'	,'CountryController@datatable')
        ->name('countries.datatable');

    Route::get('countries/deletes'	,'CountryController@deletes')
        ->name('countries.deletes');

    Route::resource('countries','CountryController')->names('countries');

});
