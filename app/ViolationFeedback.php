<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Issues
 *
 * @author Sucre.xu
 */
class ViolationFeedback extends Model
{
    protected $table='violation_feedbacks';
    protected $fillable = ['name','email', 'token', 'to_fill_column', 'violation_id'];

}
