<?php

Route::group(['prefix' => 'notifications'], function () {

    Route::get('/', 'NotificationController@index')
        ->name('trainer.notifications.index')
        ->middleware(['permission:show_notifications']);

    Route::get('datatable', 'NotificationController@datatable')
        ->name('trainer.notifications.datatable')
        ->middleware(['permission:show_notifications']);

    Route::get('create', 'NotificationController@notifyForm')
        ->name('trainer.notifications.create')
        ->middleware(['permission:add_notifications']);

    Route::post('send', 'NotificationController@push_notification')
        ->name('trainer.notifications.store')
        ->middleware(['permission:add_notifications']);

    Route::delete('{id}', 'NotificationController@destroy')
        ->name('trainer.notifications.destroy')
        ->middleware(['permission:delete_notifications']);

    Route::get('deletes', 'NotificationController@deletes')
        ->name('trainer.notifications.deletes')
        ->middleware(['permission:delete_notifications']);

});
