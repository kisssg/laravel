<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of VisitRecord
 *
 * @author Sucre.xu
 */
class VisitRecord extends Model
{
    //put your code here
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table="journal_data";
    
}
