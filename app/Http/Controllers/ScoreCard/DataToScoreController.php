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
    
    public function show($id,Request $request){
        $project= Project::findOrFail($request->get('project'));
        $data= new Data;
        $result=$data->setProject($project)->findOrFail($id);
        return $result;//->only(explode(",",$project->data_fillable));//->score($project,$id);
    }

}
