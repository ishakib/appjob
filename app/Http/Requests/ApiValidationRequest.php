<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ApiValidationRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => 'ERROR',
            'code' => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY * 100,
            'message' => 'Validation errors',
            'details' => '',
            'locale' => app()->getLocale(),
            'data' => [
                'errors' => $validator->errors(),
            ]
        ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY));
    }
}
