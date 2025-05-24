<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'setting'], function () {

    // Show Settings Form
    Route::get('/', 'SettingController@index')
    ->name('trainer.setting.index');

    // Update Settings
    Route::post('/', 'SettingController@update')
    ->name('trainer.setting.update');

});
