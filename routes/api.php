<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\API\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('students', [StudentController::class, 'index']);
Route::post('students', [StudentController::class, 'store']);
Route::get('students/{id}', [StudentController::class, 'show']);
Route::get('students/{id}/edit', [StudentController::class, 'edit']);
Route::put('students/{id}/edit', [StudentController::class, 'update']);
Route::delete('students/{id}/delete', [StudentController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/books', [BookController::class, 'index']);

Route::post('/loans', [LoanController::class, 'store']);
Route::get('/loans', [LoanController::class, 'index']);
Route::post('/loans/{id}/return', [LoanController::class, 'returnLoan']);
Route::delete('/loans/{id}', [LoanController::class, 'cancelLoan']);

Route::post('/register', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'signin']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'destroy']);
Route::middleware('auth:sanctum')->put('/user/update', [AuthController::class, 'updateProfile']);
Route::middleware('auth:sanctum')->put('/user/password', [AuthController::class, 'updatePassword']);
Route::middleware('auth:sanctum')->post('/user/update-profile-image', [AuthController::class, 'updateProfileImage']);
Route::middleware('auth:sanctum')->get('/user/profile-image', [AuthController::class, 'getProfileImage']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites', [FavoriteController::class, 'destroy']);
});

