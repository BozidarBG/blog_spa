<?php

namespace App\Http\Requests\v1;


use Illuminate\Validation\Rules;

class ChangePasswordRequest extends CustomResponse
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email'=>'email|required',
            'old_password' => 'required',
            'new_password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
        ];
    }


}
