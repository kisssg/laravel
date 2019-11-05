<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Callback;
use Illuminate\Http\Request;
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
}
