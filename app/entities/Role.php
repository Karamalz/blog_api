<?php

namespace App\entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'uid', 'roles', 'description'
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }
    
}
