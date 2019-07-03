<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ExcelHandle;

/**
 * Description of Issues
 *
 * @author Sucre.xu
 */
class Issue extends Model
{

    use SoftDeletes;
    use ExcelHandle;

    protected $table = 'fc_issue';
    protected $fillable = [
        'date',
        'contract_no',
        'client_name',
        'phone',
        'object',
        'city',
        'region',
        'collector',
        'employeeID',
        'issue_type',
        'issue',
        'remark',
        'responsible_person',
        'feedback',
        'qc_name',
        'result',
        'close_reason',
        'callback_id',
        'add_time',
        'feedback_person',
        'close_person',
        'close_time',
        'edit_log',
        'source',
        'harassment_type',
        'uploader',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hasManyViolations()
    {
        return $this->hasMany('App\Violation', 'issue_id', 'id');
    }

}
