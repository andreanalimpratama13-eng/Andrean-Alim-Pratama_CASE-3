<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;

// Halaman utama
Route::get('/', function () {
    return redirect('/login');
});

// Halaman Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// Halaman Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

// Halaman Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Route Manajemen Barang
Route::middleware('auth')->group(function () {
    Route::get('barangs/sampah', [BarangController::class, 'trash'])
        ->name('barangs.trash');
    Route::post('barangs/{id}/restore', [BarangController::class, 'restore'])
        ->name('barangs.restore');
    Route::delete('barangs/{id}/force-delete', [BarangController::class, 'forceDelete'])
        ->name('barangs.force-delete');
    Route::resource('barangs', BarangController::class)->except('show');
});