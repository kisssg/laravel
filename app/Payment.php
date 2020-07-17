<?php

/**
 * Payment
 * payment of late collection collectors
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Description of Issues
 *
 * @author Sucre.xu
 */
class Payment extends Model {

    use SoftDeletes;

    protected $fillable = [
        'NAME_COLLECTOR',
        'COUNT_CONTRACT',
        'PAYMENT',
        'ASSIGN_AMT',
        'RecoveryRate',
        'employee_id',
        'year',
        'month',
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
