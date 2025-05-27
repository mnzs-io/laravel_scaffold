<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user' => ['required', 'uuid', 'exists:users,id'],
            'token' => ['required', 'string', 'size:64'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    public function messages(): array
    {
        return [
            'user.*' => 'ID inválido',
            'token.*' => 'Token inválido',

            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (
                $validator->errors()->has('user') ||
                $validator->errors()->has('token')
            ) {
                $validator->errors()->forget('user');
                $validator->errors()->forget('token');
                if (!$validator->errors()->has('password')) {
                    $validator->errors()->add('credentials', 'Link inválido ou expirado, solicite novamente o e-mail da senha');
                }
            }
        });
    }
}
