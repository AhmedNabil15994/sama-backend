<?php

use Illuminate\Support\Facades\Route;

Route::get('/levels', 'LevelController@levels')->name('frontend.levels.index');
    Route::get('/levels/{id}', 'LevelController@showLevel')->name('frontend.levels.show');


Route::get('courses', 'CourseController@index')->name('frontend.courses');
    Route::get('courses/{slug}', 'CourseController@show')->name('frontend.courses.show');
    Route::get('get-review-questions', 'CourseController@getReviewQuestions')->name('frontend.courses.reviewQuestions');

    Route::get('get-lesson-content', 'CourseController@getLessonContent')->name('frontend.courses.getLessonContent');

    Route::post('courses/{slug}/quizAnswers', 'CourseController@quizAnswers')->name('frontend.courses.quizAnswers');
    Route::post('courses/{id}/storeReviewQuestion', 'ReviewQuestionController@storeReviewQuestion')->name('frontend.courses.storeReviewQuestion');
    Route::post('courses/storeReviewQuestionAnswer/{question_id}', 'ReviewQuestionController@storeReviewQuestionAnswer')->name('frontend.courses.storeReviewQuestionAnswer');
    Route::post('courses/review/{id}', 'CourseReviewController@CourseReview')->name('frontend.courses.review');

    Route::get('video-details', 'VideoController@videoResponse')->name('frontend.videos');



    Route::post('/sync-user-view', 'UserVideoController')->name('course.make.view');
    Route::get('/sync-user-view', 'UserVideoController')->name('api.course.make.view');
Route::get('/course-live/{id}', 'CourseController@live')->name('course.live');
Route::get('/course-certification/{id}', 'CourseController@CourseCertification')->name('frontend.course.certification');

Route::post('courses/buy/{courseId}', 'CourseController@buy')->name('frontend.courses.buy');

Route::get('notes', 'CourseController@notes')->name('frontend.notes.index');
