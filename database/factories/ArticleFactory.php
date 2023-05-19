<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user=User::factory()->create();

        $genres=Genre::factory()->count(20)->create();
        $genres_ids=$genres->pluck('id');
        //dd($this->faker->randomElement($genres_ids));
        $title=$this->faker->sentence(10, true);
        return [
            'title'=>$title,
            'slug'=>Str::slug($title),
            'body'=>$this->faker->paragraph(10, true),
            'seo_keywords'=>$this->faker->word,
            'seo_description'=>$title,
            //'image'=>$this->faker->image(),
            'user_id'=>$user->id,
            //'genres[]'=>$this->faker->randomElement($genres_ids),

        ];

    }
}
