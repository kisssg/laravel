<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{

    use SoftDeletes;

    const DELETED_AT = 'removed_at';

    //relations
    public function hasManyComments()
    {
        return $this->hasMany('App\Comment', 'article_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
