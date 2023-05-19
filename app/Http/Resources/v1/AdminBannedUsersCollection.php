<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminBannedUsersCollection extends ResourceCollection
{

    public $code;
    public $resource;

    public function __construct($resource, $code)
    {
        parent::__construct($resource);
        $this->resource=$resource;
        $this->code=$code;
    }

    public function toArray($request)
    {
        return [
            'success' => AdminBannedUsersResource::collection($this->resource),
            'code' => $this->code,

        ];
    }
}
