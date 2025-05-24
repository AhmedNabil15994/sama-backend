<?php

//use Vsch\TranslationManager\Translator;


Route::group(['prefix' => '/' , 'middleware' => [ 'trainer.auth','check.permission']], function() {

  Route::get('/' , 'DashboardController@index')->name('trainer.home');

//  Route::group(['prefix' => 'translations'], function () {
//      Translator::routes();
//  });

  Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

});
