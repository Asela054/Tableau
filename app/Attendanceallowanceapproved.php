<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendanceallowanceapproved extends Model
{
       protected $table = 'attendance_allowance_approve';
      protected $primaryKey = 'id';

    protected $fillable = [
        'emp_id',
        'from_date',
        'to_date',
        'attendance_precentage',
        'deduction_amount',
        'remuneration_id'
    ];
}
