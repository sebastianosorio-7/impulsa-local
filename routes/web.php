<?php

use App\Http\Controllers\Admin\EmprendedorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'rol:administrador'])->prefix('admin')->group(function () {
    Route::get('/panel', function () {
        return 'Panel del administrador';
    })->name('admin.panel');


    Route::get('/emprendedores', [EmprendedorController::class, 'index'])->name('admin.emprendedores.index');
    Route::get('/emprendedores/crear', [EmprendedorController::class, 'create'])->name('admin.emprendedores.create');
    Route::post('/emprendedores', [EmprendedorController::class, 'store'])->name('admin.emprendedores.store');
});

require __DIR__ . '/auth.php';

// --- Gestión de Capacitaciones y Perfil (Jaime) ---

// Rutas de Administración (CU05)
Route::middleware(['auth', 'rol:administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('capacitaciones', App\Http\Controllers\Admin\CapacitacionController::class);
});

// Rutas de Emprendedor / Catálogo (CU06)
Route::middleware('auth')->group(function () {
    Route::get('/capacitaciones', [App\Http\Controllers\CapacitacionController::class, 'index'])->name('capacitaciones.index');
});
// ==========================================
// --- Módulo de Inscripciones (Mariana) ---
// ==========================================

// Rutas para el emprendedor (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/inscripciones', [App\Http\Controllers\InscripcionController::class, 'index'])->name('inscripciones.index');
    Route::post('/inscripciones', [App\Http\Controllers\InscripcionController::class, 'store'])->name('inscripciones.store');
});

// Rutas para el administrador (requieren rol de administrador y autenticación)
Route::middleware(['auth', 'rol:administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/inscripciones', [App\Http\Controllers\Admin\InscripcionController::class, 'index'])->name('inscripciones.index');
});
