<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of OnlineTestController
 *
 * @author Sucre.xu
 */
class OnlineTestController extends Controller
{
    //put your code here
    public function index(){
        
    }
    public function getTraingTestResults(Request $request){
        $employee_id=$request->get('employee_id');
        $results= \App\TrainingTestResult::where('employee_id',$employee_id)->get();
        return $results;
    }
    public function getOnlineTestResults(Request $request){
        $employee_id=$request->get('employee_id');
        $results= \App\OnlineTestResult::where('employee_id',$employee_id)->get();
        return $results;        
    }
    
}
