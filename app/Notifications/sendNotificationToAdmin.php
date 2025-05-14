<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class sendNotificationToAdmin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $code;
    public $email;
    public function __construct($code, $email)
    {
        $this->code = $code;
        $this->email = $email;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Creation de compte Administrateur')
            ->greeting('Bonjour!')
            ->line('Vous avez reçu cette notification car un compte administrateur a été créé pour vous avec succès.')
            ->line('Voici le code de vérification pour activer votre compte: ' . $this->code)
            ->line('Veuillez entrer le code ci-dessus pour activer votre compte.')
            ->line('Veuillez cliquer sur le lien ci-dessous pour activer votre compte.')
            ->action('Activer le compte', url('/validateaccount/' . $this->email))
            ->line('Merci d\'utiliser notre application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
