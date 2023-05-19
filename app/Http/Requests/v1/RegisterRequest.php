<?php

namespace App\Http\Requests\v1;

use Illuminate\Validation\Rules;

class RegisterRequest extends CustomResponse
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
            'agree'=>['required']
        ];
    }
}
