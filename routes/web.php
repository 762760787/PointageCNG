<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\QrCodeController;
// Correction : On importe le bon contrôleur pour l'employé
use App\Http\Controllers\Employe\DashboardControllers;
use App\Http\Controllers\PointageController;
use App\Http\Controllers\RedirectController;
    // routes/web.php
use App\Http\Controllers\Admin\JourFerieController;
use App\Http\Controllers\Employe\CongeController as EmployeCongeController;
use App\Http\Controllers\Admin\CongeController as AdminCongeController;


// Page de connexion par défaut
Route::get('/', function () {
    return view('auth.login');
});

// Route de redirection après connexion
//Route::get('/redirect-after-login', [RedirectController::class, 'redirect'])->middleware('auth')->name('login.redirect');


// --- Routes pour les employés authentifiés (CORRIGÉES) ---
Route::middleware(['auth'])->prefix('employe')->name('employe.')->group(function () {

    // Cette route affiche le tableau de bord
    Route::get('/dashboard', [DashboardControllers::class, 'index'])->name('dashboard');

    // Cette route affiche maintenant la page du scanner
    Route::get('/scanner', [DashboardControllers::class, 'scanner'])->name('scanner');

    // Cette route affiche l'historique
    Route::get('/historique', [DashboardControllers::class, 'historique'])->name('historique');

    // Affiche la page du profil de l'employé
    Route::get('/profil', [DashboardControllers::class, 'profil'])->name('profil');
    // Traite la mise à jour des informations du profil
    Route::post('/profil', [DashboardControllers::class, 'updateProfil'])->name('profil.update');

    // Dans le groupe de routes employe
    Route::get('/conges', [EmployeCongeController::class, 'index'])->name('conges.index');
    Route::post('/conges', [EmployeCongeController::class, 'store'])->name('conges.store');

});

// Cette route reçoit les données du scan et reste inchangée
Route::post('/pointage/scan', [PointageController::class, 'scan'])->middleware('auth')->name('pointage.scan');


// --- Routes pour l'administrateur ---
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // QR Codes
    Route::get('/qrcodes', [QrCodeController::class, 'create'])->name('qrcodes.create');
    Route::post('/qrcodes/generate', [QrCodeController::class, 'store'])->name('qrcodes.store');

    // CRUD des utilisateurs (Employés)
    Route::resource('users', UserController::class);

    Route::get('/historique/export/{type}', [AdminDashboardController::class, 'exportHistorique'])->name('historique.export');
    Route::get('/rapports/export/{type}', [AdminDashboardController::class, 'exportRapports'])->name('rapports.export');

    // Dans le groupe de routes admin
    Route::resource('jours-feries', JourFerieController::class)->only(['index', 'store', 'destroy']);

    // NOUVEAU: Route pour la page d'historique de l'admin
     Route::get('/historique', [AdminDashboardController::class, 'historique'])->name('historique');
    // Rapports
    Route::get('/rapports', [AdminDashboardController::class, 'rapports'])->name('rapports');
    Route::get('/rapports/export', [AdminDashboardController::class, 'export'])->name('rapports.export');

    // NOUVEAU: Routes pour la gestion des congés par l'admin
    Route::get('/indexconges', [AdminCongeController::class, 'index'])->name('conges.index');
    Route::patch('/conges/{conge}', [AdminCongeController::class, 'update'])->name('conges.update');

    Route::post('/conges', [AdminCongeController::class, 'store'])->name('conges.store');

});



// Inclut les routes d'authentification générées par Laravel Breeze (login, logout, etc.)
require __DIR__.'/auth.php';