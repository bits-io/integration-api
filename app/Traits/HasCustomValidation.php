<?php

namespace App\Traits;

use App\Helpers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HasCustomValidation
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHelper::error(
            'Validation',
            400,
            $validator->errors()
        ));
    }
}
