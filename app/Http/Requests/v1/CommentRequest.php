<?php

namespace App\Http\Requests\v1;

class CommentRequest extends CustomResponse
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content'=>'required|string|min:2|max:1000',
            'article_id'=>'required|exists:articles,id'
        ];
    }
}
