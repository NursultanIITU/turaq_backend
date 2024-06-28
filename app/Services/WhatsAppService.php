<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function sendVerificationCode($to, $code): void
    {
        $message = "Your verification code is: {$code}";

        $test = $this->twilio->messages->create(
            "whatsapp:{$to}",
            [
                'from' => "whatsapp:+14155238886", // Use the Twilio sandbox number
                'body' => $message
            ]
        );
    }
}
