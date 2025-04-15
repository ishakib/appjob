<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthorizationFailsException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Authorization failed. The provided token is invalid or expired. Please ensure you are using a valid token and try again.'
        ], ResponseAlias::HTTP_UNAUTHORIZED);
    }
}
