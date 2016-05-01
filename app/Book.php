<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable = ['title', 'skill', 'author', 'author_bio', 'description', 'price', 'rating', 'img_url', 'book_url'];

    public function skill()
    {
        return $this->belongsTo('App\Skill', 'skill');
    }
}
