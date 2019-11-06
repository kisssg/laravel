<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;

class ConcentrationController extends Controller
{
    public function index(Request $request)
    {
        $key = $request->get('s');
        return view('concentration.index')->withCollectors(Collector::where("name_cn", "like", "%" . $key . "%")->paginate(30));
    }    

}
