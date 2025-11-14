<?php

namespace App\Http\Controllers;

use App\EmployeeTermPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MeterReadingApproveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $permission = $user->can('meter-reading-Approve-list');
        if (!$permission) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }

        return view('Meter_Reading.meter_reading_approve');
    }

    public function generatemeterreading(Request $request){
        $user = Auth::user();
        $permission = $user->can('meter-reading-Approve-create');

        if(!$permission){
            return response()->json(['error' => 'UnAuthorized'], 401);
        }

        $company = $request->get('company');
        $department = $request->get('department');
        $employee = $request->get('employee');
        $from_date = $request->get('from_date');
        $to_date = $request->get('to_date');

        $query = DB::query()
            ->select('employees.id as emp_auto_id',
                'employees.emp_id',
                'employees.emp_name_with_initial',
                'employees.emp_join_date'               
            )
            ->from('employees as employees');
        
        if ($employee != '') {
            $query->where(['employees.emp_id' => $employee]);
        }
        if ($company != '') {
            $query->where(['employees.emp_company' => $company]);
        }
        if ($department != '') {
            $query->where(['employees.emp_department' => $department]);
        }
        
        $query->where('employees.deleted', 0);
        $query->where('employees.is_resigned',0);
        $query->groupBy('employees.emp_id');
        $results = $query->get();

        $data = [];

        foreach ($results as $record) {
            $readingQuery = DB::table('meter_reading_count')
                ->where('emp_id', $record->emp_id)
                ->whereBetween('date', [$from_date, $to_date]);
        
            $readingTotal = $readingQuery->sum('count');

            if ($readingTotal == 0 ) {
                continue;
            }

            $data[] = [
                'emp_auto_id' => $record->emp_auto_id,
                'emp_id' => $record->emp_id,
                'emp_name_with_initial' => $record->emp_name_with_initial,
                'count' => $readingTotal, 
                'overall_total' => $readingTotal * 25
            ];
        }

        return response()->json(['data' => $data]);
    }


      public function approvemeterreading(Request $request)
    {

        $permission = \Auth::user()->can('meter-reading-Approve-create');
        if (!$permission) {
            abort(403);
        }

        $dataarry = $request->input('dataarry');

        
        $current_date_time = Carbon::now()->toDateTimeString();

        foreach ($dataarry as $row) {

            $empid = $row['empid'];
            $empname = $row['emp_name'];
            $reading_total = $row['count'];
            $overall_total = $row['overall_total'];
            $autoid = $row['emp_auto_id'];

            $profiles = DB::table('payroll_profiles')
            ->join('payroll_process_types', 'payroll_profiles.payroll_process_type_id', '=', 'payroll_process_types.id')
            ->where('payroll_profiles.emp_id', $autoid)
            ->select('payroll_profiles.id as payroll_profile_id')
            ->first();

        if ($profiles) {

            $remunerationid = 34;

            $paysliplast = DB::table('employee_payslips')
                ->select('emp_payslip_no')
                ->where('payroll_profile_id', $profiles->payroll_profile_id)
                ->where('payslip_cancel', 0)
                ->orderBy('id', 'desc')
                ->first();

            if ($paysliplast) {
                $emp_payslipno = $paysliplast->emp_payslip_no;
                $newpaylispno =  $emp_payslipno +1;
            }else{
                $newpaylispno = 1;
            }


        
            if($overall_total != 0){

                $termpaymentcheck = DB::table('employee_term_payments')
                ->select('id')
                ->where('payroll_profile_id', $profiles->payroll_profile_id)
                ->where('emp_payslip_no', $newpaylispno)
                ->where('remuneration_id', $remunerationid)
                ->first();
            
                if($termpaymentcheck){
                    DB::table('employee_term_payments')
                    ->where('id', $termpaymentcheck->id)
                    ->update([
                        'payment_amount' => $overall_total,
                        'payment_cancel' => '0',
                        'updated_by' => Auth::id(),
                        'updated_at' => $current_date_time
                    ]);
                }
                else{
                    $termpayment = new EmployeeTermPayment();
                    $termpayment->remuneration_id = $remunerationid;
                    $termpayment->payroll_profile_id = $profiles->payroll_profile_id;
                    $termpayment->emp_payslip_no = $newpaylispno;
                    $termpayment->payment_amount = $overall_total;
                    $termpayment->payment_cancel = 0;
                    $termpayment->created_by = Auth::id();
                    $termpayment->created_at = $current_date_time;
                    $termpayment->save(); 
                }
            }

            
        }
        else{
            continue;
        }

        }

        return response()->json(['success' => 'Meter Reading is successfully Approved']);
    }


}
