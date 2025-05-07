<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login', [
            'register_enabled' => config('settings.register_enabled'),
        ]);
    }

    public function register()
    {
        if (!config('settings.register_enabled')) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return Inertia::render('Auth/Register', [
            'register_enabled' => config('settings.register_enabled'),
        ]);
    }
}
