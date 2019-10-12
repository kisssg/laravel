<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Punishment extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    //mass assignment
    protected $fillable = ['letter_id','active_date', 'inactive_date', 'collector', 'name_cn',
        'on_board_date', 'employee_id', 'issue_found_by', 'bonus_reduction',
        'level_of_action', 'reduction_type','creator', 'status', 'violation_id',
    ];
    public function violation()
    {
        return $this->belongsTo('App\Violation');
    }
}
