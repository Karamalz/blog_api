<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'author_id', 'author', 'title', 'catagory', 'content',
    ];

    public function messages()
    {
        return $this->hasMany('App\Message', 'message_article_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
