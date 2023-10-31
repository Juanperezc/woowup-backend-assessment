<?php

namespace App\Jobs;

use App\Notifications\MailFailOverNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class MailFailOverJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 240;
    public $tries = 2;

    private $title;
    private $text;
    private $notifiable;

    public function __construct($title, $text, $notifiable)
    {
        $this->title = $title;
        $this->text = $text;
        $this->notifiable = $notifiable;
    }

    public function handle()
    {
        $mailers = [];

    

        if (env('SPARKPOST_USERNAME') && env('SPARKPOST_PASSWORD')) {
            $mailers[] = 'sparkpostmail';
        }

        if (env('MAILGUN_USERNAME') && env('MAILGUN_PASSWORD')) {
            $mailers[] = 'mailgun';
        }
      

        foreach ($mailers as $mailer) {
            try {
                Notification::route('mail', $this->notifiable)
                    ->notifyNow(new MailFailOverNotification($this->title, $this->text, $mailer));
                break;
            } catch (\Exception $e) {
                Log::debug("Failed to send email using $mailer: " . $e->getMessage());
            }
        }
    }
}
