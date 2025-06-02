<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

class WebAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Context::get('user');
        if (!$user) {
            return redirect()->route('get.auth.login');
        }

        return $next($request);
    }
}
