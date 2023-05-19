<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminBannedUsersResource extends JsonResource
{

    public function toArray($request)
    {
         //info(json_encode(get_object_vars($this)));
        return [
            'id'=>$this->id,
            'banned_user'=>new AuthorResource($this->banned_user),
            //'banned_by'=>new AuthorResource($this->banned_by),
            'banned_by_admin'=>new AuthorResource($this->banned_by_admin),
            'reason'=>$this->reason,
            'banned_until'=>$this->until

        ];
    }
}
