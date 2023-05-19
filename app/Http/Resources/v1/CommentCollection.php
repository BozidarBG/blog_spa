<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
