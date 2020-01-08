<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\ScoreCard;

use Illuminate\Database\Eloquent\Model;
use App\ScoreCard\ScoreProject;

/**
 * Description of CameraScore
 *
 * @author Sucre.xu
 */
class Audit extends Model
{

    protected $project;

    public function setProject(ScoreProject $project)
    {
        $this->project = $project;
        $this->table = $project->audit_save_to;
        $this->fillable(explode(",",$project->audit_fillable));
        $this->project_id=$project->id;
        return $this;
    }
}
