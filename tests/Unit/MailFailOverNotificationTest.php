
<?php

use App\Notifications\MailFailOverNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;



it('uses mailgun when provided', function () {
    $mailer = 'mailgun';
    Log::shouldReceive('debug')->never();
    Log::shouldReceive('error')->never();
    
    $notification = new MailFailOverNotification('Test Title', 'Test Text', $mailer);
    $mailMessage = $notification->toMail(null);
    
    expect($mailMessage)->toBeInstanceOf(MailMessage::class);
    expect($mailMessage->subject)->toBe('Test Title');
    expect($mailMessage->introLines)->toContain('Test Text');
});

it('uses sendgrid when provided', function () {
    $mailer = 'sendgrid';
    Log::shouldReceive('debug')->never();
    Log::shouldReceive('error')->never();

    $notification = new MailFailOverNotification('Test Title', 'Test Text', $mailer);
    $mailMessage = $notification->toMail(null);

    expect($mailMessage)->toBeInstanceOf(MailMessage::class);
    expect($mailMessage->subject)->toBe('Test Title');
    expect($mailMessage->introLines)->toContain('Test Text');
});

