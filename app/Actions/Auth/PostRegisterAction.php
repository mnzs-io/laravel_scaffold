<?php

namespace App\Actions\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Tools\FlashMessage;
use App\Traits\HybridResponse;
use Illuminate\Support\Facades\Auth;

class PostRegisterAction extends Controller
{
    use HybridResponse;

    public function __invoke(RegisterRequest $request)
    {
        return $this->respond($request);
    }

    protected function json(RegisterRequest $request)
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

    protected function inertia(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->assignRole(Role::CLIENT);

        Auth::login($user);
        session()->regenerate();

        FlashMessage::success('Conta criada com sucesso!');

        return to_route('get.dashboard');
    }
}
