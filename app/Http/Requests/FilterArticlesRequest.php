<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterArticlesRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'author'=>'integer',
            'created_after'=>'date',
            'created_before'=>'date',
            'per_page'=>'integer',
            'genre'=>'integer',
            'page'=>'integer'
        ];
    }
}
