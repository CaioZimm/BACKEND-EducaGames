<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo "Hello World!";
});

// --------------------- ROUTES - User ----------------------
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('user.login');

Route::middleware(['auth:sanctum', 'role:super_admin, admin'])->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('user.register');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('user.logout');
});

// -------------------- ROUTES - Admin ----------------------


// ------------------ ROUTES - SuperAdmin -------------------



// ------------------ ROUTES - Foundation -------------------