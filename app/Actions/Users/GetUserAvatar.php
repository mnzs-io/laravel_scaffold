<?php

namespace App\Actions\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Support\Facades\Auth;

class GetUserAvatar extends Controller
{
    use ApiResponses, HybridResponse;

    private User $user;

    public function __invoke(string $filename)
    {
        $path = storage_path("app/private/avatars/{$filename}");

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    protected function json()
    {
        return response()->json([
            'user' => $this->user,
            'token' => $this->user->createToken('auth_token')->plainTextToken,
        ]);
    }

    protected function jsonFail()
    {
        return $this->invalidCredentials();
    }

    protected function inertia()
    {
        Auth::login($this->user);
        session()->regenerate();

        return to_route('get.dashboard');
    }

    protected function inertiaFail()
    {

        return back()->withErrors([
            'email' => 'Login e/ou senha inválidos',
        ]);
    }
}
