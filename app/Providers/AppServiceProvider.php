<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
             \URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $employeeData = null;
    
            if (Auth::check()) {
                $employeeData = DB::table('users')
                    ->join('employees', 'users.emp_id', '=', 'employees.emp_id')
                    ->where('users.id', Auth::id())
                    ->select('users.id','employees.emp_id','employees.emp_etfno','employees.emp_name_with_initial', 'employees.emp_location', 'employees.calling_name','employees.emp_department','employees.emp_company')
                    ->first();
                   
            }
    
            // Share with all views
            if($employeeData){
                $view->with('users_id', $employeeData->id ?? null);
                $view->with('emp_id', $employeeData->emp_id ?? null);
                $view->with('emp_etfno', $employeeData->emp_etfno ?? null);
                $view->with('emp_name_with_initial', $employeeData->emp_name_with_initial ?? null);
                $view->with('emp_location', $employeeData->emp_location ?? null);
                $view->with('calling_name', $employeeData->calling_name ?? null);
                $view->with('emp_company', $employeeData->emp_company ?? null);
    
                
                
                Session::put('users_id', $employeeData->id);
                Session::put('emp_id', $employeeData->emp_id);
                Session::put('emp_etfno', $employeeData->emp_etfno);
                Session::put('emp_name_with_initial', $employeeData->emp_name_with_initial);
                Session::put('emp_location', $employeeData->emp_location);
                Session::put('emp_department', $employeeData->emp_department);
                Session::put('emp_company', $employeeData->emp_company);
            }
            
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
