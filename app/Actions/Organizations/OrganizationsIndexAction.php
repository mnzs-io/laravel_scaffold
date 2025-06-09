<?php

namespace App\Actions\Organizations;

use App\Http\Controllers\Controller;
use App\Models\MemoryCards\Organization;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrganizationsIndexAction extends Controller
{
    use ApiResponses, HybridResponse;

    public function __invoke(Request $request)
    {
        return $this->respond($request);
    }

    protected function inertia(Request $request)
    {
        $perPage = $request->input('per_page', 6);

        return Inertia::render('Organization/OrganizationIndex', [
            'breadcrumbs' => [['title' => 'Lista de Cursos', 'href' => '#']],
            'result' => Organization::with('address')->paginate($perPage)->withQueryString(),
        ]);
    }

    protected function json()
    {
        // return response()->json([
        //     'users' => User::all(),
        // ]);
    }
}
