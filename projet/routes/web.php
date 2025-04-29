<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\RecruteurController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ModerationController;
use App\Models\Annonce;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewCandidatureNotification;

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

// Public offre Listings
Route::get('/offres', [AnnonceController::class, 'index'])->name('offres.index');
Route::get('/offres/{id}', [AnnonceController::class, 'show'])->name('offres.show');

// Candidate Routes (Protected by Auth Middleware)
Route::middleware(['auth', 'check.role:candidat'])->prefix('candidat')->name('candidat.')->group(function () {
    Route::get('/dashboard', [CandidatController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [CandidatController::class, 'showProfile'])->name('profile');
    Route::put('/profile/update', [CandidatController::class, 'updateProfile'])->name('profile.update');
    // affichage des offres existe
    Route::get('/offres', [AnnonceController::class, 'offres'])->name('offres');
    // detail d une annonce
    Route::get('/offres/{id}', [AnnonceController::class, 'show'])->name('offre.detail');
    Route::get('/search', [CandidatController::class, 'search'])->name('search');
    Route::post('/apply/{id}', [CandidatController::class, 'apply'])->name('apply');
    Route::get('/candidatures', [CandidatureController::class, 'candidatures'])->name('candidatures');
    Route::get('/candidatures/{id}', [CandidatureController::class, 'show'])->name('candidature.detail');
    Route::delete('/candidatures/{id}', [CandidatureController::class, 'destroy'])->name('candidatures.delete');
    Route::get('/recommended', [CandidatController::class, 'recommended'])->name('recommended');
});

// Recruiter Routes (Protected by Auth Middleware)
Route::middleware(['auth', 'check.role:recruteur'])->prefix('recruteur')->name('recruteur.')->group(function () {
    Route::get('/dashboard', [RecruteurController::class, 'dashboard'])->name('dashboard');
    Route::get('/offres', [RecruteurController::class, 'annonces'])->name('offres');
    Route::get('/annonces/create', [RecruteurController::class, 'createAnnonce'])->name('annonces.create');
    Route::post('/annonces/store', [RecruteurController::class, 'storeAnnonce'])->name('annonces.store');
    Route::get('/annonces/{id}/edit', [AnnonceController::class, 'edit'])->name('annonces.edit');
    Route::put('/annonces/{id}/update', [AnnonceController::class, 'update'])->name('annonces.update');
    Route::get('/annonces/{id}/manage', [RecruteurController::class, 'manageCandidatures'])->name('annonces.manage');
    Route::delete('/annonces/{id}/delete', [AnnonceController::class, 'destroy'])->name('annonces.delete');
    // page d'affichage des candidatures
    Route::get('/candidatures', [RecruteurController::class, 'candidatures'])->name('candidatures.index');
    Route::get('/candidatures/{id}', [CandidatureController::class, 'showrec'])->name('candidature.show');
    // ajouter l'au
    Route::put('/candidatures/{id}/status', [CandidatureController::class, 'updateCandidatureStatus'])->name('candidature.status');
    Route::get('/candidatures/{id}/etapes', [RecruteurController::class, 'manageEtapes'])->name('candidatures.etapes');
    Route::post('/etapes/{id}/update', [RecruteurController::class, 'updateEtape'])->name('etapes.update');
    // partie concernat les tags
    Route::get('/stats', [RecruteurController::class, 'stats'])->name('stats');
    Route::get('/tags', [RecruteurController::class, 'manageTags'])->name('tags');
    Route::post('/tags/create', [RecruteurController::class, 'createTag'])->name('tags.create');
    // telecharger le cv
    Route::get('/candidatures/{id}/cv', [CandidatureController::class, 'downloadCV'])->name('candidatures.cv');
});

// Admin Routes (Protected by Auth and Admin Role Middleware)
Route::middleware(['auth', 'check.role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
  
    // teste
    Route::delete('/offre/{id}', [AdminController::class, 'deleteoffre'])->name('admin.deleteoffre');
        
        Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('utilisateurs');
        Route::get('/candidatures', [AdminController::class, 'candidatures'])->name('candidatures');
        // partie concernat moderation
        Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation');
        Route::post('/moderation/traiter/{id}', [ModerationController::class, 'traiter'])->name('signalement.traiter');
        Route::get('/annonces', [AdminController::class, 'annonces'])->name('annonces');
        Route::get('/annonce/{id}', [AdminController::class, 'showAnnonce'])->name('annonce');
        // partie concernat par les utilisateurs
        Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('utilisateurs');
        Route::get('/utilisateurs/{id}', [AdminController::class, 'show'])->name('user.show');
        // update utilisateur
        Route::put('/utilisateurs/{id}', [AdminController::class, 'update'])->name('user.update');
        // edit utilisateur
        Route::get('/utilisateurs/{id}/edit', [AdminController::class, 'edit'])->name('user.edit');
        // delete utilisateur
        Route::delete('/utilisateurs/{id}', [AdminController::class, 'delete'])->name('user.delete');
        Route::post('/utilisateurs/restore/{id}', [AdminController::class, 'restaurerUtilisateur'])->name('admin.users.restore');
        Route::delete('/utilisateurs/force-delete/{id}', [AdminController::class, 'supprimerDefinitivement'])->name('admin.users.force-delete');
        Route::get('/annonces', [AdminController::class, 'annonces'])->name('annonces');
        Route::get('/annonces/actives', [AdminController::class, 'annoncesActives'])->name('annonces.actives');
        Route::get('/annonces/expirees', [AdminController::class, 'annoncesExpirees'])->name('annonces.expirees');
        Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonce.create');
        Route::get('/annonce/{id}', [AnnonceController::class, 'show'])->name('annonce.show');
        Route::get('/annonce/{id}/edit', [AnnonceController::class, 'edit'])->name('annonce.edit');
        Route::delete('/annonce/{id}', [AnnonceController::class, 'delete'])->name('annonce.delete');
        // partie concernat les tags
        Route::get('/tags_categories', [AdminController::class, 'gestionTags_categorie'])->name('tags');
        Route::post('/tags/create', [TagController::class, 'create'])->name('tags.create');
        // route for store tags
        Route::post('/tags/edit', [TagController::class, 'edit'])->name('tags.edit');
        Route::post('/tags/store', [TagController::class, 'store'])->name('tags.store');
        Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');
        // partie concernant les categories
        Route::get('/categories', [CategorieController::class, 'index'])->name('categories');
        Route::post('/categories/create', [CategorieController::class, 'create'])->name('categories.create');
        Route::post('/categories/edit', [CategorieController::class, 'edit'])->name('categories.edit');
        Route::post('/categories/store', [CategorieController::class, 'store'])->name('categories.store');
        Route::delete('/categories/{id}', [CategorieController::class, 'destroy'])->name('categories.destroy');
});

// API Routes for offre Applications
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::post('/candidatures', [CandidatureController::class, 'store'])->name('candidatures.store');
    Route::get('/candidatures/{id}', [CandidatureController::class, 'show'])->name('candidatures.show');
    Route::put('/candidatures/{id}', [CandidatureController::class, 'update'])->name('candidatures.update');
    Route::delete('/candidatures/{id}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');
});
Route::get('/test-email', function() {
    $user = User::where('role', 'recruteur')->first();
    $offre = Annonce::first();
    
    Mail::to($user->email)->send(new NewCandidatureNotification($offre, $user));
    
    return 'Email test envoyé';
});