<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssueType extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;

    //mass assignment
    protected $table='issues';
    protected $fillable = [];

}
