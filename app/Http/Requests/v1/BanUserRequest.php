<?php

namespace App\Http\Requests\v1;


use Illuminate\Foundation\Http\FormRequest;

class BanUserRequest extends CustomResponse
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'user_id'=>'required|exists:users,id',
            'reason'=>'required|string|max:255',
            'plus_days'=>"required|integer"
        ];
    }
}
