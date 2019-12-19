<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\ScoreCard;

use Illuminate\Database\Eloquent\Model;
use App\ScoreCard\ScoreProject;
use App\ScoreCard\Score;

/**
 * Description of Camera
 *
 * @author Sucre.xu
 */
class DataToScore extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $project;

    public function setProject(ScoreProject $project)
    {
        $this->project = $project;
        $this->table = $project->data_to_score;
        $this->fillable(explode(",", $project->data_fillable));
        $this->project_id = $project->id;
        return $this;
    }
    
    public function score(ScoreProject $project,$data_id)
    {
        $score=new Score();
        $result= $score->setProject($project)->where("data_id",$data_id)->first();
        return $result;
    }

}
