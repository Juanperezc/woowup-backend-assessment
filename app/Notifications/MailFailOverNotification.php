<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class MailFailOverNotification extends Notification
{
    use Queueable;

    private $title;
    private $text;
    private $mailer;

    public function __construct($title, $text, $mailer)
    {
        $this->title = $title;
        $this->text = $text;
        $this->mailer = $mailer;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        try {
            $mailMessage = (new MailMessage)
                ->mailer($this->mailer)
                ->subject($this->title)
                ->line($this->text);

            return $mailMessage;
        } catch (\Exception $e) {
            Log::error("Failed to send email: " . $e->getMessage());
            throw $e;
        }
    }
}
