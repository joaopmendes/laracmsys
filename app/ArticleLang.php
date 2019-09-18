<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleLang extends Model
{
   protected $table = 'language_article';
   protected $fillable = ["article_id", "language_id", "name", "body"];
}
