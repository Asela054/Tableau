<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Leave extends Model
{
    protected $table = 'leaves';

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }

    public function covering_employee()
    {
        return $this->belongsTo(Employee::class, 'emp_covering', 'emp_id');
    }

    public function approve_by()
    {
        return $this->belongsTo(Employee::class, 'leave_approv_person', 'emp_id');
    }

      // Calculate taken annual leaves count
    public function taken_annual_leaves($emp_id,$from_date,$to_date)
    {

          $total_taken_annual_leaves = DB::table('leaves')
                ->where('leaves.emp_id', '=', $emp_id)
                ->whereBetween('leaves.leave_from', [$from_date, $to_date])
                ->where('leaves.leave_type', '=', '1')
                ->get()->toArray();

            $current_year_taken_a_l = 0;

            foreach ($total_taken_annual_leaves as $tta){
                $leave_from = $tta->leave_from;
                $leave_to = $tta->leave_to;

                $leave_from_year = Carbon::parse($leave_from)->year;
                $leave_to_year = Carbon::parse($leave_to)->year;

                if($leave_from_year != $leave_to_year){
                    //get current year leaves for that record
                    $lastDayOfMonth = Carbon::parse($leave_from)->endOfMonth()->toDateString();

                    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $lastDayOfMonth);
                    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $leave_from);

                    $diff_in_days = $to->diffInDays($from);
                    $current_year_taken_a_l += $diff_in_days;

                    $jan_data = DB::table('leaves')
                        ->where('leaves.id', '=', $tta->id)
                        ->first();

                    $firstDayOfMonth = Carbon::parse($jan_data->leave_to)->startOfMonth()->toDateString();
                    $to_t = \Carbon\Carbon::createFromFormat('Y-m-d', $jan_data->leave_to);
                    $from_t = \Carbon\Carbon::createFromFormat('Y-m-d', $firstDayOfMonth);

                    $diff_in_days_f = $to_t->diffInDays($from_t);
                    $current_year_taken_a_l += $diff_in_days_f;

                }else{
                    $current_year_taken_a_l += $tta->no_of_days;
                }
            }

             return $current_year_taken_a_l;

    }

     // Calculate taken casual leaves count
    public function taken_casual_leaves($emp_id,$from_date,$to_date)
    {
         $total_taken_casual_leaves = DB::table('leaves')
                ->where('leaves.emp_id', '=', $emp_id)
                ->whereBetween('leaves.leave_from', [$from_date, $to_date])
                ->where('leaves.leave_type', '=', '2')
                ->get()->toArray();

            $current_year_taken_c_l = 0;
            
            foreach ($total_taken_casual_leaves as $tta){
                $leave_from = $tta->leave_from;
                $leave_to = $tta->leave_to;

                $leave_from_year = Carbon::parse($leave_from)->year;
                $leave_to_year = Carbon::parse($leave_to)->year;

                if($leave_from_year != $leave_to_year){
                    //get current year leaves for that record
                    $lastDayOfMonth = Carbon::parse($leave_from)->endOfMonth()->toDateString();

                    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $lastDayOfMonth);
                    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $leave_from);

                    $diff_in_days = $to->diffInDays($from);
                    $current_year_taken_c_l += $diff_in_days;
                }else{
                    $current_year_taken_c_l += $tta->no_of_days;
                }
            }

             return $current_year_taken_c_l;

    }

     // Calculate taken medical leaves count
    public function taken_medical_leaves($emp_id,$from_date,$to_date)
    {
        $total_taken_med_leaves = DB::table('leaves')
                ->where('leaves.emp_id', '=', $emp_id)
                ->whereBetween('leaves.leave_from', [$from_date, $to_date])
                ->where('leaves.leave_type', '=', '4')
                ->get()->toArray();

            $current_year_taken_med = 0;
            foreach ($total_taken_med_leaves as $tta){
                $leave_from = $tta->leave_from;
                $leave_to = $tta->leave_to;

                $leave_from_year = Carbon::parse($leave_from)->year;
                $leave_to_year = Carbon::parse($leave_to)->year;

                if($leave_from_year != $leave_to_year){
                    //get current year leaves for that record
                    $lastDayOfMonth = Carbon::parse($leave_from)->endOfMonth()->toDateString();

                    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $lastDayOfMonth);
                    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $leave_from);

                    $diff_in_days = $to->diffInDays($from);
                    $current_year_taken_med += $diff_in_days;
                }else{
                    $current_year_taken_med += $tta->no_of_days;
                }
            }

            return $current_year_taken_med;
    }
}
