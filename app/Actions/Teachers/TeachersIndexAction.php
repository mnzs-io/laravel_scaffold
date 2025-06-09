<?php

namespace App\Actions\Teachers;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\MemoryCards\Organization;
use App\Models\MemoryCards\Subject;
use App\Models\User;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeachersIndexAction extends Controller
{
    use ApiResponses, HybridResponse;

    public function __invoke(Organization $organization, Request $request)
    {
        return $this->respond($request);
    }

    protected function inertia(Request $request)
    {
        $perPage = $request->input('per_page', 6);

        $teachers = self::paginatedTeachers($request->organization, $perPage);

        return Inertia::render('Teacher/TeacherIndex', [
            'breadcrumbs' => [['title' => 'Professores', 'href' => '#']],
            'result' => $teachers,
        ]);
    }

    protected function json()
    {
        // return response()->json([
        //     'users' => User::all(),
        // ]);
    }

    private static function paginatedTeachers(Organization $organization, int $perPage = 10): LengthAwarePaginator
    {
        return User::whereHas('associations', function ($query) use ($organization) {
            $query->where('role', Role::TEACHER)
                ->where('associable_type', Subject::class)
                ->whereIn('associable_id', function ($sub) use ($organization) {
                    $sub->select('id')
                        ->from('subjects')
                        ->where('organization_id', $organization->id);
                });
        })
            ->with(['associations' => function ($query) {
                $query->where('role', Role::TEACHER)
                    ->where('associable_type', Subject::class)
                    ->with(['associable:id,name,slug']);
            }])
            ->paginate($perPage)
            ->through(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'subjects' => $user->associations
                        ->map(fn ($assoc) => $assoc->associable)
                        ->filter()
                        ->unique('id')
                        ->values()
                        ->map(fn ($subject) => [
                            'id' => $subject->id,
                            'name' => $subject->name,
                            'slug' => $subject->slug,
                        ]),
                ];
            });
    }
}
