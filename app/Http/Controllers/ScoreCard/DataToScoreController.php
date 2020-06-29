<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\ScoreCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ScoreCard\ScoreProject as Project;
use App\ScoreCard\DataToScore as Data;
use Illuminate\Support\Arr;

/**
 * Description of ScoreController
 *
 * @author Sucre.xu
 */
class DataToScoreController extends Controller {

    public function index() {
        return 'index';
    }

    public function show($id, Request $request) {
        $project = Project::findOrFail($request->get('project'));
        $onCard = Arr::add(explode(",", $project->data_to_score_columns), '', 'id');
        $data = new Data;
        $result = $data->setProject($project)->findOrFail($id)->only($onCard);
        return $result; //->only(explode(",",$project->data_fillable));//->score($project,$id);
    }

    public function pick($id, Request $request) {
        //set owner to picker if data not picked yet
        try {
            $project = Project::findOrFail($request->get('project_id'));
            $ceil_uncheck = $project->uncheck_ceiling; //max count of data a person can leave uncheck;  

            $dataInstance = new Data;
            $owner=$request->user()->name;
            $uncheck = $dataInstance->setProject($project)->selectRaw('count(*) as count')->where("owner", $owner)->where('checked', 0)->count();
            if ($uncheck >= $ceil_uncheck) {
                throw new \Exception("You can't pick more as you have data uncheck(" . $uncheck . ") reached ceil " . $ceil_uncheck);
            }
            $data = $dataInstance->setProject($project)->findOrFail($id);
            if ($data->owner !== null && $data->owner !== '') {
                throw new \Exception('Already picked by '.$data->owner);
            }
            $data->owner = $request->user()->name;
            $data->picked_at=date("Y-m-d H:i:s");
            $data->save();
            return '{"result":"success","owner":"' . $data->owner . '","msg":""}';
        } catch (\Exception $e) {
            return '{"result":"failed","owner":"","msg":"' . $e->getMessage() . '"}';
        }
    }

    public function batchpick($id, Request $request) {
        /**
         * set all selected data to the picker
         */
        try {
            $project = Project::findOrFail($request->get('project_id'));
            
            $criterias = explode(',',$project->batchpick_depends_on);//['upload_batch', 'AGENT_EMPLOYEE_ID']; //fields that will be checked if align with data clicked
            $ceil_uncheck = $project->uncheck_ceiling; //max count of data a person can leave uncheck;  
            $dataInstance = new Data;
            $owner = $request->user()->name;
            $uncheck = $dataInstance->setProject($project)->selectRaw('count(*) as count')->where("owner", $owner)->where('checked', 0)->count();
            if ($uncheck >= $ceil_uncheck) {
                throw new \Exception("You can't pick more as you have data uncheck(" . $uncheck . ") reached ceil " . $ceil_uncheck);
            }
            $data = $dataInstance->setProject($project)->findOrFail($id);
            $result=$dataInstance->setProject($project)->where(function($query) use ($criterias, $data) {
                        foreach ($criterias as $criteria) {
                            if ($data->$criteria === '' || $data->$criteria === null) {
                                throw new \Exception($criteria . ' blank data can\'t be picked now. ');
                            }
                            $query->where($criteria, $data->$criteria);
                        }
                    })->where('owner', '')
                    ->update(['owner' => $owner, "picked_at" => date('Y-m-d H:i:s')]);
                    if($result===0){
                        throw new \Exception('You missed, try another.');
                    }
            return '{"result":"success","owner":"' . $owner . '","msg":"+'.$result.'"}';
        } catch (\Exception $e) {
            return '{"result":"failed","owner":"","msg":"' . $e->getMessage() . '"}';
        }
    }

}
