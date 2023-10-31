<?php

use Biscolab\ReCaptcha\Facades\ReCaptcha;
use function Pest\Laravel\{postJson};
use Illuminate\Support\Facades\Notification;

$route = '/api/v1/send-mail-failover';
it('fails validation with no data', function () use($route) {
    $response = postJson($route, []);

    $response->assertStatus(422);
});

it('sends mail successfully with valid data', function () use ($route) {

    ReCaptcha::shouldReceive('validate')
            ->once()
            ->andReturnTrue();
    Notification::fake();
    $payload = [
        'title' => 'Test Title',
        'text' => 'Test Text',
        'emailAddresses' => ['test1@example.com', 'test2@example.com'],
        'g-recaptcha-response' => 'some-valid-recaptcha-response' 
    ];

    $response = postJson($route, $payload);

    $response->assertStatus(200)
              ->assertJson(['status' => 'success']);
});

it('fails when email is invalid', function () use ($route) {
    $payload = [
        'title' => 'Test Title',
        'text' => 'Test Text',
        'emailAddresses' => ['invalid-email', 'test2@example.com'],
        'g-recaptcha-response' => 'some-valid-recaptcha-response'
    ];

    $response = postJson($route, $payload);

    $response->assertStatus(422);
});

it('fails when title is missing', function () use ($route) {
    $payload = [
        'text' => 'Test Text',
        'emailAddresses' => ['test1@example.com', 'test2@example.com'],
        'g-recaptcha-response' => 'some-valid-recaptcha-response'
    ];

    $response = postJson($route, $payload);

    $response->assertStatus(422);
});
