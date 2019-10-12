<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collector;
use Illuminate\Validation\Rule;
use App\Imports\ImportCollectors;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\ExcelHandle;

/**
 * Description of FcCameraScoreController
 *
 * @author Sucre.xu
 */
class FcCameraScoreController extends Controller
{
    //put your code here
    public function index(){
        $key= \Request::get('s');
        return view('camera.index')->withCameras(\App\FcCameraScore::where('name_collector','like',"%".$key."%")->paginate(30)->appends(['s'=>$key]));
    }
}
