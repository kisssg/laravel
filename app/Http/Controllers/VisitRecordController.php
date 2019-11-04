<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\VisitRecord;
use Illuminate\Http\Request;
/**
 * Description of VisitRecordController
 *
 * @author Sucre.xu
 */
class VisitRecordController extends Controller
{
    //put your code here
    public function getVisitRecords(Request $request){
        $id=$request->get('id');
        return VisitRecord::where("contract_appointee_id",$id)->where("visit_date","!=","0")->get();
    }
}
