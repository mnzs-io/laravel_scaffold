<?php

namespace App\Actions\Users;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Tools\Cache\UserCache;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
            'breadcrumbs' => [['title' => 'Lista de Usuários', 'href' => '#']],
            'result' => User::paginate($perPage)->withQueryString()->through(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                    'force_password_reset' => $user->force_password_reset,
                    'active' => $user->active,
                    'email' => $user->email,
                    'associations' => UserCache::associations($user),
                ];
            }),
            'roles' => Role::cases(),
        ]);
    }

    protected function json()
    {
        // return response()->json([
        //     'users' => User::all(),
        // ]);
    }
}
