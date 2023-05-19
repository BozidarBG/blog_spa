<?php

namespace App\Http\Controllers\v1;

use App\Models\Like;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function toggle(Request $request, $id){
        $article=Article::where('id', $id)->first();

        if(!$article){
            return errorResponse(['article'=>["Article not found"]],404);
        }

        $like=Like::withTrashed()->where(['user_id'=> auth()->id(), 'article_id'=> $article->id])->first();


        if($like){
            //user has unliked before so now it is like
            if($like->trashed()){
                $like->restore();
                return successResponse([], 200, 'Article liked');

            }else{
                //user has liked it before so now it is unlike
                $like->delete();
                return successResponse([], 200, 'Article unliked');
            }
            
        }else{
            //user has not liked this article before so it is now like
            $like=new Like();
            $like->user_id=auth()->id();
            $like->article_id=$article->id;
            $like->save();
            return successResponse([], 200, 'Article liked');
        }
        

    }
}
