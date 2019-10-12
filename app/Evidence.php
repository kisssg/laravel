<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;

    //mass assignment
    protected $table='evidences';
    protected $fillable = [];

    public function violation()
    {
        return $this->hasMany('App\Violation');
    }

}
