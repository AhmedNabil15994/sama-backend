<?php

Route::group(['prefix' => 'coupons'], function () {

    Route::get('/', 'CouponController@index')
        ->name('trainer.coupons.index')
        ;   // ->middleware(['permission:show_coupon']);

    Route::get('datatable', 'CouponController@datatable')
        ->name('trainer.coupons.datatable')
        ;   // ->middleware(['permission:show_coupon']);

    Route::get('create', 'CouponController@create')
        ->name('trainer.coupons.create')
        ;   // ->middleware(['permission:add_coupon']);

    Route::post('store', 'CouponController@store')
        ->name('trainer.coupons.store')
        ;   // ->middleware(['permission:add_coupon']);

    Route::get('{id}/edit', 'CouponController@edit')
        ->name('trainer.coupons.edit')
        ;   // ->middleware(['permission:edit_coupon']);

    Route::put('{id}', 'CouponController@update')
        ->name('trainer.coupons.update')
        ;   // ->middleware(['permission:edit_coupon']);

    Route::get('{id}/clone', 'CouponController@clone')
        ->name('trainer.coupons.clone')
        ;   // ->middleware(['permission:add_coupon']);

    Route::delete('{id}', 'CouponController@destroy')
        ->name('trainer.coupons.destroy')
        ;   // ->middleware(['permission:delete_coupon']);

    Route::get('deletes', 'CouponController@deletes')
        ->name('trainer.coupons.deletes')
        ;   // ->middleware(['permission:delete_coupon']);

    Route::get('{id}', 'CouponController@show')
        ->name('trainer.coupons.show')
        ;   // ->middleware(['permission:show_coupon']);

});
