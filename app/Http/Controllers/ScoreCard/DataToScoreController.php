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
class DataToScoreController extends Controller
{

    public function index()
    {
        return 'index';
    }

    public function show($id, Request $request)
    {
        $project = Project::findOrFail($request->get('project'));
        $onCard = Arr::add(explode(",", $project->data_to_score_columns), '', 'id');
        $data = new Data;
        $result = $data->setProject($project)->findOrFail($id)->only($onCard);
        return $result; //->only(explode(",",$project->data_fillable));//->score($project,$id);
    }

    public function pick($id, Request $request)
    {
        //set owner to picker if data not picked yet
        try {
            $project = Project::findOrFail($request->get('project_id'));
            $dataInstance = new Data;
            $data = $dataInstance->setProject($project)->findOrFail($id);
            if ($data->owner !== null)
            {
                throw new \Exception($data->owner);
            }
            $data->owner = $request->user()->name;
            $data->save();
            return '{"result":"success","owner":"' . $data->owner . '"}';
        } catch (\Exception $e) {
            return '{"result":"failed","owner":"' . $e->getMessage() . '"}';
        }
    }

}
