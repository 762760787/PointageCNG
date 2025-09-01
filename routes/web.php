<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\QrCodeController; // Ajout du nouveau contrôleur
use App\Http\Controllers\Employe\DashboardController as EmployeDashboardController;
use App\Http\Controllers\PointageController;
use App\Http\Controllers\RedirectController;

// Page de connexion par défaut
Route::get('/', function () {
    return view('auth.login');
});

// Route de redirection après connexion
Route::get('/redirect-after-login', [RedirectController::class, 'redirect'])->middleware('auth')->name('login.redirect');

// --- Routes pour les employés authentifiés ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PointageController::class, 'index'])->name('employe.dashboard');
    Route::get('/scan', [PointageController::class, 'scanner'])->name('employe.scanner');
    Route::post('/pointage/scan', [PointageController::class, 'store'])->name('pointage.scan');
});

// --- Routes pour l'administrateur ---
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // QR Codes
    Route::get('/qrcodes', [QrCodeController::class, 'create'])->name('qrcodes.create');
    Route::post('/qrcodes/generate', [QrCodeController::class, 'generate'])->name('qrcodes.generate');

    // CRUD des utilisateurs (Employés)
    Route::resource('users', UserController::class);

    // Rapports
    Route::get('/rapports', [AdminDashboardController::class, 'rapports'])->name('rapports');
    Route::get('/rapports/export', [AdminDashboardController::class, 'export'])->name('rapports.export');
});

// Inclut les routes d'authentification générées par Laravel Breeze (login, logout, etc.)
require __DIR__.'/auth.php';