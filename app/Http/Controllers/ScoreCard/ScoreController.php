<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\ScoreCard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use App\ScoreCard\ScoreProject;
use App\ScoreCard\Score;
use App\ScoreCard\DataToScore;
use Illuminate\Http\Request;

/**
 * Description of ScoreController
 *
 * @author Sucre.xu
 */
class ScoreController extends Controller
{

    public function index()
    {
        return 'index';
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
        return '{"result":"hell no"}';
        $project = SocreProject::findOrFail($request->get('project'));
        $scoreObj = new Score();
        $score = $scoreObj->setProject($project)->where('data_id', $request->score->data_id);
        $score->setData($request->score->data_id);
        $score->fill($request);
        $score->save();
        return $request;
    }

    public function edit()
    {
        
    }

    public function update()
    {
        
    }

}
