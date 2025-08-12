<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shiftextend extends Model
{
    protected $table = 'shift_extend';
    protected $primarykey = 'id';

    protected $fillable =[

        'date','status','created_by', 'updated_by','created_at','updated_at'
    ];
}
