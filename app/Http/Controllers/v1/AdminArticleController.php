<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Like;

class AdminArticleController extends Controller
{

    public function destroy($id)
    {
        $article=Article::where('id', $id)->first();

        if(!$article){
            return errorResponse(['article'=>['Requested article is not found!']], 404);
        }

        $article->genres()->detach();

        Comment::where('article_id', $article->id)->delete();

        Like::withTrashed()->where('article_id', $article->id)->forceDelete();

        $article->delete();

        return successResponse([], 200);
    }
}
