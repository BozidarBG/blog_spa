<?php

namespace App\Http\Requests\v1;

use Illuminate\Validation\Rules;

class ResetPasswordRequest extends CustomResponse
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
        ];
    }
}
