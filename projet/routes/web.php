<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Authentication Routes
Route::get('/login', [ApiController::class, 'index'])->name('login');
Route::get('/register', [ApiController::class, 'register'])->name('register');
Route::post('/api/register', [ApiController::class, 'register'])->name('api.register');
Route::post('/api/login', [ApiController::class, 'login'])->name('api.login');
Route::post('/api/reset', [ApiController::class, 'resetPassword'])->name('password.request');
Route::post('/logout', [ApiController::class, 'logout'])->name('logout');

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Public Job Listings
Route::get('/jobs', [App\Http\Controllers\AnnonceController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [App\Http\Controllers\AnnonceController::class, 'show'])->name('jobs.show');

// Admin Routes (Protected by Auth and Admin Role Middleware)
Route::middleware(['auth', 'check.role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/candidatures', [AdminController::class, 'candidatures'])->name('admin.candidatures');
    Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('admin.utilisateurs');
    Route::get('/annonces', [AdminController::class, 'annonces'])->name('admin.annonces');
    Route::get('/annonce/{id}', [AdminController::class, 'annonce'])->name('admin.annonce');
    Route::get('/moderation', [AdminController::class, 'moderation'])->name('admin.moderation');
});
// Candidate Routes (Protected by Auth Middleware)
Route::middleware(['auth', 'check.role:candidat'])->prefix('candidat')->group(function () {
    Route::get('/dashboard', function () {
        return view('candidat.dashboard');
    })->name('candidat.dashboard');
    
    Route::get('/jobs', [App\Http\Controllers\AnnonceController::class, 'index'])->name('candidat.jobs');
    Route::get('/jobs/{id}', [App\Http\Controllers\AnnonceController::class, 'show'])->name('candidat.jobs.show');
    
    Route::get('/applications', [App\Http\Controllers\CandidatureController::class, 'candidatApplications'])->name('candidat.applications');
    Route::get('/applications/{id}', [App\Http\Controllers\CandidatureController::class, 'show'])->name('candidat.applications.show');
    Route::get('/jobs/{id}/apply', [App\Http\Controllers\CandidatureController::class, 'create'])->name('candidat.apply');
    Route::post('/applications', [App\Http\Controllers\CandidatureController::class, 'store'])->name('candidat.applications.store');
    Route::get('/applications/{id}/edit', [App\Http\Controllers\CandidatureController::class, 'edit'])->name('candidat.applications.edit');
    Route::put('/applications/{id}', [App\Http\Controllers\CandidatureController::class, 'update'])->name('candidat.applications.update');
    Route::delete('/applications/{id}', [App\Http\Controllers\CandidatureController::class, 'destroy'])->name('candidat.applications.destroy');
    
    Route::get('/profile', function () {
        return view('candidat.profile');
    })->name('candidat.profile');
});

// Recruiter Routes (Protected by Auth Middleware)
Route::middleware(['auth', 'check.role:recruteur'])->prefix('recruteur')->group(function () {
    Route::get('/dashboard', function () {
        return view('recruteur.dashboard');
    })->name('recruteur.dashboard');
    
    Route::get('/jobs', [App\Http\Controllers\AnnonceController::class, 'recruteurAnnonces'])->name('recruteur.jobs');
    Route::get('/jobs/create', [App\Http\Controllers\AnnonceController::class, 'create'])->name('recruteur.jobs.create');
    Route::post('/jobs', [App\Http\Controllers\AnnonceController::class, 'store'])->name('recruteur.jobs.store');
    Route::get('/jobs/{id}/edit', [App\Http\Controllers\AnnonceController::class, 'edit'])->name('recruteur.jobs.edit');
    Route::put('/jobs/{id}', [App\Http\Controllers\AnnonceController::class, 'update'])->name('recruteur.jobs.update');
    Route::delete('/jobs/{id}', [App\Http\Controllers\AnnonceController::class, 'destroy'])->name('recruteur.jobs.delete');
    
    Route::get('/annonce/{id}/candidates', [App\Http\Controllers\CandidatureController::class, 'candidaturesByAnnonce'])->name('recruteur.annonce.candidates');
    Route::get('/candidates', function () {
        return view('recruteur.candidates');
    })->name('recruteur.candidates');
    Route::put('/candidatures/{id}/status', [App\Http\Controllers\CandidatureController::class, 'updateStatus'])->name('recruteur.candidature.status');
    
    Route::get('/profile', function () {
        return view('recruteur.profile');
    })->name('recruteur.profile');
});


