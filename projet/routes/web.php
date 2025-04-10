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
Route::get('/jobs', function () {
    return view('jobs.index');
})->name('jobs.index');

Route::get('/jobs/{id}', function ($id) {
    return view('jobs.show', ['id' => $id]);
})->name('jobs.show');

// Admin Routes
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/candidatures', [AdminController::class, 'candidatures'])->name('admin.candidatures');
Route::get('/admin/utilisateurs', [AdminController::class, 'utilisateurs'])->name('admin.utilisateurs');
Route::get('/admin/annonces', [AdminController::class, 'annonces'])->name('admin.annonces');
Route::get('/admin/moderation', [AdminController::class, 'moderation'])->name('admin.moderation');
// Candidate Routes (Protected by Auth Middleware)
Route::middleware(['auth', 'check.role:candidat'])->prefix('candidat')->group(function () {
    Route::get('/dashboard', function () {
        return view('candidat.dashboard');
    })->name('candidat.dashboard');
    
    Route::get('/jobs', function () {
        return view('candidat.jobs');
    })->name('candidat.jobs');
    
    Route::get('/jobs/{id}', function ($id) {
        return view('candidat.job-detail', ['id' => $id]);
    })->name('candidat.jobs.show');
    
    Route::get('/applications', function () {
        return view('candidat.applications');
    })->name('candidat.applications');
    
    Route::get('/profile', function () {
        return view('candidat.profile');
    })->name('candidat.profile');
});

// Recruiter Routes (Protected by Auth Middleware)
Route::middleware(['auth', 'check.role:recruteur'])->prefix('recruteur')->group(function () {
    Route::get('/dashboard', function () {
        return view('recruteur.dashboard');
    })->name('recruteur.dashboard');
    
    Route::get('/jobs', function () {
        return view('recruteur.jobs');
    })->name('recruteur.jobs');
    
    Route::get('/jobs/create', function () {
        return view('recruteur.jobs-create');
    })->name('recruteur.jobs.create');
    
    Route::get('/jobs/{id}/edit', function ($id) {
        return view('recruteur.jobs-edit', ['id' => $id]);
    })->name('recruteur.jobs.edit');
    
    Route::get('/candidates', function () {
        return view('recruteur.candidates');
    })->name('recruteur.candidates');
    
    Route::get('/profile', function () {
        return view('recruteur.profile');
    })->name('recruteur.profile');
});


