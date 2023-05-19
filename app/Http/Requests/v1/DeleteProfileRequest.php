<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class DeleteProfileRequest extends CustomResponse
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password'=>'required'
        ];
    }
}
