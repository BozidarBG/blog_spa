<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_genre', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('genre_id');
            //$table->unsignedBigInteger('article_id');
            //$table->timestamps();

            $table->foreignId('genre_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('article_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_genres');
    }
}
