<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;

class IssueController extends Controller
{

    public function home()
    {
        return view('issue.home')->withIssues(\App\Issue::paginate(20))->with('search','');
    }

    public function show($id)
    {
        return view("issue.show")->withIssue(\App\Issue::findOrFail($id));
    }

    public function search()
    {
        $key = \Request::get('s');
        $column=preg_match('/\d+/',$key)?'contract_no':'collector';
        return view("issue.home")->withIssues(\App\Issue::where($column, 'like', '%' . $key . '%')->orderBy('result','desc')->paginate(20)->appends(['s' => $key]))->with('search',$key);
    }

}
