<?php

namespace App\Models;

use App\Traits\FilterArticles;
use Cviebrock\EloquentSluggable\Sluggable;
use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    use Sluggable;
    use FilterArticles;


    protected $fillable=['title', 'slug', 'body', 'user_id', 'image', 'seo_keywords', 'seo_description'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function genres(){
        return $this->belongsToMany(Genre::class, 'article_genre', 'article_id', 'genre_id');
    }

//    public function genres_filtered(Request $request){
//        return $this->belongsToMany(Genre::class, 'article_genre', 'article_id', 'genre_id')->wherePivotIn('id', $request);
//    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
