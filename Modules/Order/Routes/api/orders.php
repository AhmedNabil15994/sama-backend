<?php

use Illuminate\Support\Facades\Route;
//
Route::group(['middleware' => [ 'auth:sanctum' ]], function () {
    Route::post('/checkout', 'OrderController@create')->name('api.order.create');
});

Route::get('success-upayment', 'OrderController@successUpayment')->name('api.orders.success.upayment');


//Route::get('addTestAccountToAllCourses', 'OrderController@addTestAccountToAllCourses')->name('api.orders.addTestAccountToAllCourses');

//Route::get('removeTestAccountToAllCourses', 'OrderController@removeTestAccountToAllCourses')->name('api.orders.removeTestAccountToAllCourses');
