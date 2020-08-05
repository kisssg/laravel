<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ConcentrationController extends Controller
{
    public function index(Request $request)
    {
        $key = $request->get('s');
        return view('concentration.index');
    }
    
    function camera($id,Request $request){
        $indevidual=DB::table('cameras')->
                leftJoin('camera_scores','cameras.id','=','camera_scores.data_id')->
                selectRaw('left(camera_scores.created_at,7) as month,CAST(avg(camera_scores.score) as DECIMAL(10,2)) as score, count(camera_scores.score) as checked')->
                where('cameras.agent_employee_id',$id)->
                whereRaw('checked > 0')->
                whereRaw('cameras.deleted_at is null')->orderBy('month','asc')->groupBy('month')->get();
        $date=DB::table('cameras')->
                leftJoin('camera_scores','cameras.id','=','camera_scores.data_id')->
                selectRaw("distinct left(camera_scores.created_at,7) as date")->
                where('cameras.agent_employee_id',$id)->
                whereRaw('checked > 0')->get();
        $month=collect(Arr::pluck($date,'date'))->join("','");
        $summarize=DB::table('cameras')->
                leftJoin('camera_scores','cameras.id','=','camera_scores.data_id')->
                selectRaw('left(camera_scores.created_at,7) as month,CAST(avg(camera_scores.score) as DECIMAL(10,2)) as score, count(camera_scores.score)/(count(distinct cameras.agent_employee_id)) as checked')->
                whereRaw('checked > 0')->
                whereRaw("left(camera_scores.created_at,7) in ( '".$month."')")->
                whereRaw('cameras.deleted_at is null')->orderBy('month','asc')->groupBy('month')->get();        
        $labels = [];
        $avg_checked = [];
        $avg_score = [];
        $collector_checked = [];
        $collector_score = [];

        foreach ($indevidual as $item) {
            array_push($labels, $item->month);
            array_push($collector_checked, $item->checked);
            array_push($collector_score, $item->score);
        }
        foreach ($summarize as $item) {
            array_push($avg_checked, $item->checked);
            array_push($avg_score, $item->score);
        }

        $chartdata = [
            "labels" => $labels,
            "datasets" => [
                [
                    "label" => 'Collector score',
                    "data" => $collector_score,
                    "type" => "line",
                    "borderColor" => "lightgreen",
                    "fill" => false,
                    "yAxisID" => 'right-y-axis'
                ],
                [
                    "label" => 'Average score',
                    "data" => $avg_score,
                    "type" => "line",
                    "borderColor" => "green",
                    "fill" => false,
                    "yAxisID" => 'right-y-axis'
                ],
                [
                    "label" => 'Collector checked',
                    "data" => $collector_checked,
                    "stack" => "stack 1",
                    "backgroundColor" => 'lightgrey',
                    "yAxisID" => 'left-y-axis'
                ],
                [
                    "label" => 'Average checked',
                    "data" => $avg_checked,
                    "stack" => "stack 2",
                    "backgroundColor" => 'grey',
                    "yAxisID" => 'left-y-axis'
                ],               
            ]
        ];
        return response()->json($chartdata);         
    }
}
