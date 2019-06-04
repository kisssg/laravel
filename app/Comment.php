<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //mass assignment
	protected $fillable= ['nickname', 'email', 'website', 'content', 'article_id'];
	public function article(){
		return $this->belongsTo('App\Article');
	}
}
	