<?php

use App\Events\LikeEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// TODO: Remover após testar as funcionalidadesde Broadcast
Route::middleware('web.guest')->group(function () {
    Route::get('/like', function () {
        return Inertia\Inertia::render('Guest/ToRemove/Like', [
            'breadcrumbs' => [['title' => 'Like', 'href' => route('get.like')]],
        ]);
    })->name('get.like');
    Route::post('/like', function (Request $request) {
        event(new LikeEvent($request->get('name')));
    })->name('post.like');
});

Route::middleware('web.authenticated')->group(function () {

    Route::get('/likes', function () {
        return Inertia\Inertia::render('ToRemove/Likes', [
            'breadcrumbs' => [['title' => 'Likes', 'href' => route('get.likes')]],
        ]);
    })->name('get.likes');

    Route::post('/like/authenticated', function (Request $request) {
        event(new LikeEvent(Auth::user()->name));
    })->name('post.like.authenticated');
});
