<?php

namespace App\Actions\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    protected function inertia()
    {

        return Inertia::render('User/UserIndex', [
            'users' => User::with('roles:name')->get(),
        ]);
    }

    protected function json()
    {
        // return response()->json([
        //     'users' => User::all(),
        // ]);
    }
}
