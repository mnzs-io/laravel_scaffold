<?php

namespace App\Actions\Logs;

use App\Http\Controllers\Controller;
use App\Models\LogEntry;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LogsIndexAction extends Controller
{
    use ApiResponses, HybridResponse;

    public function __invoke(Request $request)
    {
        return $this->respond($request);
    }

    protected function inertia(Request $request)
    {
        $filters = [
            'system' => $request->input('system'),
            'level' => $request->input('level'),
            'type' => $request->input('type'),
            'user' => $request->input('user'),
            'resource' => $request->input('resource'),
        ];

        $field = $request->input('field', 'timestamp');
        $order = $request->input('order', 'desc') === 'asc' ? 'asc' : 'desc';
        $perPage = (int) $request->input('per_page', 10);
        $page = (int) $request->input('page', 1);

        $query = LogEntry::query()
            ->where('system', config('app.log.key'))
            ->when($filters['level'], fn ($q, $v) => $q->where('level', $v))
            ->when($filters['type'], fn ($q, $v) => $q->where('type', $v))
            ->when($filters['user'], fn ($q, $v) => $q->where('user', $v))
            ->when($filters['resource'], fn ($q, $v) => $q->where('resources', 'like', "%$v%"));

        $logs = $query->orderBy($field, $order)
            ->paginate($perPage, ['*'], 'page', $page)
            ->withQueryString();

        return Inertia::render('Log/LogIndex', [
            'result' => $logs,
            'filters' => $filters,
        ]);
    }

    protected function json(Request $request)
    {
        return $this->inertia($request);
    }
}
