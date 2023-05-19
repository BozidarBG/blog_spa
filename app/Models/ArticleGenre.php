<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleGenre extends Pivot
{
    use HasFactory;

    protected $table="article_genre";
    public $timestamps=false;
}
