<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{

    public $code;

    public function __construct($resource, $code)
    {
        parent::__construct($resource);
        $this->code=$code;
    }

    public function toArray($request)
    {

        return [
            'success'=>$this->collection,
            'code'=>$this->code
        ];
    }
}




