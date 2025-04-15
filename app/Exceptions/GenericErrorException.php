<?php

namespace App\Exceptions;

use Exception;

class GenericErrorException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['success' => false, 'message' => $this->getMessage()], $this->getCode());
    }
}
