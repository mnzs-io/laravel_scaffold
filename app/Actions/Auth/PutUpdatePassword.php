<?php

namespace App\Actions\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateUserPasswordRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Support\Facades\Hash;

class PutUpdatePassword extends Controller
{
    use ApiResponses, HybridResponse;

    private User $user;

    public function __invoke(UpdateUserPasswordRequest $request, User $user)
    {
        if (!Hash::check($request->current, $user->password)) {
            return back()->withErrors(['current' => 'A senha atual está incorreta.']);
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        $this->respond($request);
    }

    protected function json()
    {
        // return response()->json([
        //     'user' => $this->user,
        //     'token' => $this->user->createToken('auth_token')->plainTextToken,
        // ]);
    }

    protected function inertia()
    {
        return back()->with([
            'success' => true,
        ]);
    }
}
