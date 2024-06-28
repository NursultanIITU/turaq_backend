<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

/**
 * @tags Verification
 */
class VerificationController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required', // validate phone number
        ]);

        $phone = $request->input('phone');
        $code = rand(100000, 999999); // generate a random 6-digit code

        // Send the code via WhatsApp
        $this->whatsAppService->sendVerificationCode($phone, $code);

        return response()->json(['message' => 'Verification code sent.']);
    }

}
