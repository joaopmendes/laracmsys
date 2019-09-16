<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLang extends Model
{
   protected $table = 'language_post';
   protected $fillable = ["post_id", "language_id", "subject", "body"];
}
