<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shiftextenddetail extends Model
{
    protected $table = 'shift_extenddetails';
    protected $primarykey = 'id';

    protected $fillable =[

        'shift_extend_id','emp_id','date','status','created_by', 'updated_by','created_at','updated_at'
    ];
}
