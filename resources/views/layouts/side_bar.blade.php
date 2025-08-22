<div class="sidebar open">
    <ul class="nav-list">
        <li>
            <a href="{{ url('/home') }}" id="dashboard_link">
                <i id="dashboard_link_icon" class="flaticon-381-background-1"></i>
                <span class="links_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>

        @php
            $user = auth()->user();
            $hasOrganizationPermissions = $user->can('location-list') || 
                                        $user->can('company-list') || 
                                        $user->can('bank-list') || 
                                        $user->can('work-category-list') || 
                                        $user->can('month-work-hours-list');
            
            $hasEmployeeManagementPermissions = $user->can('job-title-list') ||
                                            $user->can('pay-grade-list') ||
                                            $user->can('job-category-list') ||
                                            $user->can('job-employment-status-list') ||
                                            $user->can('skill-list') ||
                                            $user->can('employee-list') ||
                                            $user->can('employee-select') ||
                                            $user->can('pe-task-list') ||
                                            $user->can('allowance-amount-list');
            
            $hasAttendanceLeavePermissions = $user->can('attendance-sync') ||
                                            $user->can('attendance-incomplete-data-list') ||
                                            $user->can('attendance-list') ||
                                            $user->can('attendance-create') ||
                                            $user->can('attendance-edit') ||
                                            $user->can('attendance-delete') ||
                                            $user->can('attendance-approve') ||
                                            $user->can('late-attendance-create') ||
                                            $user->can('late-attendance-approve') ||
                                            $user->can('late-attendance-list') ||
                                            $user->can('ot-approve') ||
                                            $user->can('ot-list') ||
                                            $user->can('finger-print-device-list') ||
                                            $user->can('finger-print-user-list') ||
                                            $user->can('attendance-device-clear') ||
                                            $user->can('leave-list') ||
                                            $user->can('leave-type-list') ||
                                            $user->can('leave-approve') ||
                                            $user->can('holiday-list');
            
            $hasShiftManagementPermissions = $user->can('shift-list') ||
                                            $user->can('work-shift-list') ||
                                            $user->can('additional-shift-list');
            
            $hasReportPermissions = $user->can('employee-report') ||
                                    $user->can('attendance-report') ||
                                    $user->can('late-attendance-report') ||
                                    $user->can('leave-report') ||
                                    $user->can('employee-bank-report') ||
                                    $user->can('leave-balance-report') ||
                                    $user->can('ot-report') ||
                                    $user->can('no-pay-report');
            
            $hasPayrollPermissions = $user->can('Facilities-list') ||
                                    $user->can('Payrollprofile-list') ||
                                    $user->can('Loans-list') ||
                                    $user->can('Loans-Settlement-list') ||
                                    $user->can('Salaryaddition-list') ||
                                    $user->can('Other-facilities-list') ||
                                    $user->can('Salary-increment-list') ||
                                    $user->can('Work-summary-list') ||
                                    $user->can('Salary-preperation-list') ||
                                    $user->can('Salary-schedule-list') ||
                                    $user->can('Paysliplist-list') ||
                                    $user->can('Pay-Register-Report') ||
                                    $user->can('OT-Report') ||
                                    $user->can('EPF-ETF-Report') ||
                                    $user->can('Salary-Sheet-report') ||
                                    $user->can('Salary-sheet-bankslip-report') ||
                                    $user->can('Salary-sheet-heldpayment-report') ||
                                    $user->can('Sixmonths-report') ||
                                    $user->can('Addition-report') ||
                                    $user->can('Employee-Salary-Payment-Statement') ||
                                    $user->can('Employee-Incentive-Statement') ||
                                    $user->can('Bank-Advice-Statement') ||
                                    $user->can('Pay-Summary-Statement') ||
                                    $user->can('Employee-Salary-Journal-Statement') ||
                                    $user->can('EPF-ETF-Journal-Statement');
            
            $hasUserAccountSummaryPermission = $user->can('user-account-summery-list');
            
            $hasAdministratorPermissions = $user->can('user-list') || $user->can('role-list');

            $hasKPIPermissions = $user->can('Functional-list') ||
                            $user->can('Behavioral-list');

            $hasproductionPermissions = $user->can('machine-list') || 
                        $user->can('product-list')|| 
                        $user->can('product-allocation-list')|| 
                        $user->can('production-ending-list')|| 
                        $user->can('task-list')|| 
                        $user->can('task-allocation-list')|| 
                        $user->can('task-ending-list')||
                        $user->can('Production-Task-Approve-list');
        @endphp

        @if($hasOrganizationPermissions)
        <li>
            <a href="{{ url('/corporatedashboard') }}" id="organization_menu_link">
                <i id="organization_menu_link_icon" class="flaticon-381-folder-9"></i>
                <span class="links_name">Organization</span>
            </a>
            <span class="tooltip">Organization</span>
        </li>
        @endif

        @if($hasEmployeeManagementPermissions)
        <li>
            <a href="{{ url('/employeemanagementdashboard') }}" id="employee_menu_link">
                <i id="employee_menu_link_icon" class="flaticon-381-user-8"></i>
                <span class="links_name">Employee Management</span>
            </a>
            <span class="tooltip">Employee Management</span>
        </li>
        @endif

        @if($hasAttendanceLeavePermissions)
        <li>
            <a href="{{ url('/attendenceleavedashboard') }}" id="attendant_menu_link">
                <i id="attendant_menu_link_icon" class="flaticon-381-id-card"></i>
                <span class="links_name">Attendance & Leave</span>
            </a>
            <span class="tooltip">Attendance & Leave</span>
        </li>
        @endif

        @if($hasShiftManagementPermissions)
        <li>
            <a href="{{ url('/shiftmanagementdashboard') }}" id="shift_menu_link">
                <i id="shift_menu_link_icon" class="flaticon-381-target"></i>
                <span class="links_name">Shift Management</span>
            </a>
            <span class="tooltip">Shift Management</span>
        </li>
        @endif

        @if($hasReportPermissions)
        <li>
            <a href="{{ url('/reportdashboard') }}" id="report_menu_link">
                <i id="report_menu_link_icon" class="flaticon-381-file-2"></i>
                <span class="links_name">Reports</span>
            </a>
            <span class="tooltip">Reports</span>
        </li>
        @endif

        @if($hasPayrollPermissions)
        <li>
            <a href="{{ url('/payrolldashboard') }}" id="payrollmenu">
                <i class="flaticon-381-user-8" id="payrollmenu_icon"></i>
                <span class="links_name">Payroll</span>
            </a>
            <span class="tooltip">Payroll</span>
        </li>
        @endif

        @if($hasKPIPermissions)
        <li>
          <a href="{{ url('/functionalmanagementdashboard') }}" id="functional_menu_link">
            <i id="functional_menu_link_icon" class="flaticon-381-user-1"></i>
            <span class="links_name">KPI Management</span>
          </a>
          <span class="tooltip">KPI Management</span>
        </li>
        @endif

         @if($hasproductionPermissions)
        <li>
          <a href="{{ url('/productiontaskdashboard') }}" id="production_menu_link">
            <i id="production_menu_link_icon" class="flaticon-381-background-1"></i>
            <span class="links_name">Production & Task</span>
          </a>
          <span class="tooltip">Production & Task</span>
        </li>
        @endif




        @if($hasUserAccountSummaryPermission)
        <li>
            <a href="{{ url('/useraccountsummery') }}" id="user_information_menu_link">
                <i id="user_information_menu_link_icon" class="flaticon-381-user-1"></i>
                <span class="links_name">User Account Summery</span>
            </a>
            <span class="tooltip">User Account Summery</span>
        </li>
        @endif

        @if($hasAdministratorPermissions)
        <li>
            <a href="{{ url('/administratordashboard') }}" id="administrator_menu_link">
                <i id="administrator_menu_link_icon" class="flaticon-381-user-4"></i>
                <span class="links_name">Administrator</span>
            </a>
            <span class="tooltip">Administrator</span>
        </li>
        @endif
    </ul>
</div>