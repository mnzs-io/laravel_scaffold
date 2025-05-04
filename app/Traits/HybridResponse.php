<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HybridResponse
{
    public function respond(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->json($request);
        }

        return $this->inertia($request);
    }

    public function respondWithError(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->jsonFail();
        }

        return $this->inertiaFail();
    }
}
