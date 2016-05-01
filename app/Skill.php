<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['name', 'crawled_at'];

    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
