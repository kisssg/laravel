<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of FcCameraScores
 *
 * @author Sucre.xu
 */
class FcCameraScore extends Model
{

    //put your code here

    //protected $table = 'fc_camera_scores';

    public function collector()
    {
        return $this->belongsTo('App\Collector', 'id_employee', 'employee_id');
    }

}
