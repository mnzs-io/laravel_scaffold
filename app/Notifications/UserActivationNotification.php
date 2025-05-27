<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserActivationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected User $user) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Conta Ativada')
            ->greeting('Olá, ' . $this->user->name)
            ->line('Sua conta foi ativada por um administrador e agora você pode acessar o sistema normalmente.')
            ->line('Se você tiver alguma dúvida ou problema, entre em contato com o suporte.')
            ->line('Bem-vindo de volta!');
    }
}
