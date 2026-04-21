<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PeminjamController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman Utama: Redirect ke dashboard sesuai role
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role == 'admin') return redirect()->route('admin.dashboard');
        if ($role == 'petugas') return redirect()->route('petugas.dashboard');
        return redirect()->route('peminjam.dashboard');
    }
    return view('welcome');
});

// Grup Middleware Auth (Harus Login)
Route::middleware(['auth'])->group(function () {
    
    // Profil (Bisa diakses semua role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ROUTE KHUSUS ADMIN ---
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // MANAJEMEN KATEGORI
        Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('admin.kategori');
        Route::post('/admin/kategori', [AdminController::class, 'storeKategori'])->name('admin.kategori.store');
        Route::get('/admin/kategori/{id}/edit', [AdminController::class, 'editKategori'])->name('admin.kategori.edit');
        Route::put('/admin/kategori/{id}', [AdminController::class, 'updateKategori'])->name('admin.kategori.update');
        Route::delete('/admin/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('admin.kategori.destroy');

        // MANAJEMEN ALAT
        Route::get('/admin/alat', [AdminController::class, 'alat'])->name('admin.alat');
        Route::post('/admin/alat', [AdminController::class, 'storeAlat'])->name('admin.alat.store');
        Route::get('/admin/alat/{id}/edit', [AdminController::class, 'editAlat'])->name('admin.alat.edit');
        Route::put('/admin/alat/{id}', [AdminController::class, 'updateAlat'])->name('admin.alat.update');
        Route::delete('/admin/alat/{id}', [AdminController::class, 'destroyAlat'])->name('admin.alat.destroy');

        // MANAJEMEN USER (Berdasarkan PDF Halaman 1 & 2)
        Route::get('/admin/user', [AdminController::class, 'user'])->name('admin.user');
        Route::post('/admin/user', [AdminController::class, 'storeUser'])->name('admin.user.store');
        Route::get('/admin/user/{id}/edit', [AdminController::class, 'editUser'])->name('admin.user.edit');
        Route::put('/admin/user/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
        Route::delete('/admin/user/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
    });

    // --- ROUTE KHUSUS PETUGAS ---
    Route::middleware(['role:petugas'])->group(function () {
        Route::get('/petugas/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
    });

    // --- ROUTE KHUSUS PEMINJAM ---
    Route::middleware(['role:peminjam'])->group(function () {
        Route::get('/dashboard', [PeminjamController::class, 'index'])->name('dashboard');
        Route::get('/peminjam/dashboard', [PeminjamController::class, 'index'])->name('peminjam.dashboard');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // ... rute lainnya ...
    Route::get('/admin/peminjaman', [AdminController::class, 'peminjaman'])->name('admin.peminjaman');
    Route::delete('/admin/peminjaman/{id}', [AdminController::class, 'destroyPeminjaman'])->name('admin.peminjaman.destroy');
});

require __DIR__.'/auth.php';