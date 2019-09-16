<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['color'];
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function traduction()
    {
        return $this->belongsToMany(Language::class)
            ->withPivot('name');
    }
}
