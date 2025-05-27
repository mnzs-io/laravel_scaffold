<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class PasswordResetSignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected User $user) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

        $token = str()->random(64);
        $hashedToken = bcrypt($token);
        Cache::put("password_reset_token_{$this->user->id}", $hashedToken, now()->addMinutes(30));

        $url = URL::temporarySignedRoute(
            'get.password.reset.signed',
            Carbon::now()->addMinutes(30),
            [
                'user' => $this->user->id,
                'email' => $this->user->email,
                'token' => $token,
            ]
        );

        return (new MailMessage)
            ->subject('Redefinição de Senha')
            ->line('Caro, ' . $this->user->name . ', clique no botão abaixo para redefinir sua senha. O link é válido por 30 minutos.')
            ->action('Redefinir Senha', $url)
            ->line('Se você não solicitou isso, ignore este e-mail.');
    }
}
