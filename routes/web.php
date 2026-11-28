<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

// Redirect halaman utama ke login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard & Profil (Bisa diakses Admin & Petugas)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Fitur Operasional (Admin & Petugas)
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    Route::resource('borrowings', BorrowingController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

    // Khusus Admin (Terkunci oleh Middleware 'admin')
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';