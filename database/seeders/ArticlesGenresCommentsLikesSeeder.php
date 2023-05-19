<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleGenre;
use App\Models\Comment;
use App\Models\Genre;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ArticlesGenresCommentsLikesSeeder extends Seeder
{

    public $faker;
    public array $genres_ids=[];
    public array $users_ids=[];

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('genres')->truncate();
        DB::table('articles')->truncate();
        DB::table('article_genre')->truncate();
        DB::table('comments')->truncate();
        DB::table('likes')->truncate();

        $this->faker = Faker::create();


        //first create genres
        $this->createGenres();

        $this->genres_ids=Genre::get('id')->pluck('id')->toArray();

        //then take users ids created in users seeder
        $this->users_ids=User::get('id')->pluck('id')->toArray();

        //then create 300 articles
        for($x=1; $x<300; $x++){
            $date=Carbon::parse(now())->subDays(20)->addHours($x)->addMinutes(mt_rand(1,50));

            $article_id=$this->createArticle($date);

            //foreach article, 1-4 genres will be assigned
            $this->assignGenresToArticle($article_id);

            //foreach article, 1-10 comments will be created
            $this->createCommentsForArticle($article_id, $date);

            //foreach article, 0-12 likes will be created
            $this->createLikes($article_id);

        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function createArticle($date){
        $title=$this->faker->sentence(10, true);
        $article=new Article;
        $article->title=$title;
        $article->slug=Str::slug($title);
        $article->body=$this->faker->paragraph(20, true);
        $article->seo_keywords=$this->faker->words(3, true);
        $article->seo_description=$title;
        $article->user_id=(int) $this->faker->randomElement($this->users_ids);
        $article->created_at=$date;
        $article->updated_at=$date;
        $article->save();

        return $article->id;
    }

    private function createGenres(){
        $genres_names=['politics', 'economy', 'nature', 'sport', 'computers', 'smartphones', 'tablets', 'tech', 'cars', 'music', 'movies', 'pets', 'money', 'fitness', 'jobs', 'people', 'world', 'art', 'tattoos', 'food', 'environment', 'crime', 'holiday'];

        for($i=0; $i<count($genres_names); $i++){
            $g=new Genre();
            $g->name = $genres_names[$i];
            //$g->slug=Str::slug($names[$i]);
            $g->description=ucwords($genres_names[$i]).' is lorem ipsum something dolorem etc...';
            $g->save();
        }
    }

    private function assignGenresToArticle($article_id){
        $id_arr=[];
        $random_number=mt_rand(1,4);
        for($i=0; $i<$random_number; $i++){
            $id=mt_rand(1,count($this->genres_ids)-1);

            if(!in_array($id, $id_arr)){
                ArticleGenre::create(['genre_id'=>$id, 'article_id'=>$article_id]);
                $id_arr[]=$id;
            }
        }
    }

    private function createCommentsForArticle($article_id, $date){
        $number_of_comments=mt_rand(1,10);
        for($y=0; $y<$number_of_comments; $y++){
            $comment=new Comment();
            $comment->article_id=$article_id;
            $comment->user_id=$this->faker->randomElement($this->users_ids);
            $comment->content=$this->faker->sentence(10, true);
            $comment->created_at=Carbon::parse($date)->addHours(1+$y*4)->addMinutes(1+$y*4+10);
            $comment->updated_at=Carbon::parse($date)->addHours(1+$y*4)->addMinutes(1+$y*4+10);
            $comment->save();

        }
    }

    private function createLikes($article_id){
        $arr_of_liked=[];
        $number_of_likes=mt_rand(0,12);
        for($x=0; $x<$number_of_likes; $x++){
            $random_member=$this->faker->randomElement($this->users_ids);
            if(!in_array($random_member, $arr_of_liked)){
                Like::create(['user_id'=>(int) $random_member, 'article_id'=>$article_id]);
                $arr_of_liked[]=$random_member;
            }
        }
    }


}
