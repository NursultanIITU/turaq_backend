<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClientException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json(["error" => true, "message" => $this->getMessage()], ResponseAlias::HTTP_BAD_REQUEST);
    }
}
