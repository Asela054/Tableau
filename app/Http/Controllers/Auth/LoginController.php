<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // /**
    //  * Where to redirect users after login.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = '/home';
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $employeeData = DB::table('users')
            ->join('employees', 'users.emp_id', '=', 'employees.emp_id')
            ->where('users.id', $user->id)
            ->select('users.id', 'employees.emp_id', 'employees.emp_etfno', 
                    'employees.emp_name_with_initial', 'employees.emp_location', 
                    'employees.calling_name', 'employees.emp_department', 
                    'employees.emp_company')
            ->first();

        if ($employeeData) {
            // Session::put([
            //     'users_id' => $employeeData->id,
            //     'emp_id' => $employeeData->emp_id,
            //     'emp_etfno' => $employeeData->emp_etfno,
            //     'emp_name_with_initial' => $employeeData->emp_name_with_initial,
            //     'emp_location' => $employeeData->emp_location,
            //     'emp_department' => $employeeData->emp_department,
            //     'emp_company' => $employeeData->emp_company,
            // ]);        

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['users_id'] = $employeeData->id;
            $_SESSION['emp_id'] = $employeeData->emp_id;
            $_SESSION['emp_etfno'] = $employeeData->emp_etfno;
            $_SESSION['emp_name_with_initial'] = $employeeData->emp_name_with_initial;
            $_SESSION['emp_location'] = $employeeData->emp_location;
            $_SESSION['emp_department'] = $employeeData->emp_department;
            $_SESSION['emp_company'] = $employeeData->emp_company;
        }
        
        if ($user->hasRole('Employee')) {
            return redirect('/useraccountsummery');
        }
        
        return redirect('/home');
    }

    // protected function redirectTo()
    // {
    //     return Auth::user()->hasRole('Employee') ? '/useraccountsummery' : '/home';
    // }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
