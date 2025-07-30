<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('adminMiddleware')->group(function () {
    Route::get('/admin/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/admin/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/admin/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/admin/students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/admin/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/admin/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/admin/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    Route::get('/admin/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/admin/books/add', [BookController::class, 'create'])->name('books.create');
    Route::post('/admin/books/store', [BookController::class, 'store'])->name('books.store');
    Route::get('/admin/books/{id}', [BookController::class, 'show'])->name('books.show');
    Route::get('/admin/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/admin/books/{id}/update', [BookController::class, 'update'])->name('books.update');
    Route::delete('/admin/books/{id}/delete', [BookController::class, 'destroy'])->name('books.destroy');

    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/admin/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/admin/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/admin/loans/{id}', [LoanController::class, 'show'])->name('loans.show');

    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('/admin/dashboard', [DashboardController::class, 'viewDashboard'])->name('admin.dashboard');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register']);