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
 * Description of Issues
 *
 * @author Sucre.xu
 */
class Issue extends Model
{

    use SoftDeletes;

    protected $table = 'fc_issue';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hasManyViolations()
    {
        return $this->hasMany('App\Violation', 'issue_id', 'id');
    }
}
