<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'order-statuses'], function () {
    Route::get('/', 'OrderStatusController@index')
    ->name('trainer.order-statuses.index')
    ->middleware(['permission:show_order_statuses']);

    Route::get('datatable', 'OrderStatusController@datatable')
    ->name('trainer.order-statuses.datatable')
    ->middleware(['permission:show_order_statuses']);

    Route::get('create', 'OrderStatusController@create')
    ->name('trainer.order-statuses.create')
    ->middleware(['permission:add_order_statuses']);

    Route::post('/', 'OrderStatusController@store')
    ->name('trainer.order-statuses.store')
    ->middleware(['permission:add_order_statuses']);

    Route::get('{id}/edit', 'OrderStatusController@edit')
    ->name('trainer.order-statuses.edit')
    ->middleware(['permission:edit_order_statuses']);

    Route::put('{id}', 'OrderStatusController@update')
    ->name('trainer.order-statuses.update')
    ->middleware(['permission:edit_order_statuses']);

    Route::delete('{id}', 'OrderStatusController@destroy')
    ->name('trainer.order-statuses.destroy')
    ->middleware(['permission:delete_order_statuses']);

    Route::get('deletes', 'OrderStatusController@deletes')
    ->name('trainer.order-statuses.deletes')
    ->middleware(['permission:delete_order_statuses']);

    Route::get('{id}', 'OrderStatusController@show')
    ->name('trainer.order-statuses.show')
    ->middleware(['permission:show_order_statuses']);
});
