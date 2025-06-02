<?php

use App\Actions\Auth\PostForgotPasswordAction;
use App\Actions\Auth\PostLoginAction;
use App\Actions\Auth\PostLogoutAction;
use App\Actions\Auth\PostRegisterAction;
use App\Actions\Auth\PostResetPasswordAction;
use App\Http\Controllers\AuthController;

use function App\Support\get;
use function App\Support\middleware;
use function App\Support\post;

middleware('web.guest', function () {

    get('/login', [AuthController::class, 'login'])
        ->name('get.auth.login');
    post('/login', PostLoginAction::class)
        ->name('post.auth.login');

    post('/logout', PostLogoutAction::class)
        ->name('post.auth.logout');

    get('/register', [AuthController::class, 'register'])
        ->name('get.auth.register');
    post('/register', PostRegisterAction::class)
        ->name('post.auth.register');

    get('/esqueci-a-senha', [AuthController::class, 'forgotPassword'])
        ->name('get.auth.forgot-password');
    post('/forgot-password', PostForgotPasswordAction::class)
        ->name('post.auth.forgot-password');

    get('/trocar-senha', [AuthController::class, 'resetPassword'])
        ->name('get.password.reset.signed');
    post('/trocar-senha/submit', PostResetPasswordAction::class)
        ->name('post.password.reset.signed');
});

middleware('web.authenticated', function () {
    post('/logout', PostLogoutAction::class)
        ->name('post.auth.logout');
});
