<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PeminjamController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. Halaman Utama dengan Logika Redirect Otomatis [cite: 170-177]
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role == 'admin') return redirect()->route('admin.dashboard');
        if ($role == 'petugas') return redirect()->route('petugas.dashboard');
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// 2. Grup Middleware Auth (Harus Login)
Route::middleware(['auth'])->group(function () {

    // Profil (Bisa diakses semua role) [cite: 189-191]
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROUTE ADMIN [cite: 192-196]
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    // ROUTE PETUGAS [cite: 197-200]
    Route::middleware(['role:petugas'])->group(function () {
        Route::get('/petugas/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
    });

    // ROUTE PEMINJAM 
    Route::middleware(['role:peminjam'])->group(function () {
        Route::get('/dashboard', [PeminjamController::class, 'index'])->name('dashboard');
    });
});

require __DIR__.'/auth.php';