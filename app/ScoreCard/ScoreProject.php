<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\ScoreCard;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of ScoreProject
 *
 * @author Sucre.xu
 */
class ScoreProject extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $fillable=['name', 'description', 'data_to_score', 'score_save_to','audit_save_to','data_fillable',
        'audit_fillable','score_fillable','data_list_columns','data_list_column_alias','data_to_score_columns',
        'order_by_columns','date_field','contract_no_field','search_columns','minutes_allow_edit_in',
        'uncheck_ceiling','batchpick_depends_on','allow_single_pick','score_method'];
    public function items(){
        return $this->hasMany('App\ScoreCard\ScoreItem','project_id')->orderBy('order');
    }
}
