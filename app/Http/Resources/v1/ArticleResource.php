<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;


class ArticleResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'author'=>$this->user->name,
            'title'=>$this->title,
            'slug'=>$this->slug,
            'shortContent'=>Str::words($this->body, 15),
            'date'=>$this->created_at->format('d.m.Y @ H:i:s'),
            'genres'=>$this->genres->pluck('name', 'id'),
            'likesCount'=>$this->likes_count,
            'commentsCount'=>$this->comments_count,
            'href'=>route('articles.show', ['id'=>$this->id]),
        ];
    }
}
