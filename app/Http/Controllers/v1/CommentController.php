<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\v1\CommentRequest;
use App\Http\Requests\v1\CommentUpdateRequest;
use App\Models\Comment;
use App\Http\Controllers\Controller;


class CommentController extends Controller
{

    public function store(CommentRequest $request)
    {
            $comment=new Comment();
            $comment->user_id=auth()->id();
            $comment->article_id=$request->article_id;
            $comment->content=$request['content'];
            $comment->save();

            return successResponse([], 201);

    }


    public function update(CommentUpdateRequest $request, $id)
    {
        $comment=Comment::find($id);
        if(!$comment){
            return errorResponse(['comment'=>['This comment does not exist.']], 404);
        }
        info(json_encode($comment));
        if($comment->user_id !== auth()->id()){
            return errorResponse(['comment'=>['You are not authorized to perform this action']],403);
        }

        $comment->content=$request['content'];
        $comment->save();

        return successResponse([], 201);

    }

    public function destroy($id)
    {
        $comment=Comment::find($id);

        if(!$comment){
            return errorResponse(['comment'=>['This comment does not exist']],404);
        }

        if($comment->user_id !== auth()->id()){
            return errorResponse(['comment'=>['You are not authorized to perform this action']],403);
        }

        $comment->delete();

        return successResponse([], 204);

    }


}
