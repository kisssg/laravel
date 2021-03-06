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
        'issue_detail',
        'remark',
        'responsible_person',
        'feedback',
        'qc_name',
        'result',
        'close_reason',
        'callback_id',
        'add_time',
        'feedback_person',
        'feedback_time',
        'close_person',
        'close_time',
        'edit_log',
        'source',
        'harassment_type',
        'uploader',
    ];

    public function collector()
    {
        return $this->belongsTo('App\Collector', 'employeeID', 'employee_id');
    }

    public function violation()
    {
        return $this->hasOne('App\Violation', 'issue_id', 'id');
    }
    public static function boot()
    {
        static::deleting(function($issue) {
            $issue->edit_log = 'deleted by '.Auth::user()->name;
            $issue->result='失误添加';
            $issue->save();
        });
        parent::boot();
    }

}
