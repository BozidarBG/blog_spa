<?php

namespace App\Http\Requests\v1;


class UpdateAvatarRequest extends CustomResponse
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'avatar' => 'required|image|max:2048',
        ];
    }
}
