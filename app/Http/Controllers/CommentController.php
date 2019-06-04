<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    //store comment
    public function store(Request $request){
    	if(Comment::create($request->all())){
    		return redirect()->back();
    	}else{
    		return redirect()->back()->withInput()->withErrors('评论发表失败！');
    	}
    }
}
