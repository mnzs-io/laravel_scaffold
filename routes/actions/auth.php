<?php

use App\Actions\Auth\PostLoginAction;
use App\Actions\Auth\PostLogoutAction;
use App\Actions\Auth\PostRegisterAction;
use App\Actions\Auth\PutUpdateProfileData;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('web.guest')->group(function () {
    Route::post('/login', PostLoginAction::class)->name('post.auth.login');
    Route::post('/register', PostRegisterAction::class)->name('post.auth.register');
});

Route::middleware('web.authenticated')->group(function () {
    Route::post('/logout', PostLogoutAction::class)->name('post.auth.logout');
    Route::get('profile', [AuthController::class, 'profile'])->name('get.profile');
    Route::put('profile/{user}/data', PutUpdateProfileData::class)->name('put.profile.data');
    // Route::put('profile/password', PutUpdateProfilePassword::class)
    //     ->can('update', User::class)
    //     ->name('put.profile.data');
});
