<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthorizationTokenNotFoundException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Authorization token not found in the request. Please ensure you are sending the token in the correct format and try again.'
        ], ResponseAlias::HTTP_UNAUTHORIZED);
    }
}
