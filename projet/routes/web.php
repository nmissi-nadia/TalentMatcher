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
// route vers view de login
Route::get('/login', [ApiController::class, 'index'])->name('login');
Route::post('/api/register', [ApiController::class, 'register'])->name('api.register');
Route::post('/api/login', [ApiController::class, 'login'])->name('api.login');
Route::post('/api/reset', [ApiController::class, 'resetPassword'])->name('password.request');
Route::get('/', function () {
    return view('welcome');
});

// page concérné par l'admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/candidatures', [AdminController::class, 'candidatures'])->name('admin.candidatures');
Route::get('/admin/utilisateurs', [AdminController::class, 'utilisateurs'])->name('admin.utilisateurs');



