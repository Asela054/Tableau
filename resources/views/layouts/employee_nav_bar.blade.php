<div class="row nowrap" style="padding-top: 5px;padding-bottom: 5px;">

  @php
    $hasMasterDataAccess = auth()->user()->can('job-title-list') ||
                         auth()->user()->can('pay-grade-list') ||
                         auth()->user()->can('job-category-list') ||
                         auth()->user()->can('job-employment-status-list') ||
                         auth()->user()->can('skill-list') ||
                         auth()->user()->can('ExamSubject-list') ||
                         auth()->user()->can('DSDivision-list') ||
                         auth()->user()->can('GNSDivision-list') ||
                         auth()->user()->can('PoliceStation-list');
  @endphp

  @if($hasMasterDataAccess)
  <div class="dropdown">
    <a role="button" data-toggle="dropdown" class="btn navbtncolor" href="javascript:void(0);" id="employeemaster">
      Master Data <span class="caret"></span></a>
      <ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">
        @if(auth()->user()->can('skill-list'))
        <li><a class="dropdown-item" href="{{ route('Skill')}}">Skill</a></li>
        @endif
        @if(auth()->user()->can('job-title-list'))
        <li><a class="dropdown-item" href="{{ route('JobTitle')}}">Job Titles</a></li>
        @endif
        @if(auth()->user()->can('pay-grade-list'))
        <li><a class="dropdown-item" href="{{ route('PayGrade')}}">Pay Grades</a></li>
        @endif
        @if(auth()->user()->can('job-employment-status-list'))
        <li><a class="dropdown-item" href="{{ route('EmploymentStatus')}}">Job Employment Status</a></li>
        @endif
        @if(auth()->user()->can('ExamSubject-list'))
        <li><a class="dropdown-item" href="{{ route('examsubjects')}}">Exam Subjects</a></li>
        @endif
        @if(auth()->user()->can('DSDivision-list'))
        <li><a class="dropdown-item" href="{{ route('dsdivision')}}">DS Divisions</a></li>
        @endif
        @if(auth()->user()->can('GNSDivision-list'))
        <li><a class="dropdown-item" href="{{ route('gnsdivision')}}">GNS Divisions</a></li>
        @endif
        @if(auth()->user()->can('PoliceStation-list'))
        <li><a class="dropdown-item" href="{{ route('policestation')}}">Police Station</a></li>
        @endif
      </ul>
  </div>
  @endif

  @if(auth()->user()->can('employee-list'))
  <a role="button" class="btn navbtncolor" href="{{ route('addEmployee') }}" id="employeeinformation">Employee Details</a>
  @endif

  @php
    $hasLettersAccess = auth()->user()->can('Appointment-letter-list') ||
                      auth()->user()->can('Service-letter-list') ||
                      auth()->user()->can('Warning-letter-list') ||
                      auth()->user()->can('Resign-letter-list') ||
                      auth()->user()->can('Salary-inc-letter-list') ||
                      auth()->user()->can('Promotion-letter-list') ||
                      auth()->user()->can('NDA-letter-list') ||
                      auth()->user()->can('end-user-letter-list');
  @endphp

  @if($hasLettersAccess)
  <div class="dropdown">
    <a role="button" data-toggle="dropdown" class="btn navbtncolor" href="javascript:void(0);" id="appointmentletter">
      Employee Letters <span class="caret"></span></a>
      <ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">
        @if(auth()->user()->can('Appointment-letter-list'))
        <li><a class="dropdown-item" href="{{ route('appoinementletter')}}">Employee Appointment Letter</a></li>
        @endif
        @if(auth()->user()->can('NDA-letter-list'))
        <li><a class="dropdown-item" href="{{ route('NDAletter')}}">Employee NDA Letter</a></li>
        @endif
        @if(auth()->user()->can('Warning-letter-list'))
        <li><a class="dropdown-item" href="{{ route('warningletter')}}">Employee Warning Letter</a></li>
        @endif
        @if(auth()->user()->can('Salary-inc-letter-list'))
        <li><a class="dropdown-item" href="{{ route('salary_incletter')}}">Employee Salary Increment Letter</a></li>
        @endif
        @if(auth()->user()->can('Promotion-letter-list'))
        <li><a class="dropdown-item" href="{{ route('promotionletter')}}">Employee Promotion Letter</a></li>
        @endif
        @if(auth()->user()->can('Service-letter-list'))
        <li><a class="dropdown-item" href="{{ route('serviceletter')}}">Employee Service Letter</a></li>
        @endif
        @if(auth()->user()->can('Resign-letter-list'))
        <li><a class="dropdown-item" href="{{ route('resignletter')}}">Employee Resignation Letter</a></li>
        @endif
        @if(auth()->user()->can('end-user-letter-list'))
        <li><a class="dropdown-item" href="{{ route('end_user_letter')}}">Employee End User Letter</a></li>
        @endif
      </ul>
  </div>
  @endif
  <div class="dropdown">
    <a role="button" data-toggle="dropdown" class="btn navbtncolor" href="javascript:void(0);" id="dailyprocess">
      Daily Production Process <span class="caret"></span></a>
      <ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">
        <li><a class="dropdown-item" href="{{ route('machines')}}">Machines</a></li>
        <li><a class="dropdown-item" href="{{ route('products')}}">Products</a></li>
        <li><a class="dropdown-item" href="{{ route('productionallocation')}}">Employee Allocation</a></li>
        <li><a class="dropdown-item" href="{{ route('productionending')}}">Daily Process Ending</a></li>
        <li><a class="dropdown-item" href="{{ route('employeeproductionreport')}}">Employee Production</a></li>
      </ul>
  </div>

  <div class="dropdown">
    <a role="button" data-toggle="dropdown" class="btn navbtncolor" href="javascript:void(0);" id="dailytask">
      Daily Task Process <span class="caret"></span></a>

      <ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">
        <li><a class="dropdown-item" href="{{ route('tasks')}}">Tasks</a></li>
        <li><a class="dropdown-item" href="{{ route('taskallocation')}}">Employee Task Allocation</a></li>
        <li><a class="dropdown-item" href="{{ route('taskending')}}">Daily Task Ending</a></li>
      </ul>
  </div>

  @php
    $hasPerformanceAccess = auth()->user()->can('pe-task-list');
  @endphp

  @if($hasPerformanceAccess)
  <div class="dropdown">
    <a role="button" data-toggle="dropdown" class="btn navbtncolor" href="javascript:void(0);" id="performanceinformation">
      Performance Evaluation <span class="caret"></span></a>
      <ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">
        @if(auth()->user()->can('pe-task-list'))
        <li><a class="dropdown-item" href="{{ route('peTaskList')}}">Task List</a></li>
        @endif
        @if(auth()->user()->can('employee-allowance-list'))
        <li><a class="dropdown-item" href="{{ route('peTaskEmployeeList')}}">Task Employee List</a></li>
        @endif
        @if(auth()->user()->can('employee-allowance-list'))
        <li><a class="dropdown-item" href="{{ route('peTaskEmployeeMarksList')}}">Marks Approve</a></li>
        @endif
      </ul>
  </div>
  @endif

  @php
    $hasAllowanceAccess = auth()->user()->can('allowance-amount-list') ||
                        auth()->user()->can('employee-allowance-list');
  @endphp

  @if($hasAllowanceAccess)
  <div class="dropdown">
    <a role="button" data-toggle="dropdown" class="btn navbtncolor" href="javascript:void(0);" id="allowanceinformation">
      Allowance Amounts <span class="caret"></span></a>
      <ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">
        @if(auth()->user()->can('allowance-amount-list'))
        <li><a class="dropdown-item" href="{{ route('allowanceAmountList')}}">Allowance Amounts</a></li>
        @endif
        @if(auth()->user()->can('employee-allowance-list'))
        <li><a class="dropdown-item" href="{{ route('emp_allowance')}}">Employee Allowance</a></li>
        @endif
        @if(auth()->user()->can('employee-allowance-list'))
        <li><a class="dropdown-item" href="{{ route('allowance_approved')}}">Approved Allowance</a></li>
        @endif
      </ul>
  </div>
  @endif

</div>