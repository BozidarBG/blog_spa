<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleSingleResource extends JsonResource
{

    public function toArray($request)
    {
        return [

                'id'=>$this->id,
                'author'=>new AuthorResource($this->user),
                'title'=>$this->title,
                'slug'=>$this->slug,
                'content'=>$this->body,
                'date'=>$this->created_at->format('d.m.Y @ H:i:s'),
                'genres'=>$this->genres->pluck('name', 'id'),
                'likesCount'=>$this->likes_count,
                'likes'=>new LikeCollection($this->likes),
                'commentsCount'=>$this->comments_count,
                'comments'=>new CommentCollection($this->comments),
                'href'=>route('articles.show', ['id'=>$this->id]),

        ];
    }


}
