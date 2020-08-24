<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of TrainingTestResult
 *
 * @author Sucre.xu
 */
class TrainingTestResult extends Model
{
    //put your code here
    protected $fillable=['employee_id',
        'training_date','training_type',
        'name_cn',
        'region',
        'business_score',
        'much_score','vrd_score','phone_score','general_score','oral_score','coc_score','updated_by'];
}
