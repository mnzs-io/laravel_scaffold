<?php

use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use function App\Support\get;
use function App\Support\middleware;

middleware('web.guest', function () {

    get('/login/github', function () {
        return Socialite::driver('github')->redirect();
    })->name('get.auth.github.login');

    get('/login/github/callback', function () {
        $githubUser = Socialite::driver('github')->user();

        $user = User::where('github_id', $githubUser->getId())->first();

        if (!$user) {
            $user = User::where('email', $githubUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'github_id' => $githubUser->getId(),
                    'avatar' => $user->avatar ?: $githubUser->getAvatar(),
                ]);
            } else {
                $criar = false;
                Settings::if('REGISTER_ENABLED', function () use (&$criar) {
                    $criar = true;
                });

                if (!$criar) {
                    abort(403, 'Sua conta não está autorizada.');
                }

                $user = User::create([
                    'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                    'email' => $githubUser->getEmail(),
                    'github_id' => $githubUser->getId(),
                    'avatar' => $githubUser->getAvatar(),
                ]);
            }
        } else {
            if (!$user->avatar && $githubUser->getAvatar()) {
                $user->update(['avatar' => $githubUser->getAvatar()]);
            }
        }

        Auth::login($user);

        return to_route('get.dashboard');
    });

    // GOOGLE

    get('/login/google', function () {
        return Socialite::driver('google')->redirect();
    })->name('get.auth.google.login');

    get('/login/google/callback', function () {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $user->avatar ?: $googleUser->getAvatar(),
                ]);
            } else {
                $criar = false;
                Settings::if('REGISTER_ENABLED', function () use (&$criar) {
                    $criar = true;
                });

                if (!$criar) {
                    abort(403, 'Sua conta não está autorizada.');
                }

                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
        } else {
            if (!$user->avatar && $googleUser->getAvatar()) {
                $user->update(['avatar' => $googleUser->getAvatar()]);
            }
        }

        Auth::login($user);

        return to_route('get.dashboard');
    })->name('get.auth.google.callback');
});
