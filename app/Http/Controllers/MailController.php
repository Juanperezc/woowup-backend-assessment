<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailFailOverRequest;

use App\Notifications\MailFailOverNotification;
use Illuminate\Support\Facades\Notification;

class MailController extends Controller
{
    public function sendMailFailOver(SendMailFailOverRequest $request)
    {
        $validatedData = $request->validated();
        $title = $validatedData['title'];
        $text = $validatedData['text'];
        $emailAddresses = $validatedData['emailAddresses'];

        foreach ($emailAddresses as $email) {
            Notification::route('mail', $email)->notify(new MailFailOverNotification($title, $text));
        }

        return response()->json(['status' => 'success'], 200);
    }
}
