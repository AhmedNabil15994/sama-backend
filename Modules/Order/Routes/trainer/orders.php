<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders'], function () {

    Route::get('/note_orders', 'OrderController@note_orders')
        ->name('trainer.orders.note_orders')
        ->middleware(['permission:show_orders']);

    Route::get('/course_orders', 'OrderController@course_orders')
        ->name('trainer.orders.course_orders')
        ->middleware(['permission:show_orders']);




});
