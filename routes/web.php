<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LostBookController;
use App\Http\Controllers\ExitBookController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EntryBookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StockManagementController;

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
    // Route::patch('/books/{id}/activate', [BookController::class, 'activate'])->name('books.activate');
    Route::get('/books/inactive', [BookController::class, 'inactive'])->name('books.inactive');
    Route::put('/books/restore/{id}', [BookController::class, 'restore'])->name('books.restore');

    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/admin/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/admin/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/admin/loans/{id}', [LoanController::class, 'show'])->name('loans.show');
    Route::post('/admin/loans/{id}/confirm-return', [LoanController::class, 'confirmReturn'])->name('loans.confirmReturn');

    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('/admin/profile', [AdminAuthController::class, 'editProfile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminAuthController::class, 'updateProfile'])->name('admin.profile.update');

    Route::get('/admin/password', [AdminAuthController::class, 'editPassword'])->name('admin.password');
    Route::post('/admin/password', [AdminAuthController::class, 'updatePassword'])->name('admin.password.update');

    Route::get('/admin/dashboard', [DashboardController::class, 'viewDashboard'])->name('admin.dashboard');

    Route::get('/predictions', [PredictionController::class, 'index'])->name('predictions.index');
    Route::post('/predictions/refresh', [PredictionController::class, 'refresh'])->name('predictions.refresh');

    // Supplier Routes
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Purchase Routes
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchases/{id}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::put('/purchases/{id}', [PurchaseController::class, 'update'])->name('purchases.update');
    Route::delete('/purchases/{id}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');

    Route::get('/entry-books', [EntryBookController::class, 'index'])->name('entry_books.index');
    Route::get('/entry-books/create', [EntryBookController::class, 'create'])->name('entry_books.create');
    Route::post('/entry-books', [EntryBookController::class, 'store'])->name('entry_books.store');
    Route::get('/entry-books/{id}/edit', [EntryBookController::class, 'edit'])->name('entry_books.edit');
    Route::put('/entry-books/{id}', [EntryBookController::class, 'update'])->name('entry_books.update');
    Route::delete('/entry-books/{id}', [EntryBookController::class, 'destroy'])->name('entry_books.destroy');

    Route::get('/exit-books', [ExitBookController::class, 'index'])->name('exit_books.index');
    Route::post('/exit-books', [ExitBookController::class, 'store'])->name('exit_books.store');
    Route::get('/exit-books/{id}/edit', [ExitBookController::class, 'edit'])->name('exit_books.edit');
    Route::put('/exit-books/{id}', [ExitBookController::class, 'update'])->name('exit_books.update');
    Route::delete('/exit-books/{id}', [ExitBookController::class, 'destroy'])->name('exit_books.destroy');

    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    Route::get('/stock-management', [StockManagementController::class, 'index'])->name('stock.management');

    /*
    |--------------------------------------------------------------------------
    | Employee Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');        // list
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create'); // form tambah
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');   // simpan baru
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');       // detail
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');  // form edit
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');   // update
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy'); // hapus

    /*
    |--------------------------------------------------------------------------
    | Payroll Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/payrolls', [PayrollController::class, 'index'])->name('payrolls.index');
    Route::get('/payrolls/create', [PayrollController::class, 'create'])->name('payrolls.create');
    Route::post('/payrolls/store', [PayrollController::class, 'store'])->name('payrolls.store');
    Route::get('/payrolls/{id}', [PayrollController::class, 'show'])->name('payrolls.show');
    Route::get('/payrolls/{id}/edit', [PayrollController::class, 'edit'])->name('payrolls.edit');
    Route::put('/payrolls/{id}', [PayrollController::class, 'update'])->name('payrolls.update');
    Route::delete('/payrolls/{id}', [PayrollController::class, 'destroy'])->name('payrolls.destroy');
});

Route::middleware('authenticatedAdminMiddleware')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
    Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/admin/register', [AdminAuthController::class, 'register']);
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
    Route::post('/forgot-password', [AdminAuthController::class, 'submitForgotPassword']);

    Route::get('/verify-code', [AdminAuthController::class, 'showVerificationForm'])->name('verify.code');
    Route::post('/verify-code', [AdminAuthController::class, 'submitVerificationCode']);

    Route::get('/reset-password', [AdminAuthController::class, 'showResetPasswordForm'])->name('reset.password');
    Route::post('/reset-password', [AdminAuthController::class, 'submitResetPassword']);
});

// Route baru untuk registered students
Route::get('admin/registered-students', [AdminAuthController::class, 'registeredStudents'])->name('admin.registered_students');

Route::get('/chat/{user}', function($userId) {
    $user = App\Models\User::findOrFail($userId);
    return view('chat', compact('user'));
})->name('chat.show');
Route::get('/chat/messages/{user}', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
Route::post('/chat/send/{user}', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');