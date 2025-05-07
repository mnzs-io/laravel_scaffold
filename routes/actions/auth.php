<?php

use App\Actions\Auth\PostLoginAction;
use App\Actions\Auth\PostLogoutAction;
use App\Actions\Auth\PostRegisterAction;
use Illuminate\Support\Facades\Route;

Route::middleware('web.guest')->group(function () {
    Route::post('/login', PostLoginAction::class)->name('post.auth.login');
    Route::post('/register', PostRegisterAction::class)->name('post.auth.register');
});

Route::middleware('web.authenticated')->group(function () {
    Route::post('/logout', PostLogoutAction::class)->name('post.auth.logout');
});
