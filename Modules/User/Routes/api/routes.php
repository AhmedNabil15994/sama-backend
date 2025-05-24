<?php


Route::controller('FCMTokenController')->group(function () {
    Route::post('fcm-token', 'store');
});

Route::controller('FavouriteCourseController')->prefix('favourite-courses')->group(function () {
    Route::get('/', 'list');
    Route::post('{courseId}', 'favouriteCourse');
});

Route::controller('UserProfileController')->group(function () {
    Route::get('/my-courses', 'myCourses');
    Route::get('/my-notes', 'myNotes');
    Route::get('/my-packages', 'myPackages');
});
