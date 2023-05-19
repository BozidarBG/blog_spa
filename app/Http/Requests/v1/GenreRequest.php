<?php

namespace App\Http\Requests\v1;


class GenreRequest extends CustomResponse
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'=>'required|string|min:2|max:255|unique:genres,name',
            'description'=>'required|string|min:2',
        ];
    }
}
