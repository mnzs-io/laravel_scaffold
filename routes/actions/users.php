<?php

use App\Actions\Auth\PostLogoutAction;
use App\Actions\Auth\PutUpdatePassword;
use App\Actions\Auth\PutUpdateProfileData;
use App\Actions\Users\UsersIndexAction;
use App\Http\Controllers\PageController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/usuarios/lista', UsersIndexAction::class)
    ->can('viewAny', User::class)
    ->name('get.users.index');

Route::middleware('web.authenticated')->group(function () {
    Route::post('/logout', PostLogoutAction::class)->name('post.auth.logout');
    Route::get('profile', [PageController::class, 'profile'])->name('get.profile');
    Route::put('profile/{user}/data', PutUpdateProfileData::class)
        ->can('update', 'user')
        ->name('put.profile.data');
    Route::put('profile/{user}/password', PutUpdatePassword::class)
        ->can('update', 'user')
        ->name('put.profile.password');
    // Route::put('profile/password', PutUpdateProfilePassword::class)
    //     ->can('update', User::class)
    //     ->name('put.profile.data');
});
