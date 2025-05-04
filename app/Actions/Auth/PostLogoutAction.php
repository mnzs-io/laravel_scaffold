<?php

namespace App\Actions\Auth;

use App\Http\Controllers\Controller;
use App\Tools\FlashMessage;
use App\Traits\HybridResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLogoutAction extends Controller
{
    use HybridResponse;

    public function __invoke(Request $request)
    {
        FlashMessage::neutral(message: $request->user()->name, title: 'Até mais');

        return $this->respond($request);
    }

    protected function json()
    {
        // TODO: Destruir JWT
    }

    protected function inertia()
    {
        Auth::logout();

        return to_route('get.welcome');
    }
}
