<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\ScoreCard;

use Illuminate\Database\Eloquent\Model;
use App\ScoreCard\ScoreProject;
use App\ScoreCard\DataToScore;

/**
 * Description of CameraScore
 *
 * @author Sucre.xu
 */
class Score extends Model
{

    protected $project;

    public function setProject(ScoreProject $project)
    {
        $this->project = $project;
        $this->table = $project->score_save_to;
        $this->fillable(explode(",",$project->score_fillable));
        $this->project_id=$project->id;
        return $this;
    }
    public function setData($id){
        $this->data_id=$id;
        return $this;
    }
    public function setFillable($fillable){
        $this->fillable($fillable);
        return $this;
    }
    
    public function data(ScoreProject $project){
        //return $this->belongsTo("App\ScoreCard\DataToScore");
        $data=new DataToScore();
        return $data->setProject($project)->find($this->data_id);        
    }
}
