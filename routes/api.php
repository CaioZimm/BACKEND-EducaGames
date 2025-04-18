<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\FoundationController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo "Hello World!";
});

// --------------------- ROUTES - User ----------------------
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('user.login');

Route::middleware(['auth:sanctum', 'role:super_admin,admin'])->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('user.register');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('user.logout');
});

Route::middleware(['auth:sanctum', 'role:super_admin,admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id?}', [UserController::class, 'show']);

    Route::put('/user/{id?}', [UserController::class, 'update']);
    
    Route::delete('/user/{id?}', [UserController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
    Route::post('/avatar', [AvatarController::class, 'store']);
    
    Route::get('/avatar', [AvatarController::class, 'index']);
    Route::get('/avatar/{id}', [AvatarController::class, 'show']);

    Route::put('/avatar/{id}', [AvatarController::class, 'update']);

    Route::delete('/avatar/{id}', [AvatarController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:super_admin,admin'])->group( function (){
    Route::post('/foundation', [FoundationController::class, 'store']);

    Route::get('/foundation', [FoundationController::class, 'index']);
    Route::get('/foundation/{id}', [FoundationController::class, 'show']);

    Route::put('/foundation/{id}', [FoundationController::class, 'update']);

    Route::delete('/foundation/{id}', [FoundationController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:super_admin,admin'])->group( function (){
    Route::post('/game', [GameController::class, 'store']);

    Route::get('/game', [GameController::class, 'index']);
    Route::get('/game/{id}', [GameController::class, 'show']);

    Route::put('/game/{id}', [GameController::class, 'update']);

    Route::delete('/game/{id}', [GameController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:super_admin,admin'])->group( function (){
    Route::post('/question', [QuestionController::class, 'store']);

    Route::get('/question', [QuestionController::class, 'index']);
    Route::get('/question/{id}', [QuestionController::class, 'show']);

    Route::put('/question/{id}', [QuestionController::class, 'update']);

    Route::delete('/question/{id}', [QuestionController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:super_admin,admin'])->group( function(){
    // Respostas - Dissertativas
    Route::post('/answer', [AnswerController::class, 'store']);

    Route::get('/answer', [AnswerController::class, 'index']);
    Route::get('/answer/{id}', [AnswerController::class, 'show']);

    Route::put('/answer/{id}', [AnswerController::class, 'update']);

    Route::delete('/answer/{id}', [AnswerController::class, 'destroy']);

    // Respostas - Alternativas
    Route::post('/alternative', [AlternativeController::class, 'store']);

    Route::get('/alternative', [AlternativeController::class, 'index']);
    Route::get('/alternative/{id}', [AlternativeController::class, 'show']);

    Route::put('/alternative/{id}', [AlternativeController::class, 'update']);

    Route::delete('/alternative/{id}', [AlternativeController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:super_admin,admin'])->group( function(){
    Route::post('/result', [GameController::class, 'finish']);
});