<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::middleware('web.guest')->group(function () {
    Route::get('/', [PageController::class, 'welcome'])->name('get.welcome');
    Route::get('/register', [AuthController::class, 'register'])->name('get.auth.register');
    Route::get('/login', [AuthController::class, 'login'])->name('get.auth.login');
});

Route::middleware('web.authenticated')->group(function () {
    Route::get('dashboard', [PageController::class, 'dashboard'])->name('get.dashboard');
    require __DIR__ . '/actions/users.php';
});

require __DIR__ . '/actions/auth.php';

/***************************************************************/
// TODO: Remover após testar as funcionalidades de Broadcasting *
require __DIR__ . '/likes_to_remove.php';                    /**/
/***************************************************************/
