<?php
/**
 * Created by PhpStorm.
 * User: mitrovic
 * Date: 15.3.23.
 * Time: 16.53
 */

namespace App\Traits;


use App\Models\Article;
use App\Models\Genre;

//use Illuminate\Database\Eloquent\Builder;

trait FilterArticles
{
    public static function filterArticle($request){

        $allowed_filters=[
            'author'=>['user_id', '='],
            'created_after'=>['created_at', '>'],
            'created_before'=>['created_at', '<'],
        ];

        $per_page=10;

        if($request->has('per_page') && $request->per_page >2 && $request->per_page <=50){
            $per_page=$request->per_page;
        }

        if($request->has('genre')){
            $genre=Genre::where('id', $request->genre)->first();

            if(!$genre){
                return errorResponse(['genre'=>['This genre does not exist']], 404);
            }

            $articles=$genre->articles()->with(['user', 'likes', 'comments', 'genres'])
                ->withCount(['comments','likes'])
                ->where(function($query) use ($request, $allowed_filters){
                    foreach ($request->validated() as $key=>$value){
                        if(array_key_exists($key, $allowed_filters)){
                            $query->where($allowed_filters[$key][0], $allowed_filters[$key][1], $value);
                        }

                    }
                })
                ->orderBy('created_at', 'desc')
                ->paginate($per_page);
        }else{
            $articles= Article::with(['user', 'likes', 'comments', 'genres'])
                ->withCount(['comments','likes'])
                ->where(function($query) use ($request, $allowed_filters){
                    foreach ($request->validated() as $key=>$value){
                        if(array_key_exists($key, $allowed_filters)){
                            $query->where($allowed_filters[$key][0], $allowed_filters[$key][1], $value);
                        }

                    }
                })
                ->orderBy('created_at', 'desc')
                ->paginate($per_page);
        }

        return $articles;

    }
}
