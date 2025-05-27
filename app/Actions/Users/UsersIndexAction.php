<?php

namespace App\Actions\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UsersIndexAction extends Controller
{
    use ApiResponses, HybridResponse;

    public function __invoke(Request $request)
    {
        return $this->respond($request);
    }

    protected function inertia(Request $request)
    {
        $perPage = $request->input('per_page', 6);

        return Inertia::render('User/UserIndex', [
            'result' => User::with('roles')->paginate($perPage)->withQueryString()->through(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                    'force_password_reset' => $user->force_password_reset,
                    'active' => $user->active,
                    'email' => $user->email,
                    'roles' => $user->roles->map(fn ($role) => [
                        'id' => $role->id,
                        'name' => $role->name,
                    ]),
                ];
            }),
            'roles' => Role::all()->pluck('name', 'id'),
        ]);
    }

    protected function json()
    {
        // return response()->json([
        //     'users' => User::all(),
        // ]);
    }
}
