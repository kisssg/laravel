<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Collector extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'fc_employees';
    //mass assignment
    protected $fillable = ['name_cn', 'area', 'city', 'position', 'name_en', 'employee_id',
        'onboard_date', 'email', 'province', 'city_cn', 'tl', 'sv', 'manager', 'type', 'status',
        'phone_number', 'cfc_hm_id', 'gc_hm_id', 'person_id', 'district', 'last_date', 'action_type', 'action_reason',];

    public function issues()
    {
        return $this->hasMany('App\Issue', 'employeeid', 'employee_id');
    }

    public function violations()
    {
        return $this->hasMany('App\Violation');
    }

    public function fcCameraScores()
    {
        return $this->hasMany('App\FcCameraScore');
    }

    public function fcCameraScoresCount()
    {
        return $this->hasOne('App\FcCameraScore', 'id_employee', 'employee_id')
                        ->selectRaw('id_employee, count(*) as aggregate')
                        ->groupBy('id_employee');
    }

    public function getFcCameraScoresCountAttribute()
    {
        if (!array_key_exists('fcCameraScoresCount', $this->relations))
        {
            $this->load('fcCameraScoresCount');
        }
        $related = $this->getRelation('fcCameraScoresCount');
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function issuesCount()
    {
        return $this->hasOne('App\Issue', 'employeeid', 'employee_id')
                        ->selectRaw('employeeid, count(*) as aggregate')
                        ->groupBy('employeeid');
    }

    public function getIssuesCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (!array_key_exists('issuesCount', $this->relations))
        {
            $this->load('issuesCount');
        }

        $related = $this->getRelation('issuesCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function violationsCount()
    {
        return $this->hasOne('App\Violation', 'employee_id', 'employee_id')
                        ->selectRaw('employee_id,count(*) as aggregate')
                        ->groupBy('employee_id');
    }

    public function getViolationsCountAttribute()
    {
        if (!array_key_exists('violationsCount', $this->relations))
        {
            $this->load('violationsCount');
        }
        $related = $this->getRelation('violationsCount');
        return ($related) ? (int) $related->aggregate : 0;
    }

    public static function boot()
    {
        static::deleting(function($collector) {
            $collector->edit_log = 'deleted by '.Auth::user()->name;
            $collector->save();
        });
        parent::boot();
    }

}
