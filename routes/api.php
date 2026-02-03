<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\GradeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Course routes
    Route::apiResource('courses', CourseController::class);
    Route::get('/courses/{course}/students', [CourseController::class, 'enrolledStudents']);

    // Enrollment routes
    Route::apiResource('enrollments', EnrollmentController::class);
    Route::get('/my-enrollments', [EnrollmentController::class, 'myEnrollments']);
    Route::get('/my-courses', [EnrollmentController::class, 'myCourses']);

    // Grade routes
    Route::apiResource('grades', GradeController::class);
    Route::get('/my-grades', [GradeController::class, 'myGrades']);
    Route::get('/courses/{course}/grades', [GradeController::class, 'courseGrades']);
});