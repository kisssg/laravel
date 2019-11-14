<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Callback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/**
 * Description of CallbackController
 *
 * @author Sucre.xu
 */
class CallbackController extends Controller
{
    //put your code here
    public function getCallRecords(Request $request){
        $id=$request->get('hmid');
        return Callback::where("homer_id",$id)->where("qc_name","!=","已删除")->get();
    }
    public function connectInfo(Request $request){
        $id=$request->get('hmid');
        return DB::table('callback')
                ->selectRaw("distinct is_connected as name,count(*) as value")
                ->groupBy("is_connected")
                ->where("homer_id","=",$id)->get();
    }
    public function harassInfo(Request $request){
        $id=$request->get('hmid');
        return DB::table('callback')
                ->selectRaw("distinct is_harassed as name,count(*) as value")
                ->groupBy("is_harassed")
                ->where("homer_id","=",$id)->get();
    }
}
