<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('todos.index')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');

    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])
        ->name('google.redirect');

    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
        ->name('google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/todos', [TodoController::class, 'index'])
        ->name('todos.index');

    Route::post('/todos', [TodoController::class, 'store'])
        ->name('todos.store');

    Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])
        ->name('todos.edit');

    Route::put('/todos/{todo}', [TodoController::class, 'update'])
        ->name('todos.update');

    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])
        ->name('todos.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
