<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AbsentDeductionapproved extends Model
{
     protected $table = 'absent_deduction_approve';
      protected $primaryKey = 'id';

    protected $fillable = [
        'emp_id',
        'from_date',
        'to_date',
        'total_absent_days',
        'attendance_precentage',
        'deduction_amount',
        'remuneration_id'
    ];

      public function get_work_days($emp_id, $firstDate, $lastDate)
    {
        $query = "SELECT Max(at1.timestamp) as lasttimestamp,
        Min(at1.timestamp) as firsttimestamp
        FROM attendances as at1
        WHERE at1.emp_id = $emp_id
        AND at1.date BETWEEN '$firstDate' AND '$lastDate'
        AND at1.deleted_at IS NULL
        group by at1.uid, at1.date
        ";
        $attendance = \DB::select($query);

        $work_days = 0;
        foreach ($attendance as $att) {

            $first_time = $att->firsttimestamp;
            $last_time = $att->lasttimestamp;

            $date = Carbon::parse($first_time);
            $s_date = $date->format('Y-m-d');
            $holiday_check = Holiday::where('date', $s_date)
                ->where('work_level', '=', '2')
                ->first();

            if(!EMPTY($holiday_check)){
                continue;
            }

            //get difference in hours
            $diff = round((strtotime($last_time) - strtotime($first_time)) / 3600, 1);

            //if diff is greater than 8 hours then it is a work day
            //if diff is greater than 4 hours then it is a half day
            //if diff is greater than 2 hours then it is a half day
            if ($diff >= 8) {
                $work_days++;
            } elseif ($diff >= 4) {
                $work_days += 0.5;
            } elseif ($diff >= 2){
                //$work_days += 0.25;
            }
        }
        return $work_days;
    }
}
