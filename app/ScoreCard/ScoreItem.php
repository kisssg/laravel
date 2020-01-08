<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\ScoreCard;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of ScoreItem
 *
 * @author Sucre.xu
 */
class ScoreItem extends Model
{
    protected $fillable=['project_id','title','sub_title','score_field','order','option_type','options','scores'];
    public function project(){
        return $this->belongsTo('App\ScoreCard\ScoreProject','project_id');
    }
}
