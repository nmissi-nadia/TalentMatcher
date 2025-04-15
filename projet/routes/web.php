<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\RecruteurController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\CandidatureController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Public Job Listings
Route::get('/jobs', [AnnonceController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [AnnonceController::class, 'show'])->name('jobs.show');

// Candidate Routes (Protected by Auth Middleware)
Route::middleware(['auth', 'check.role:candidat'])->prefix('candidat')->name('candidat.')->group(function () {
    Route::get('/dashboard', [CandidatController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [CandidatController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update', [CandidatController::class, 'updateProfile'])->name('profile.update');
    Route::get('/search', [CandidatController::class, 'search'])->name('search');
    Route::post('/apply/{id}', [CandidatController::class, 'apply'])->name('apply');
    Route::get('/candidatures', [CandidatController::class, 'candidatures'])->name('candidatures');
    Route::delete('/candidatures/{id}', [CandidatController::class, 'deleteCandidature'])->name('candidatures.delete');
    Route::get('/recommended', [CandidatController::class, 'recommended'])->name('recommended');
});

// Recruiter Routes (Protected by Auth Middleware)
Route::middleware(['auth', 'check.role:recruteur'])->prefix('recruteur')->name('recruteur.')->group(function () {
    Route::get('/dashboard', [RecruteurController::class, 'dashboard'])->name('dashboard');
    Route::get('/annonces/create', [RecruteurController::class, 'createAnnonce'])->name('annonces.create');
    Route::post('/annonces/store', [RecruteurController::class, 'storeAnnonce'])->name('annonces.store');
    Route::get('/annonces/{id}/manage', [RecruteurController::class, 'manageCandidatures'])->name('annonces.manage');
    Route::post('/candidatures/{id}/status', [RecruteurController::class, 'updateCandidatureStatus'])->name('candidatures.status');
    Route::get('/candidatures/{id}/etapes', [RecruteurController::class, 'manageEtapes'])->name('candidatures.etapes');
    Route::post('/etapes/{id}/update', [RecruteurController::class, 'updateEtape'])->name('etapes.update');
    Route::get('/stats', [RecruteurController::class, 'stats'])->name('stats');
    Route::get('/tags', [RecruteurController::class, 'manageTags'])->name('tags');
    Route::post('/tags/create', [RecruteurController::class, 'createTag'])->name('tags.create');
});

// Admin Routes (Protected by Auth and Admin Role Middleware)
Route::middleware(['auth', 'check.role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
  
    // teste
    Route::delete('/job/{id}', [AdminController::class, 'deleteJob'])->name('admin.deleteJob');
        Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('utilisateurs');
        Route::get('/candidatures', [AdminController::class, 'candidatures'])->name('candidatures');
        Route::get('/moderation', [AdminController::class, 'moderation'])->name('moderation');
        Route::get('/annonces', [AdminController::class, 'annonces'])->name('annonces');
        Route::get('/annonce/{id}', [AdminController::class, 'showAnnonce'])->name('annonce');
        Route::get('/utilisateurs-supprimes', [AdminController::class, 'utilisateursSupprimes'])->name('utilisateursSupprimes');
        Route::post('/utilisateurs/restore/{id}', [AdminController::class, 'restaurerUtilisateur'])->name('admin.users.restore');
        Route::delete('/utilisateurs/force-delete/{id}', [AdminController::class, 'supprimerDefinitivement'])->name('admin.users.force-delete');
        Route::get('/annonces', [AdminController::class, 'annonces'])->name('annonces');
        Route::get('/annonces/actives', [AdminController::class, 'annoncesActives'])->name('annonces.actives');
        Route::get('/annonces/expirees', [AdminController::class, 'annoncesExpirees'])->name('annonces.expirees');
        Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonce.create');
        Route::get('/annonce/{id}', [AnnonceController::class, 'show'])->name('annonce.show');
        Route::get('/annonce/{id}/edit', [AnnonceController::class, 'edit'])->name('annonce.edit');
        Route::delete('/annonce/{id}', [AnnonceController::class, 'delete'])->name('annonce.delete');
});

// API Routes for Job Applications
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::post('/candidatures', [CandidatureController::class, 'store'])->name('candidatures.store');
    Route::get('/candidatures/{id}', [CandidatureController::class, 'show'])->name('candidatures.show');
    Route::put('/candidatures/{id}', [CandidatureController::class, 'update'])->name('candidatures.update');
    Route::delete('/candidatures/{id}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');
});