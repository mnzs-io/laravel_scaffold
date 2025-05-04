<?php

namespace App\Actions\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Support\Facades\Auth;

class PostLoginAction extends Controller
{
    use ApiResponses, HybridResponse;

    private User $user;

    public function __invoke(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');
        if (Auth::validate($credentials)) {
            $this->user = User::where('email', $credentials['email'])->first();

            return $this->respond($request);
        } else {
            return $this->respondWithError($request);
        }
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
