<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function forgotPassword()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function resetPassword(Request $request)
    {

        if (!$request->hasValidSignature()) {
            abort(403, 'Link expirado ou inválido.');
        }

        return inertia('Auth/ResetPassword', [
            'user' => $request->user,
            'email' => $request->email,
            'token' => $request->token,
        ]);
    }
}
