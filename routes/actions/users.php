<?php

use App\Actions\Auth\PostActivateUserAction;
use App\Actions\Auth\PostDeactivateUserAction;
use App\Actions\Auth\PutUpdateOwnPassword;
use App\Actions\Auth\PutUpdateProfileData;
use App\Actions\Users\GetUserAvatar;
use App\Actions\Users\UsersIndexAction;
use App\Http\Controllers\PageController;
use App\Models\User;

use function App\Support\{get, middleware, post, put};

get('/usuarios/lista', UsersIndexAction::class)
    ->can('viewAny', User::class)
    ->name('get.users.index');

middleware('web.authenticated', function () {

    get('profile', [PageController::class, 'profile'])->name('get.profile');
    put('profile/{user}/data', PutUpdateProfileData::class)
        ->can('update', 'user')
        ->name('put.profile.data');

    put('profile/{user}/password', PutUpdateOwnPassword::class)
        ->can('update', 'user')
        ->name('put.profile.password');

    post('profile/admin/activate/{user}', PostActivateUserAction::class)
        ->can('activate', 'user')
        ->name('post.activate.user');

    post('profile/admin/deactivate/{user}', PostDeactivateUserAction::class)
        ->can('activate', 'user')
        ->name('post.deactivate.user');

    get('/avatar/{filename}', GetUserAvatar::class)->name('get.user.image');
});
