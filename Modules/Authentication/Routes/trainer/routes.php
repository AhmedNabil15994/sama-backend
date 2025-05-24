<?php

Route::group(['prefix' => 'login'], function () {
    // if (env('LOGIN')):

    // Show Login Form
    Route::get('/', 'LoginController@showLogin')
        ->name('trainer.login')
        ->middleware('guest');

    // Submit Login
    Route::post('/', 'LoginController@postLogin')->name('trainer.login.post');

    // endif;
});


Route::group(['prefix' => 'logout','middleware' => 'trainer.auth'], function () {

    // Logout
    Route::any('/', 'LoginController@logout')
    ->name('trainer.logout');
});
