<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\ScoreCard;

use App\Http\Controllers\Controller;
use App\ScoreCard\ScoreProject;
use App\ScoreCard\Score;
use Illuminate\Http\Request;
use App\ScoreCard\DataToScore as Data;
use Carbon\Carbon;
/**
 * Description of ScoreController
 *
 * @author Sucre.xu
 */
class ScoreController extends Controller
{

    public function index()
    {
        return false;
    }

    public function create(Request $request)
    {
        $project = ScoreProject::findOrFail($request->get('project'));
        $score = new Score();
        $score->setProject($project);
        $score->setData(1);
        $score->fill(["col1" => '0', "col4" => '1', 'col3' => '0-1']);
        $score->save();
        return $score->col1;
    }

    public function show($id, Request $request)
    {
        $project = ScoreProject::findOrFail($request->get('project'));
        $score = new Score;
        $result = $score->setProject($project)->where('data_id', $id)->first();
        return $result;
    }

    public function store(Request $request)
    {
        try {
            $project = ScoreProject::findOrFail($request->project_id);
            $dataInstance = new Data;
            $data = $dataInstance->setProject($project)->findOrFail($request->data_id);
            if( strtolower($data->owner)!= strtolower($request->user()->name) && !$request->user()->can('edit score of others in project'.$project->id)){
                throw new \Exception('You can\'t update data owned by '.$data->owner);
            }
            $score = new Score;
            $result = $score->setProject($project);
            $now = date('Y-m-d H:i:s');
            if (count($result->where("data_id", $request->data_id)->get()))
            {
                /**
                 * if record exists, update it; why firstOrCreate? actually the 'Create' part will never be triggered here,
                 * we only need the 'first-' part, only this way can the fillable() work.
                 * I don't know why this works, don't ask!
                 */
                $record = $result->firstOrCreate(["data_id" => $request->data_id], []);
                $record->fillable(explode(",", $project->score_fillable));
                $record->update($request->all());
                $carbon= Carbon::parse($record->created_at);
                $diff=(new Carbon)->diffInMinutes($carbon,true);
                if($diff > $project->minutes_allow_edit_in && !$request->user()->can('edit score of others in project'.$project->id)){                  
                    throw new \Exception("You can only edit the record in ".$project->minutes_allow_edit_in." minutes after you created it.");
                }
                return '{"result":"success","score":' . $record . ',"msg":"score updated at ' . $now."created at ".$record->created_at . '"}';
            }
            $result->fill($request->all());
            $result->save();
            $data->checked=1;
            $data->save();
            return '{"result":"success","score":' . $result . ',"msg":"score added at ' . $now . '"}';
        } catch (\Exception $e) {
            return '{"result":"failed","msg":"' . $e->getMessage() . '","score":null}';
        }
    }

    public function edit()
    {
        
    }

    public function update()
    {
        
    }

}
