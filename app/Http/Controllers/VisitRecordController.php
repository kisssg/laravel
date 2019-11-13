<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\VisitRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/**
 * Description of VisitRecordController
 *
 * @author Sucre.xu
 */
class VisitRecordController extends Controller
{
    //put your code here
    /**
     * 
     * @param Request $request
     * @return Array
     */
    public function getVisitRecords(Request $request){
        $id=$request->get('id');
        return VisitRecord::where("contract_appointee_id",$id)->where("visit_date","!=","0")->get();
    }
    /**
     * 
     * @param Request $request
     * @return Array
     */
    public function qualityInfo(Request $request){
        $id=$request->get('id');
        return DB::table('journal_data')
                ->selectRaw("distinct validity as name,count(*) as value")
                ->groupBy("validity")
                ->where("contract_appointee_id","=",$id)->get();        
    }
}
