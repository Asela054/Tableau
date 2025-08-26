<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationVisitallowances extends Model
{
     protected $table = 'location _visit_allowances';

    protected $primarykey = 'id';

    protected $fillable =[
        'employee_id','from_date','to_date','visit_count','amount'
    ];
}
