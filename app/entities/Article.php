<?php

namespace App\entities;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'author_id', 'author', 'title', 'catagory', 'content',
    ];

    public function messages()
    {
        return $this->hasMany('App\entities\Message', 'message_article_id');
    }

    public function users()
    {
        return $this->belongsTo('App\entities\User');
    }
}
