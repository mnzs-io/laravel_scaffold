<?php

use App\Actions\Users\UsersIndexAction;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/usuarios/lista', UsersIndexAction::class)
    ->can('viewAny', User::class)
    ->name('get.users.index');
