<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the article list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects= \App\ScoreCard\ScoreProject::all();
        return view('welcome')->withProjects($projects);
    }
    public function home(){
        return view('home');
    }
}
