<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('produk', ProdukController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('penjualan', PenjualanController::class);
    Route::resource('detailpenjualan', DetailPenjualanController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/get-total-harga/{penjualanID}', [DetailPenjualanController::class, 'getTotalHarga'])
    ->name('detailpenjualan.getTotalHarga');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::get('penjualan/export-pdf', [PenjualanController::class, 'exportPDF'])->name('penjualan.exportPDF');
Route::get('detailpenjualan/export-pdf', [DetailPenjualanController::class, 'exportPDF'])->name('detailpenjualan.exportPDF');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

