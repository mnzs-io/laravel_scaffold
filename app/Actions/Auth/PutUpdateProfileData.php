<?php

namespace App\Actions\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateUserProfileDataRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Support\Facades\Auth;

class PutUpdateProfileData extends Controller
{
    use ApiResponses, HybridResponse;

    private User $user;

    public function __invoke(UpdateUserProfileDataRequest $request)
    {
        $memoryUsageMB = round(memory_get_usage(true) / 1024 / 1024, 2);
        $log = date('[Y-m-d H:i:s]') . "Memória: {$memoryUsageMB} MB";
        info($log);

        return true;
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
