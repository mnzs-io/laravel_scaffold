<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Facades\Route;

function get(string $uri, $action = null)
{
    return Route::get($uri, $action);
}

function post(string $uri, $action = null)
{
    return Route::post($uri, $action);
}

function put(string $uri, $action = null)
{
    return Route::put($uri, $action);
}

function delete(string $uri, $action = null)
{
    return Route::delete($uri, $action);
}

function patch(string $uri, $action = null)
{
    return Route::patch($uri, $action);
}

function any(string $uri, $action = null)
{
    return Route::any($uri, $action);
}

function view(string $uri, string $view, array $data = [])
{
    return Route::view($uri, $view, $data);
}

function middleware(array|string|null $middleware, Closure $closure)
{
    return Route::middleware($middleware)->group($closure);
}
