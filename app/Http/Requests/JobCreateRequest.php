<?php

namespace App\Http\Requests;

class JobCreateRequest extends ApiValidationRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [

        ];
    }
}
