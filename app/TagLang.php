<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagLang extends Model
{
   protected $table = 'language_tag';
   protected $fillable = ["tag_id", "language_id", "name"];
}
