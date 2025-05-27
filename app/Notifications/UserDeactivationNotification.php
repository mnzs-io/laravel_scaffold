<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserDeactivationNotification extends Notification implements ShouldQueue
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
            ->subject('Conta Desativada')
            ->greeting('Olá, ' . $this->user->name)
            ->line('Informamos que sua conta foi desativada por um administrador do sistema.')
            ->line('Se você acredita que isso foi um erro ou deseja mais informações, entre em contato com o suporte.')
            ->line('Obrigado pela sua compreensão.');
    }
}
