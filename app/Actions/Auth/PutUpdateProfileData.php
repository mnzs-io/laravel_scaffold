<?php

namespace App\Actions\Auth;

use App\Events\ModelUpdatedEvent;
use App\Http\Requests\Auth\UpdateUserProfileDataRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PutUpdateProfileData
{
    use ApiResponses, HybridResponse;

    private User $user;

    public function __invoke(UpdateUserProfileDataRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $newAvatar = $this->saveImage($request);
            if ($newAvatar) {
                $request->merge(['avatar' => $newAvatar]);
            }
            $antes = $user->toArray();
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'avatar' => $newAvatar ?? $user->avatar,
            ]);
            $user->refresh();
            $depois = $user->toArray();
            ModelUpdatedEvent::dispatch($user, $antes, $depois);

            DB::commit();
            $this->respond($request);
        } catch (Exception $e) {
            DB::rollBack();
            info($e);

            return $this->respondWithError($request, 'Erro ao salvar novos dados');
        }

    }

    private function saveImage(UpdateUserProfileDataRequest $request): ?string
    {
        $user = request()->user();
        if ($request->avatar) {
            $data = $request->input('avatar');
            if ($data && preg_match('/^data:image\\/(\\w+);base64,/', $data, $type)) {
                $data = substr($data, strpos($data, ',') + 1);
                $type = strtolower($type[1]);
                $data = base64_decode($data);

                $filename = time() . '-' . $user->id . '.' . $type;
                Storage::put("avatars/{$filename}", $data);

                return route('get.user.image', $filename);
            }
        } else {

            $user->update(['avatar' => '']);
        }

        return null;
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

    protected function inertiaFail()
    {
        return back()->withErrors([
            'success' => false,
            'message' => 'Erro ao salvar novos dados',
        ]);
    }
}
