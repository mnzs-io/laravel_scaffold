<?php

namespace App\Actions\Auth;

use App\Events\Auth\PasswordResetRequestedEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Tools\FlashMessage;
use App\Traits\HybridResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class PostForgotPasswordAction extends Controller
{
    use HybridResponse;

    public function __invoke(Request $request)
    {
        return $this->respond($request);
    }

    protected function inertia(Request $request)
    {
        if (RateLimiter::tooManyAttempts('forgot-password:' . $request->ip(), 5)) {
            return back()->withErrors([
                'email' => 'Aguarde um momento antes de tentar novamente.',
            ]);
        }

        RateLimiter::hit('forgot-password:' . $request->ip(), 60);

        $user = User::firstWhere('email', $request->email);
        if (!$user) {
            usleep(random_int(300_000, 600_000));
        } else {

            PasswordResetRequestedEvent::dispatch($user);
        }

        FlashMessage::success('Se houver uma conta com esse e-mail associado você receberá um e-mail de redefinição de senha', 'Pedido recebido');

        return back();
    }

    protected function json(Request $request)
    {
        // $data = $request->validated();

        // $user = User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        // ]);

        // $user->assignRole('client');

        // $token = $user->createToken('auth_token')->plainTextToken;

        // return response()->json([
        //     'message' => 'Conta criada com sucesso.',
        //     'user' => $user,
        //     'token' => $token,
        // ]);
    }
}
