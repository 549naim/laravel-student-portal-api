<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// public route
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/change_password', [UserController::class, 'change_password']);
    Route::post('/post_level', [CourseController::class, 'post_level']);
    Route::get('/all_level', [CourseController::class, 'all_level']);
   
    Route::get('/show_level/{id}', [CourseController::class, 'show_level']);
   
    Route::get('/all_courses', [CourseController::class, 'all_courses']);
    Route::post('/post_courses', [CourseController::class, 'post_courses']);

    Route::post('/edit_level/{id}', [CourseController::class, 'edit_level']);
    
});

Route::post('/reset_password', [PasswordResetController::class, 'password_reset_email']);
Route::post('/reset_password_token/{token}', [PasswordResetController::class, 'reset']);
