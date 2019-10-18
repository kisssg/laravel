<?php

namespace App\Http\Controllers;

class ConcentrationController extends Controller
{
    public function index()
    {
        //$key = \Request::get('s');
        return view('concentration.index');//->withCollectors(Collector::where("name_cn", "like", "%" . $key . "%")->paginate(30)->appends(['s' => $key]));
    }    

}
