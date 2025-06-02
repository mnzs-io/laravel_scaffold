<?php

use App\Http\Controllers\PageController;

use function App\Support\get;
use function App\Support\middleware;

middleware('web.guest', function () {
    get('/', [PageController::class, 'welcome'])->name('get.welcome');
});

middleware('web.authenticated', function () {
    get('/dashboard', [PageController::class, 'dashboard'])->name('get.dashboard');
    get('/csrf-token', function () {
        return response()->json(['token' => csrf_token()]);
    });
});

require __DIR__ . '/actions/auth.php';
require __DIR__ . '/actions/logs.php';
require __DIR__ . '/actions/payment.php';
require __DIR__ . '/actions/settings.php';
require __DIR__ . '/actions/socialite.php';
require __DIR__ . '/actions/users.php';

/***************************************************************/
// TODO: Remover após testar as funcionalidades de Broadcasting *
require __DIR__ . '/likes_to_remove.php';                    /**/
/***************************************************************/
