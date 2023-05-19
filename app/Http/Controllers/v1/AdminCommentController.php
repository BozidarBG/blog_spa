<?php

namespace App\Http\Controllers\v1;

use App\Models\Comment;
use App\Http\Controllers\Controller;


class AdminCommentController extends Controller
{
    public function destroy($id)
    {
        $comment=Comment::find($id);
        if(!$comment){
            return errorResponse(['comment'=>['This comment does not exist']], 404);
        }

        $comment->delete();

        return successResponse([], 200);

    }

}
