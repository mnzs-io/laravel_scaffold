<?php

namespace App\Actions\Auth;

use App\Events\Auth\UserLoggedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Tools\FlashMessage;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Support\Facades\Auth;

class PostLoginAction extends Controller
{
    use ApiResponses, HybridResponse;

    private ?User $user;

    private string $message = 'Login e/ou senha inválidos';

    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $this->user = User::where('email', $credentials['email'])->first();

        if (!$this->user) {
            return $this->respondWithError($request);
        }

        if (!$this->user->password) {
            FlashMessage::warning('Faça login utilizando essa maneira e defina uma senha.', 'Você se cadastrou usando Google/GitHub.');
            $this->message = 'Defina a senha após realizar login com Google/Github';

            return $this->respondWithError($request);
        }

        if (!Auth::validate($credentials)) {
            return $this->respondWithError($request);
        }

        if (!$this->user->active) {
            Auth::logout();
            FlashMessage::warning('Conta desativada. Por favor consulte os administradores');
        }

        UserLoggedEvent::dispatch($this->user);

        return $this->respond($request);
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
            'email' => $this->message,
        ]);
    }
}
