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
use Illuminate\Http\Request;
/**
 * Description of ScoreController
 *
 * @author Sucre.xu
 */
class ScoreController extends Controller
{
    public function index(){
        return 'index';
    }
    public function create(Request $request){
        $project= ScoreProject::findOrFail($request->get('project'));
        $score= new Score();
        $score->setProject($project);
        $score->fill(["1"=>'1',"4"=>'2','3'=>'3']);
        $score->save();
        return $score->fillable;
    }
    
    public function show(){
        
    }
    
    public function store(){
        
    }
    
    public function edit(){
        
    }
    
    public function update(){
        
    }
    
}
