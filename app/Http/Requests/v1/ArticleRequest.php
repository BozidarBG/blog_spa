<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends CustomResponse
{


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title'=>'required|string|min:2|max:255',
            'body'=>'required|string|min:2',
            'seo_keywords'=>'required|max:255',
            'seo_description'=>'required|max:255',
            'genres'=>'required|array|exists:genres,id',
            'genres.*'=>'required|integer|distinct',
            'image'=>'image|mimes:jpeg, jpg, png, gif|size:2048'
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'obavezno polje'
        ];
    }


}
