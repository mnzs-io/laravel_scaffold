<?php

namespace App\Http\Middleware;

use App\Tools\Cache\UserCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $user = $request->user();
        $associations = [];

        if ($user) {
            $associations = UserCache::associations($user);
            Context::add('user', $user->only(['id', 'email']));
        }

        return [
            ...parent::share($request),
            'flash' => fn () => $request->session()->pull('flash-message'),
            'user' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'associations' => $associations,
            ] : null,
            'association' => $user ? session('association') : null,
        ];
    }
}
