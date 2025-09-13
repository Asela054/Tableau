<?php

namespace App\Http\Controllers;

use App\AbsentDeductionapproved;
use App\EmployeeTermPayment;
use App\Helpers\EmployeeHelper;
use App\Holidaydiductionapproved;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbsentdeductionApproveController extends Controller
{
     public function index()
     {
        $user = auth()->user();
        $permission = $user->can('Absent-Deduction-Approve-list');

        if(!$permission) {
            abort(403);
        }

        $remunerations=DB::table('remunerations')->select('*')->where('allocation_method', 'TERMS')->get();
        return view('Leave.absent_deduction_approve', compact('remunerations'));
    }

        public function absentdeduction(Request $request)
    {

        $permission = \Auth::user()->can('Absent-Deduction-Approve-list');
        if (!$permission) {
            abort(403);
        }

        $location=$request->input('location');
        $selectedmonth=$request->input('selectedmonth');
        $remunerationtype=$request->input('remunerationtype');

        if ($selectedmonth) {
            $firstDate = Carbon::createFromFormat('Y-m', $selectedmonth)->startOfMonth()->toDateString();
            $lastDate = Carbon::createFromFormat('Y-m', $selectedmonth)->endOfMonth()->toDateString();
        }else{
            $firstDate =  $request->input('from_date');
            $lastDate = $request->input('to_date');
        }
        

        $datareturn = [];

        $query = DB::table('employees')
        ->leftjoin('payroll_profiles', 'employees.id', '=', 'payroll_profiles.emp_id')
        ->select(
            'employees.emp_id as empid',
            'employees.emp_name_with_initial as emp_name',
            'employees.calling_name',
            'payroll_profiles.basic_salary as basicsalary',
            'payroll_profiles.day_salary as daysalary',
            'payroll_profiles.id as payroll_profiles_id')
        ->where('employees.emp_location', '=', $location)
        // ->where('employees.emp_department', '=',)
        ->where('payroll_profiles.payroll_process_type_id', '=',1)
        ->where('employees.deleted', '=',0)
        ->where('employees.is_resigned', '=',0)
        ->orderBy('employees.id')
        ->get();

        foreach ($query as $row) {

                $empId = $row->empid;
                $payrollProfileId = $row->payroll_profiles_id;
                $daysalary = $row->daysalary;
                

                $employeeObj = (object)[
                    'emp_id' => $row->empid,
                    'emp_name_with_initial' => $row->emp_name,
                    'calling_name' => $row->calling_name
                ];
                
                $absentdays = 0;
                $workdays = 0;
                $deductionamount = 0;

                 $emp = DB::table('employees')
                ->leftJoin('job_categories', 'job_categories.id' , '=', 'employees.job_category_id')
                ->select('job_categories.id as job_categoryid','job_categories.emp_payroll_workdays as workingdays')
                ->where('employees.emp_id', $empId)
                ->first();

                if ($emp) {
                    $jobCategoryId = $emp->job_categoryid;
                    $payrollworkingdays = $emp->workingdays;
                    $workday = (new \App\AbsentDeductionapproved)->get_work_days($empId, $firstDate, $lastDate);

                    $absentdays = $payrollworkingdays - $workday;
                     
                     // Calculate attendance percentage
                    $attendancePercentage = ($workday / $payrollworkingdays) * 100;

                    // Apply deduction rules based on attendance percentage and absent days
                    if ($attendancePercentage < 85) {
                        $daysBelowThreshold = $payrollworkingdays - $workday;
                        
                        if ($daysBelowThreshold == 1) {
                            $deductionamount = $daysalary * 0.5; // 1/2 day salary
                        } elseif ($daysBelowThreshold == 2) {
                            $deductionamount = $daysalary * 1; // 1 day salary
                        } elseif ($daysBelowThreshold == 3) {
                            $deductionamount = $daysalary * 1.5; // 1 1/2 day salary
                        } elseif ($daysBelowThreshold >= 4) {
                            $deductionamount = $daysalary * 2; // 2 day salary
                        }
                    }


                //check holiday deductions approved on given date range
                $approveholidayductions = DB::table('holiday_deductions_approved')
                ->where('emp_id', $empId)
                ->where('remuneration_id', $remunerationtype)
                ->whereBetween('from_date', [$firstDate, $lastDate]) 
                ->whereBetween('to_date', [$firstDate, $lastDate])  
                ->first();
                $approveholidayductionsstatus = $approveholidayductions ? 1 : 0;
                
                $datareturn[] = [
                    'deductionsstatus' => $approveholidayductionsstatus,
                    'empid' => $empId,
                    'emp_name' => EmployeeHelper::getDisplayName($employeeObj),
                    'payroll_Profile' => $payrollProfileId,
                    'absent_Days' => $absentdays,
                    'remuneration_id' => $remunerationtype,
                    'attendance_percentage' => number_format($attendancePercentage, 2) . '%',
                    'deduction_amount' => number_format($deductionamount, 2) 
                ];  

                }else{
                    continue;
                }
        }
        return response()->json([ 'data' => $datareturn ]);
    }

    public function approveldeduction(Request $request)
    {
        $permission = \Auth::user()->can('Absent-Deduction-Approve-Create');
        if (!$permission) {
            abort(403);
        }

        $dataarry = $request->input('dataarry');
        $selectedmonth = $request->input('selectedmonth');

        $current_date_time = Carbon::now()->toDateTimeString();

        if ($selectedmonth) {
            $firstDate = Carbon::createFromFormat('Y-m', $selectedmonth)->startOfMonth()->toDateString();
            $lastDate = Carbon::createFromFormat('Y-m', $selectedmonth)->endOfMonth()->toDateString();
        }else{
            $firstDate =  $request->input('from_date');
            $lastDate = $request->input('to_date');
        }

        foreach ($dataarry as $row) {

            $empid = $row['empid'];
            $epfno = $row['emp_name'];
            $Absent_Days = $row['Absent_Days'];
            $attendance_percentage = $row['attendance_percentage'];
            $deduction_amount = $row['deduction_amount'];
            $deduction_amount = str_replace([','], '', $deduction_amount);
            $payrollProfile = $row['payroll_Profile'];
            $remunerationid = $row['remuneration_id'];


            if( $deduction_amount != 0){

                $allowance = DB::table('absent_deduction_approve')
                ->where('emp_id', $empid)
                ->where('remuneration_id', $remunerationid)
                ->whereBetween('from_date', [$firstDate, $lastDate]) 
                ->whereBetween('to_date', [$firstDate, $lastDate])  
                ->first();
    
                if($allowance){
                    DB::table('absent_deduction_approve')
                    ->where('emp_id', $empid)
                    ->where('from_date', [$firstDate, $lastDate])
                    ->where('to_date',[$firstDate, $lastDate])
                    ->update([
                        'total_absent_days' => $Absent_Days,
                        'attendance_precentage' => $attendance_percentage,
                        'deduction_amount' => $deduction_amount,
                        'remuneration_id' => $remunerationid,
                        'updated_at' => $current_date_time
                    ]);

                    $paysliplast = DB::table('employee_payslips')
                    ->select('emp_payslip_no')
                    ->where('payroll_profile_id', $payrollProfile)
                    ->where('payslip_cancel', 0)
                    ->orderBy('id', 'desc')
                    ->first();

                    if ($paysliplast) {
                        $emp_payslipno = $paysliplast->emp_payslip_no;
                        $newpaylispno =  $emp_payslipno +1;
                    }else{
                        $newpaylispno = 1;
                    }
                    
                    $termpaymentcheck = DB::table('employee_term_payments')
                    ->select('id')
                    ->where('payroll_profile_id', $payrollProfile)
                    ->where('emp_payslip_no', $newpaylispno)
                    ->where('remuneration_id', $remunerationid)
                    ->first();
                    
                    DB::table('employee_term_payments')
                    ->where('id', $termpaymentcheck->id)
                    ->update([
                        'payment_amount' => $deduction_amount,
                        'payment_cancel' => '0',
                        'updated_by' => Auth::id(),
                        'updated_at' => $current_date_time
                    ]);
                }else{
                    $absentdeduction = new AbsentDeductionapproved();
                    $absentdeduction->emp_id = $empid;
                    $absentdeduction->from_date = $firstDate;
                    $absentdeduction->to_date = $lastDate;
                    $absentdeduction->total_absent_days = $Absent_Days;
                    $absentdeduction->attendance_precentage = $attendance_percentage;
                    $absentdeduction->deduction_amount = $deduction_amount;
                    $absentdeduction->remuneration_id = $remunerationid;
                    $absentdeduction->created_at = $current_date_time;
                    $absentdeduction->save();

                    $paysliplast = DB::table('employee_payslips')
                    ->select('emp_payslip_no')
                    ->where('payroll_profile_id', $payrollProfile)
                    ->where('payslip_cancel', 0)
                    ->orderBy('id', 'desc')
                    ->first();

                    if ($paysliplast) {
                        $emp_payslipno = $paysliplast->emp_payslip_no;
                        $newpaylispno =  $emp_payslipno +1;
                    }else{
                        $newpaylispno = 1;
                    }
                   
                    $termpaymentcheck = DB::table('employee_term_payments')
                    ->select('id')
                    ->where('payroll_profile_id', $payrollProfile)
                    ->where('emp_payslip_no', $newpaylispno)
                    ->where('remuneration_id', $remunerationid)
                    ->first();
                    
                    if($termpaymentcheck){
                        DB::table('employee_term_payments')
                        ->where('id', $termpaymentcheck->id)
                        ->update([
                            'payment_amount' => $deduction_amount,
                            'payment_cancel' => '0',
                            'updated_by' => Auth::id(),
                            'updated_at' => $current_date_time
                        ]);
                    }
                    else{
                        $termpayment = new EmployeeTermPayment();
                        $termpayment->remuneration_id = $remunerationid;
                        $termpayment->payroll_profile_id = $payrollProfile;
                        $termpayment->emp_payslip_no = $newpaylispno;
                        $termpayment->payment_amount = $deduction_amount;
                        $termpayment->payment_cancel = 0;
                        $termpayment->created_by = Auth::id();
                        $termpayment->created_at = $current_date_time;
                        $termpayment->save(); 
                    }
                }
            }
        }
        return response()->json(['success' => 'Absent Deduction is successfully Approved']);
    }



}
