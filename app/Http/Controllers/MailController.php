<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailFailOverRequest;

use App\Jobs\MailFailOverJob;

class MailController extends Controller
{

    /**
     * @OA\Post(
     *     path="/send-mail-failover",
     *     tags={"Mail"},
     *     operationId="sendMailFailOver",
     *     @OA\Response(
     *         response=200,
     *         description="Successfully sent mail"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation failed"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     ),
     *     security={
     *         {"api_key": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Request body for sending mail",
     *         @OA\JsonContent(
     *             required={"title", "text", "emailAddresses", "g-recaptcha-response"},
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 description="Title of the email"
     *             ),
     *             @OA\Property(
     *                 property="text",
     *                 type="string",
     *                 description="Text content of the email"
     *             ),
     *             @OA\Property(
     *                 property="emailAddresses",
     *                 type="array",
     *                 @OA\Items(
     *                     type="string",
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="g-recaptcha-response",
     *                 type="string",
     *                 description="Google reCAPTCHA validation"
     *             )
     *         )
     *     )
     * )
     */
    public function sendMailFailOver(SendMailFailOverRequest $request)
    {
        $validatedData = $request->validated();
        $title = $validatedData['title'];
        $text = $validatedData['text'];
        $emailAddresses = $validatedData['emailAddresses'];

        foreach ($emailAddresses as $email) {
             MailFailOverJob::dispatch($title, $text, $email);
        }

        return response()->json(['status' => 'success'], 200);
    }
}
