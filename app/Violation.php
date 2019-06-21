<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Description of Violation
 * Violations build from valid issues by Summer
 *
 * @author Sucre.xu
 */
class Violation extends Model
{

    use SoftDeletes;

    public function issue()
    {
        return $this->belongsTo('App\Issue');
    }

}
