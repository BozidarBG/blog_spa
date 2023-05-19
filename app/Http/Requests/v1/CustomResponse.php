<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class CustomResponse extends FormRequest
{
    public function failedValidation(Validator $validator) {
        $response = response()->json([
            'response'=>['errors' => $validator->errors(),  'code'=>422],
        ]);

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
