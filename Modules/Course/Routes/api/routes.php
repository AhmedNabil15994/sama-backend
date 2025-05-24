<?php

Route::group(['prefix' => 'courses'], function () {

    Route::get('/'  , 'CourseController@index');
    Route::get('/run-video/{lessonId}/{type}'  , 'CourseController@runVideo')->name('api.run.video');
    Route::get('/{id}'  , 'CourseController@show');
    Route::get('/{id}/resources'  , 'CourseController@courseResources');
    Route::post('/buy/{courseId}', 'CourseController@buyCourseInApp')->name('api.courses.buy');

});

Route::group(['prefix' => 'course-review-questions'], function () {

    Route::get('/{courseId}'  , 'CourseReviewController@index');
    Route::post('/{courseId}'  , 'CourseReviewController@createQuestion');

    Route::get('/'  , 'CourseReviewController@getReviews');
    Route::post('/'  , 'CourseReviewController@createNewQuestion');

    Route::post('answer/{questionId}'  , 'CourseReviewController@createAnswer');
    Route::get('/get-question-answers/{questionId}'  , 'CourseReviewController@getQuestionAnswers');

});

Route::post('lesson/complate/{lessonId}', 'CourseController@complateLesson')->name('api.lesson.complate');
