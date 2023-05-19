<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\v1\ArticleRequest;
use App\Http\Requests\FilterArticlesRequest;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Like;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ArticleCollection;
use App\Http\Resources\v1\ArticleSingleResource;


class ArticleController extends Controller
{

    public function index(FilterArticlesRequest $request)
    {
        $articles=Article::filterArticle($request);
        return new ArticleCollection($articles->appends($request->validated()), 200);
    }

    public function store(ArticleRequest $request)
    {
        $article=new Article;
        $article->title=$request->title;
        $article->user_id=auth()->id();
        $article->seo_keywords=$request->seo_keywords;
        $article->seo_description=$request->seo_description;
        $article->body=$request->body;
        $article->save();

        if($request->has('genres')){
            $article->genres()->sync($request->genres);
        }

        return successResponse([],201);
    }

    public function show($id)
    {
        $article=Article::with('user', 'likes', 'comments', 'genres')->withCount(['comments','likes'])->find($id);

        if($article){
            return successResponse(new ArticleSingleResource($article), 200);
        }else{
            return errorResponse(['article'=>["Article not found"]],404);
        }
    }

    public function update(ArticleRequest $request, $id)
    {
            $article=Article::where('id',$id)->first();

            if(!$article){
                return errorResponse(['article'=>["Article not found"]],404);
            }

            if($article->user_id !== auth()->id()){
                return errorResponse(['article'=>["You are not allowed to update this article"]],403);
            }

            $article->title=$request->title;
            $article->slug="";//in order to recreate slug
            $article->seo_keywords=$request->seo_keywords;
            $article->seo_description=$request->seo_description;
            $article->body=$request->body;
            $article->save();

            if($request->has('genres')){
                $article->genres()->sync($request->genres);
            }else{
                $article->genres()->detach();
            }

        return successResponse(new ArticleSingleResource($article),200);
    }

    public function destroy($id)
    {
        $article=Article::find($id);

        if(!$article){
            return errorResponse(['article'=>['Requested article is now found']], 404);
        }

        if($article->user_id !== auth()->id()){
            return response()->json(['error'=>true, 'data'=>'Not allowed!']);
        }
        $article->genres()->detach();
        //delete comments
        Comment::where('article_id', $article->id)->delete();
        //delete likes
        Like::withTrashed()->where('article_id', $article->id)->forceDelete();
        $article->delete();
        return successResponse([],200, 'Article deleted');
    }

}
