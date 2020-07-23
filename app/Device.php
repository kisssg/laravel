<?php

/**
 * Payment
 * payment of late collection collectors
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Description of Device
 *
 * @author Sucre.xu
 */
class Device extends Model {

    use SoftDeletes;

    protected $fillable = [
        'device','status','employee_id','name','remark',
        'updated_by'
    ];

    public static function boot() {
        static::deleting(function($payment) {
            $payment->deleted_by = Auth::user()->name;
            $payment->save();
        });
        parent::boot();
    }

}
