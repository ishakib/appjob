<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as ResponseAlias;

class UserNotFoundException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['success' => false, 'message' => 'User not found'], ResponseAlias::HTTP_NOT_FOUND);
    }
}
