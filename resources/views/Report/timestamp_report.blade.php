<?php $page_stitle = 'Report on Employee No Pay Days '; ?>
@extends('layouts.app')

@section('content')

    <main>
        <div class="page-header shadow">
            <div class="container-fluid">
                @include('layouts.reports_nav_bar')
               
            </div>
        </div>

        <div class="container-fluid mt-4">
            <div class="card mb-2">
                <div class="card-body">
                    <form class="form-horizontal" id="formFilter">
                        <div class="form-row mb-1">
                            <div class="col-md-3">
                                <label class="small font-weight-bold text-dark">Company</label>
                                <select name="company" id="company" class="form-control form-control-sm">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="small font-weight-bold text-dark">Department</label>
                                <select name="department" id="department" class="form-control form-control-sm">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="small font-weight-bold text-dark">Location</label>
                                <select name="location" id="location" class="form-control form-control-sm">
                                </select>
                            </div>
                            <div class="col-md-3 div_month">
                               <label class="small font-weight-bold text-dark">Date : From - To</label>
                                <div class="input-group input-group-sm mb-3">
                                    <input type="date" id="from_date" name="from_date" class="form-control form-control-sm border-right-0"
                                           placeholder="yyyy-mm-dd" required>

                                    <input type="date" id="to_date" name="to_date" class="form-control" placeholder="yyyy-mm-dd" required>
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-sm filter-btn" id="btn-filter"> Filter</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0 p-2">
                      <div class="d-flex justify-content-between align-items-center">
                        <div></div>
                        <button class="btn btn-danger btn-sm" id="btn-print">
                            <i class="fas fa-print mr-1"></i> Print Report
                        </button>
                    </div>
                     <div class="daily_table table-responsive center-block fix-width scroll-inner" id="tableContainer">
                      </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('script')

    <script>
        $(document).ready(function () {

            $('#report_menu_link').addClass('active');
            $('#report_menu_link_icon').addClass('active');
            $('#employeereportmaster').addClass('navbtnactive');


            let company = $('#company');
            let department = $('#department');
            let location = $('#location');

            company.select2({
                placeholder: 'Select...',
                width: '100%',
                allowClear: true,
                ajax: {
                    url: '{{url("company_list_sel2")}}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });

            department.select2({
                placeholder: 'Select...',
                width: '100%',
                allowClear: true,
                ajax: {
                    url: '{{url("department_list_sel2")}}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            company: company.val()
                        }
                    },
                    cache: true
                }
            });

            location.select2({
                placeholder: 'Select...',
                width: '100%',
                allowClear: true,
                ajax: {
                    url: '{{url("location_list_sel2")}}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });


            //load_dt('');
            function load_dt(department, location,from_date, to_date){

                 $.ajax({
                    url: '{{ route("generate_timestamp_report") }}',
                    type: 'GET',
                    data: {
                        department: department,
                        from_date: from_date,
                        to_date: to_date,
                        location: location
                    },
                    success: function (response) {
                        $('#tableContainer').html(response.html);
                    }
                });

            }

            $('#formFilter').on('submit',function(e) {
                e.preventDefault();
                let department = $('#department').val();
                let location = $('#location').val();
                let to_date = $('#to_date').val();
                let from_date = $('#from_date').val();

                load_dt(department, location,from_date, to_date);
            });


        $(document).on('click', '#btn-print', function() {
            printTableContainer();
        });

        
        function printTableContainer() {
            const printContent = document.getElementById('tableContainer').innerHTML;
            
            // Create a new window for printing
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            
            // Build the HTML for printing
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Timestamp Report</title>
                    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }
                        @media print {
                            .page-break {
                                page-break-after: always !important;
                            }
                            .date-section {
                                page-break-inside: avoid;
                            }
                            table {
                                font-size: 10px;
                                width: 100%;
                            }
                            th, td {
                                padding: 4px;
                                border: 1px solid #ddd;
                            }
                            .no-print {
                                display: none !important;
                            }
                            h5 {
                                background-color: #f8f9fa;
                                padding: 8px;
                                margin-bottom: 10px;
                            }
                        }
                        .date-section {
                            margin-bottom: 30px;
                        }
                        h5 {
                            background-color: #f8f9fa;
                            padding: 10px;
                            border-radius: 4px;
                            margin-bottom: 15px;
                        }
                        table {
                            font-size: 11px;
                        }
                        th {
                            background-color: #f8f9fa;
                            font-weight: bold;
                        }
                    </style>
                </head>
                <body>
                    <h2 class="text-center mb-4">Employee Timestamp Report</h2>
                    <div class="filter-info mb-3">
                        <p><strong>Date Range:</strong> ${$('#from_date').val()} to ${$('#to_date').val()}</p>
                        <p><strong>Company:</strong> ${$('#company').select2('data')[0]?.text || 'All'}</p>
                        <p><strong>Department:</strong> ${$('#department').select2('data')[0]?.text || 'All'}</p>
                        <p><strong>Location:</strong> ${$('#location').select2('data')[0]?.text || 'All'}</p>
                    </div>
                    <hr>
                    ${printContent}
                    <script>
                        window.onload = function() {
                            window.print();
                            setTimeout(function() {
                                window.close();
                            }, 100);
                        }
                    <\/script>
                </body>
                </html>
            `);
            
            printWindow.document.close();
        }


        });
    </script>

@endsection

