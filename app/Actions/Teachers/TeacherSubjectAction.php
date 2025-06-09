<?php

namespace App\Actions\Organizations;

use App\Http\Controllers\Controller;
use App\Models\MemoryCards\Organization;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrganizationsEditAction extends Controller
{
    use ApiResponses, HybridResponse;

    public function __invoke(Organization $organization, Request $request)
    {
        return $this->respond($request);
    }

    protected function inertia(Request $request)
    {
        return Inertia::render('Organization/OrganizationEdit', [
            'organization' => $request->organization,
        ]);
    }

    protected function json()
    {
        // return response()->json([
        //     'users' => User::all(),
        // ]);
    }
}
