<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'fc_employees';
    //mass assignment
    protected $fillable = [ 'name_cn', 'area', 'city', 'position', 'name_en', 'employee_id',
        'onboard_date', 'email', 'province', 'city_cn', 'tl', 'sv', 'manager', 'type','status',
        'phone_number', 'cfc_hm_id', 'gc_hm_id', 'person_id', 'district',];

    public function hasManyIssues()
    {
        return $this->hasMany('App\Issue');
    }

    public function hasManyViolations()
    {
        return $this->hasMany('App\Violation');
    }

}
