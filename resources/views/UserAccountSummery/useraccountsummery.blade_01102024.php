
@extends('layouts.app')

@section('content')
<main>
    <div class="page-header shadow">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="page-header-tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#account-details" data-toggle="tab">Account Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#monthly-summary" data-toggle="tab">Monthly Summary</a>
                        </li>
                    </ul>
                </div>
        </div>
        </div>
    </div>

    <div class="container-fluid mt-4">

        <div class="tab-content container-fluid">
            <div class="tab-pane fade show active" id="account-details">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row justify-content-center"><img src="{{ url('/public/images/' . ($employee->emp_pic_filename ? $employee->emp_pic_filename : 'user-profile.png')) }}" alt="Profile_Pic" style="width: 180px;height: 180px;border: 16px solid rgb(226 230 237);top: -0px;position: relative;" class="rounded-circle"></div><br>
                        <div class="row">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">User Name</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="username">{{$employee->emp_name_with_initial}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">EPF No</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="epfno">{{$employee->emp_etfno}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">NIC</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="nic">{{$employee->emp_national_id}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Address</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="address">{{$employee->emp_address}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Mobile No</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="mobileno">{{$employee->emp_mobile}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Telephone</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="telephone">{{$employee->emp_work_telephone}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Date of Birth</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="dateofbirth">{{$employee->emp_birthday}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Join Date</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="joindate">{{$employee->emp_join_date}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Job Title</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="jobtitle">{{$employee->title}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Job Status</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="jobstatus">{{$employee->emp_statusname}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Company</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="company">{{$employee->companyname}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Location</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="location">{{$employee->location}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Department</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="department">{{$employee->departmentname}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-3">
                                        <p class="text-left">Job Category</p>
                                    </div>
                                    <div style="width: 5px">:</div>
                                    <div class="col-6">
                                        <p class="text-left" id="jobcategory">{{$employee->category}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="monthly-summary">
                <div class="card mb-2">
                    <div class="card-body">
                        <form class="form-horizontal" id="formFilter">
                            <div class="form-row mb-1">
                                <div class="col-4">
                                    <label class="small font-weight-bold text-dark">Moth</label>
                                    <?php
                                        $currentYearMonth = date('Y-m');
                                        $previousMonth = date('Y-m', strtotime('-1 month'));
                                    ?>
                                    <input type="month" id="selectedmonth" name="selectedmonth" class="form-control form-control-sm" max="<?php echo $previousMonth; ?>" required />
                                </div>
                                <div class="col">
                                    <br>
                                    <button type="button" class="btn btn-primary btn-sm filter-btn" id="btn-filter">
                                        Filter</button>
                                    <p id="locationerrormsg"></p>
                                </div>
                            </div>
        
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center">
                                <h4> Attendance Summery</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Working Week Days</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="workingdays">0</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Default Working Week Days</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="working_week_days_arr">0</p>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Absent Days</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="absentdays">0</p>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Leave Days</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="leave_days">0</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">No Pay Days</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="no_pay_days">0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr style="height: 2px;background: rgb(119, 119, 119)">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 text-center">
                                <h4> Monthly Salary Summery</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Basic </p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="basic">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">BRA I</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="bra1">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">BRA II</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="bra2">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">No-pay </p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="nopay">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Total Before Nopay</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="totalbeforenopay">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Arrears</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="arrears">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Weekly Attendance </p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="weeklyattendance">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Incentive</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="incentive">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Director Incentiv</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="directorincentive">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Salary Arrears </p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="salaryarrears">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Normal</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="normal">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Double</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="double">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Total
                                            Earned </p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="totalearned">0.00</p>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 text-center">
                                <h4 style="color: transparent"> Monthly Salary Summery</h4>
                                <hr>                       
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Total for Tax</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="totalfortax">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">EPF-8</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="epf8">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Salary Advance </p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="salaryadvance">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Loans</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="loan">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">IOU Deduction</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="iou">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Funeral Fund </p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="funaralfund">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">P.A.Y.E.</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="paye">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Other</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="other">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">Total Deductions </p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="totaldeduction">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left font-weight-bold text-dark">Balance Pay</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right font-weight-bold text-dark" style="border-bottom: 3px double #343a40;" id="balancepay">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">EPF-12</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="epf12">0.00</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left">ETF-3</p>
                                    </div>
                                    <div class="col-1">:</div>
                                    <div class="col-3">
                                        <p class="text-right" id="etf3">0.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
    </div>
</main>


@endsection
@section('script')
<script>
    $(document).ready(function () {

        $('#user_information_menu_link').addClass('active');
        $('#user_information_menu_link_icon').addClass('active');

        var emprecordid={{$emprecordid}};
        var empid={{$emp_id}};
        var emplocation={{$emp_location}};

        if (emplocation=='' || emplocation==null || emplocation==0) {
            $('#btn-filter').prop('disabled', true);
            $('#locationerrormsg').text('Work Location Not Assign!!');
        }else{
            $('#btn-filter').prop('disabled', false);
            $('#locationerrormsg').text('');
        }

        $('#btn-filter').click(function() {
            let selectedmonth = $('#selectedmonth').val();
            if(!selectedmonth){
                $('#selectedmonth').focus();
                return false;
            }

            $(this).prop('disabled', true);
            $(this).html('<i class="fas fa-spinner fa-spin"></i> ');
            
            $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })

                $.ajax({
                    url: '{!! route("get_employee_monthlysummery") !!}',
                    type: 'POST',
                    dataType: "json",
                    data: {
                        selectedmonth: selectedmonth,
                        emprecordid:emprecordid,
                        empid:empid,
                        emplocation:emplocation

                    },
                    success: function (data) {
                        $('#workingdays').text(data.result.workingdays);
                        $('#working_week_days_arr').text(data.result.working_week_days_arr);
                        $('#leave_days').text(data.result.leave_days);
                        $('#absentdays').text(data.result.absentdays);
                        $('#no_pay_days').text(data.result.no_pay_days);

                        // salary part
                        $('#basic').text(parseFloat(data.salaryresult.BASIC).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#bra1').text(parseFloat(data.salaryresult.BRA_I).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#bra2').text(parseFloat(data.salaryresult.add_bra2).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#nopay').text(parseFloat(data.salaryresult.NOPAY).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#totalbeforenopay').text(parseFloat(data.salaryresult.tot_bnp).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#arrears').text(parseFloat(data.salaryresult.sal_arrears1).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#weeklyattendance').text(parseFloat(data.salaryresult.ATTBONUS_W).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#incentive').text(parseFloat(data.salaryresult.INCNTV_EMP).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#directorincentive').text(parseFloat(data.salaryresult.INCNTV_DIR).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#salaryarrears').text(parseFloat(data.salaryresult.sal_arrears2).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#normal').text(parseFloat(data.salaryresult.OTHRS1).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#double').text(parseFloat(data.salaryresult.OTHRS2).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#totalearned').text(parseFloat(data.salaryresult.tot_earn).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#totalfortax').text(parseFloat(data.salaryresult.tot_fortax).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#epf8').text(parseFloat(data.salaryresult.EPF8).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#salaryadvance').text(parseFloat(data.salaryresult.sal_adv).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#loan').text(parseFloat(data.salaryresult.LOAN).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#iou').text(parseFloat(data.salaryresult.ded_IOU).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#funaralfund').text(parseFloat(data.salaryresult.ded_fund_1).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#paye').text(parseFloat(data.salaryresult.PAYE).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#other').text(parseFloat(data.salaryresult.ded_other).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#totaldeduction').text(parseFloat(data.salaryresult.tot_ded).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#balancepay').text(parseFloat(data.salaryresult.NETSAL).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#epf12').text(parseFloat(data.salaryresult.EPF12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('#etf3').text(parseFloat(data.salaryresult.ETF3).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        
                        $('#btn-filter').prop('disabled', false);
                        $('#btn-filter').html('<span class="button-text">Filter</span>');
                    }
                });

            });

    });
</script>

@endsection