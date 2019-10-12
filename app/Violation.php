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

    protected $fillable = ['channel',
        'issue_id',
        'contract_no',
        'issue_type',
        'issue',
        'remark',
        'cash_collect_amt',
        'city_en',
        'region',
        'name_lli',
        'employee_id',
        'name_tl',
        'name_sv',
        'lcs',
        'month_violation',
        'date_violation',
        'month_propose_action',
        'date_propose_action',
        'month_decided_action',
        'date_decided_action',
        'month_executed_disciplinary',
        'date_executed_disciplinary',
        'month_verify_disciplinary',
        'date_verify_disciplinary',
        'who_detected',
        'who_proposed_disciplinary',
        'who_decide_disciplinary',
        'who_execute_disciplinary',
        'who_verify_disciplinary',
        'source',
        'harassment_type',
        'punishment_proposed',
        'punishment_decided',
        'comment',
        'month_belong',
        "punishment_evidence",
        "bonus_reduction",
        "action_level",
        "evidence_id"
    ];

    public function issue()
    {
        return $this->belongsTo('App\Issue');
    }

    /**
     * 
     * @return type
     */
    public function evidence()
    {
        return $this->belongsTo('App\Evidence');
    }

}
