<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::middleware('web.guest')->group(function () {
    Route::get('/', [PageController::class, 'welcome'])->name('get.welcome');
});

Route::middleware('web.authenticated')->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('get.dashboard');
    Route::get('/csrf-token', function () {
        return response()->json(['token' => csrf_token()]);
    });
});

require __DIR__ . '/actions/users.php';
require __DIR__ . '/actions/logs.php';
require __DIR__ . '/actions/auth.php';

/***************************************************************/
// TODO: Remover após testar as funcionalidades de Broadcasting *
require __DIR__ . '/likes_to_remove.php';                    /**/
/***************************************************************/
