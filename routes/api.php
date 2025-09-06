<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\BookDetailController;
use App\Http\Controllers\API\ReservationController;

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
// Route::get('/books', [BookController::class, 'index']);
Route::middleware('auth:sanctum')->get('/books', [BookController::class, 'index']);
// Route::middleware('auth:sanctum')->get('/books/{id}', [BookController::class, 'show']);
Route::middleware('auth:sanctum')->get('/book-details/{book}', [BookController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::post('/loans', [LoanController::class, 'store']);
    // Route::get('/loans', [LoanController::class, 'index']);
    // Route::post('/loans/{id}/return', [LoanController::class, 'returnLoan']);
    // Route::delete('/loans/{id}', [LoanController::class, 'cancelLoan']);
    // Route::get('/loans/check-active', [LoanController::class, 'checkActiveLoan']);

    // Routes Peminjaman (Existing)
    Route::post('/loans', [LoanController::class, 'store']);
    Route::get('/loans', [LoanController::class, 'index']);
    // Route::post('/loans/{id}/return', [LoanController::class, 'returnLoan']);
    Route::delete('/loans/{id}', [LoanController::class, 'cancelLoan']);
    Route::get('/loans/check-active', [LoanController::class, 'checkActiveLoan']);
    Route::post('/loans/{id}/request-return', [LoanController::class, 'requestReturn']); // <-- ROUTE BARU

    // Perubahan: Routes Reservasi (Baru)
    Route::get('/my-reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/books/{id}', [ReservationController::class, 'show']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);

    // --- PERBAIKAN: Gunakan route baru ini untuk detail buku ---
    // Route::get('/book-details/{book}', [BookDetailController::class, 'show']);
});

Route::post('/register', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'signin']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'destroy']);
Route::middleware('auth:sanctum')->put('/user/update', [AuthController::class, 'updateProfile']);
Route::middleware('auth:sanctum')->put('/user/password', [AuthController::class, 'updatePassword']);
Route::middleware('auth:sanctum')->post('/user/update-profile-image', [AuthController::class, 'updateProfileImage']);
Route::middleware('auth:sanctum')->get('/user/profile-image', [AuthController::class, 'getProfileImage']);
Route::post('/forgot-password', [AuthController::class, 'getVerificationCode']);
Route::post('/verify-code', [AuthController::class, 'validateVerificationCode']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/users', [AuthController::class, 'showAllUser']);         // Semua user
Route::get('/users/{id}', [AuthController::class, 'showUserById']);   // User by ID
Route::get('/non-users', [AuthController::class, 'showNonUser']);     // User selain 'user'

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites', [FavoriteController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chat/messages/{user}', [ChatController::class, 'getMessages']);
    Route::post('/chat/send/{user}', [ChatController::class, 'sendMessage']);
});

