<?php

namespace App\Actions\Auth;

use App\Actions\AuditableAction;
use App\Http\Requests\Auth\UpdateUserProfileDataRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PutUpdateProfileData extends AuditableAction
{
    use ApiResponses, HybridResponse;

    private User $user;

    public function __invoke(UpdateUserProfileDataRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $antes = $user->toArray();
            $user->update($request->validated());
            $depois = $user->toArray();
            $this->audit($antes, $depois);

            DB::commit();
            $this->respond($request);
        } catch (Exception $e) {
            DB::rollBack();
            Log::channel('auditoria')->error('Erro ao atualizar dados', ['erro' => $e]);
            throw $e;
        }

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

    protected function audit(...$args): void
    {
        parent::log(get_class(), 'Atualização de dados de usuário', [
            'antes' => $args[0],
            'depois' => $args[1],
        ]);
    }
}
