<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class MailFailOverNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $title;
    private $text;

    public function __construct($title, $text)
    {
        $this->title = $title;
        $this->text = $text;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        // Inicializa un arreglo vacío para almacenar los servicios de correo habilitados
        $mailers = [];

        // Verifica si Mailgun está configurado
        if (env('MAILGUN_USERNAME') && env('MAILGUN_PASSWORD')) {
            $mailers[] = 'mailgun';
        }

        // Verifica si SendGrid está configurado
        if (env('SENDGRID_USERNAME') && env('SENDGRID_PASSWORD')) {
            $mailers[] = 'sendgrid';
        }

        // Asegúrate de tener al menos un servicio de correo electrónico configurado
        if (empty($mailers)) {
            Log::error('No mailers settings found');
            return null;
        }

        foreach ($mailers as $mailer) {
            try {
                return (new MailMessage)
                    ->mailer($mailer)
                    ->subject($this->title)
                    ->line($this->text);
            } catch (\Exception $e) {
                Log::warning("Failed to send email using $mailer: " . $e->getMessage());
            }
        }

        return null;
    }
}
