<?php

use App\Actions\Auth\PostActivateUserAction;
use App\Actions\Auth\PostDeactivateUserAction;
use App\Actions\Auth\PutUpdateOwnPassword;
use App\Actions\Auth\PutUpdateProfileData;
use App\Actions\Users\GetUserAvatar;
use App\Actions\Users\UsersIndexAction;
use App\Http\Controllers\PageController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/usuarios/lista', UsersIndexAction::class)
    ->can('viewAny', User::class)
    ->name('get.users.index');

Route::middleware('web.authenticated')->group(function () {
    Route::get('profile', [PageController::class, 'profile'])->name('get.profile');
    Route::put('profile/{user}/data', PutUpdateProfileData::class)
        ->can('update', 'user')
        ->name('put.profile.data');

    Route::put('profile/{user}/password', PutUpdateOwnPassword::class)
        ->can('update', 'user')
        ->name('put.profile.password');

    Route::post('profile/admin/activate/{user}', PostActivateUserAction::class)
        ->can('activate', 'user')
        ->name('post.activate.user');

    Route::post('profile/admin/deactivate/{user}', PostDeactivateUserAction::class)
        ->can('activate', 'user')
        ->name('post.deactivate.user');

    Route::get('/avatar/{filename}', GetUserAvatar::class)->name('get.user.image');
});
