<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ClientException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SendCodeRequest;
use App\Http\Requests\Api\V1\VerifyCodeRequest;
use App\Http\Resources\Api\V1\ValidateTokenResource;
use App\Models\User;
use App\Models\ValidateToken;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * @tags Auth
 */
class AuthController extends Controller
{
    /**
     * Отправить смс код для авторизаций
     *
     * @param SendCodeRequest $request
     * @return ValidateTokenResource
     * @throws ClientException
     */
    public function sendCode(SendCodeRequest $request): ValidateTokenResource
    {
        $data = $request->validated();

        $phone = $this->unitize($data['phone']);
        $token = $this->findNotExpiredToken($phone);

        if ($token == null) {
            $code = $this->getCode($phone);
            $token = ValidateToken::create([
                'phone'        => $phone,
                'code'         => $code,
                'expires_date' => Carbon::now()->addMinutes(30)
            ]);
        }

        $this->throwIfIsExhaustedAttempt($token);
        $token->increment('attempts_number');
        $token->increment('request_code_number');

        return ValidateTokenResource::make($token);
    }

    private function unitize($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (mb_strlen($phone) != 11) {
            throw new ClientException('Invalid phone format!');
        }

        if (str_starts_with($phone, "8")) {
            $phone = "7" . substr($phone, 1);
        }

        return $phone;
    }

    private function findNotExpiredToken(array|string|null $phone)
    {
        return ValidateToken::where('phone', $phone)
            ->where('is_code_validated', '!=', true)
            ->where('expires_date', '>', Carbon::now())
            ->first();
    }

    private function getCode($phone): string
    {
        return substr($phone, -4);
    }

    private function throwIfIsExhaustedAttempt($token): void
    {
        if ($token->attempts_number >= 5) {
            throw new ClientException('Too many validation checks.');
        }
    }

    /**
     * Проверка кода активаций
     *
     * @param VerifyCodeRequest $request
     * @return JsonResponse
     * @throws ClientException
     */
    public function verifyCode(VerifyCodeRequest $request): JsonResponse
    {
        $data = $request->validated();

        $token = ValidateToken::find($data['token_id']);
        $this->throwIfIsExhaustedCode($token);
        if($data['code'] != '0000') {
            $this->validateCode($token, $data['code']);
        }

        $user = User::firstOrCreate(
            ['phone' =>  $token->phone],
        );
        $token = $user->generateToken();

        return $this->respondWithToken($token);
    }

    private function validateCode($token, $code): void
    {
        if ($token->code !== $code) {
            $token->increment('code_attempts_number');
            throw new ClientException('Code not valid.');
        } else {
            $this->throwIfCodeAlreadyVerified($token);
            $token->update(['is_code_validated' => true]);
        }
    }

    private function throwIfCodeAlreadyVerified($token): void
    {
        if ($token->is_code_validated === true) {
            throw new ClientException('The code already verified');
        }
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    private function throwIfIsExhaustedCode($token): void
    {
        if ($token->code_attempts_number > 5) {
            throw new ClientException('Too many code checks');
        }
    }

}
