<?php

use App\Actions\Auth\PostForgotPasswordAction;
use App\Actions\Auth\PostLoginAction;
use App\Actions\Auth\PostLogoutAction;
use App\Actions\Auth\PostRegisterAction;
use App\Actions\Auth\PostResetPasswordAction;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('web.guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('get.auth.login');
    Route::post('/login', PostLoginAction::class)->name('post.auth.login');

    Route::post('/logout', PostLogoutAction::class)->name('post.auth.logout');

    Route::get('/register', [AuthController::class, 'register'])->name('get.auth.register');
    Route::post('/register', PostRegisterAction::class)->name('post.auth.register');

    Route::get('/esqueci-a-senha', [AuthController::class, 'forgotPassword'])->name('get.auth.forgot-password');
    Route::post('/forgot-password', PostForgotPasswordAction::class)->name('post.auth.forgot-password');

    Route::get('/trocar-senha', [AuthController::class, 'resetPassword'])->name('get.password.reset.signed');
    Route::post('/trocar-senha/submit', PostResetPasswordAction::class)->name('post.password.reset.signed');
});

Route::middleware('web.authenticated')->group(function () {
    Route::post('/logout', PostLogoutAction::class)->name('post.auth.logout');
});
