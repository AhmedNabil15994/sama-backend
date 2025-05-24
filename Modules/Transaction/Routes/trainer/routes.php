<?php

Route::group(['prefix' => 'transactions'], function () {
    Route::get('/', 'TransactionController@index')
    ->name('trainer.transactions.index')
    ->middleware(['permission:show_transactions']);

    Route::get('datatable', 'TransactionController@datatable')
    ->name('trainer.transactions.datatable')
    ->middleware(['permission:show_transactions']);
});
