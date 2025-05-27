<?php

namespace App\Actions\Auth;

use App\Actions\AuditableAction;
use App\Models\User;
use App\Notifications\UserDeactivationNotification;
use App\Tools\FlashMessage;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class PostDeactivateUserAction extends AuditableAction
{
    use ApiResponses, HybridResponse;

    private User $user;

    public function __invoke(User $user)
    {
        // TODO: LOg de auditoria
        if ($user->id === request()->user()->id) {
            $this->audit($user, $user, false);
            FlashMessage::warning('Você não pode solicitar desativação da própria conta');

            return back();
        }

        try {
            DB::beginTransaction();

            DB::commit();
            $user->active = false;
            $user->save();
            $this->audit(request()->user, $user, true);
            $user->notify(new UserDeactivationNotification($user));
            FlashMessage::success('Desativação realizada. O usuário será notificado');

            return back();
        } catch (Throwable $e) {
            DB::rollBack();
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
        $solicitante = $args[0];
        $alvo = $args[1];
        $realizado = $args[2];

        parent::log(get_class(), "Admin ({$solicitante->id}) solicitando reset de senha do usuário ({$alvo->id})", [
            'solicitante' => $solicitante,
            'alvo' => $alvo,
            'realizado' => $realizado,
        ]);
    }
}
