<?php

namespace App\Http\Controllers;

use App\Helpers\EmployeeHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Datatables;
use DB;

class EmployeeResignController extends Controller
{
    public function employee_resign_report()
    {
        $permission = Auth::user()->can('employee-resign-report');
        if (!$permission) {
            abort(403);
        }

        $departments=DB::table('departments')->select('*')->get();
        return view('Report.employee_resign_report',compact('departments'));
    }

    
    public function get_resign_employees(Request $request)
{
    $department = $request->input('department');
    $from_date = $request->input('from_date');
    $to_date = $request->input('to_date');

    $types = DB::table('employees')
        ->leftJoin('departments', 'departments.id', '=', 'employees.emp_department')
        ->leftJoin('job_titles', 'employees.emp_job_code', '=', 'job_titles.id')
        ->leftJoin('branches', 'employees.emp_location', '=', 'branches.id')
        ->select(
            'employees.*',
            'departments.name AS department_name',
            'job_titles.title AS title',
            'branches.location AS location'
        )
        ->where('employees.deleted', '0')
        ->where('employees.is_resigned', 1);

    if ($department != 'All') {
        $types->where('employees.emp_department', $department);
    }

    if (!empty($from_date) && !empty($to_date)) {
        $types->whereBetween('employees.resignation_date', [$from_date, $to_date]);
    }

    $types = $types->get();

    return Datatables::of($types)
        ->addIndexColumn()
         ->addColumn('employee_display', function ($row) {
                   return EmployeeHelper::getDisplayName($row);
                   
        })
        ->filterColumn('employee_display', function($query, $keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('employees.emp_name_with_initial', 'like', "%{$keyword}%")
                ->orWhere('employees.calling_name', 'like', "%{$keyword}%")
                ->orWhere('employees.emp_id', 'like', "%{$keyword}%");
            });
        })
        ->addColumn('action', function ($row) {
        })
        ->rawColumns(['action'])
        ->make(true);
}

}
