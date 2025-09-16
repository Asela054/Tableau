@extends('layouts.app')

@section('content')

<main>
    <div class="page-header shadow">
        <div class="container-fluid">
            @include('layouts.employee_nav_bar')
        </div>
    </div>
    <div class="container-fluid mt-4">
        <!-- Filter Card -->
        <div class="card mb-2">
            <div class="card-body">
                <form class="form-horizontal" id="formFilter">
                    <div class="form-row mb-1">
                        <div class="col-md-2">
                            <label class="small font-weight-bold text-dark">Company</label>
                            <select name="company" id="company_f" class="form-control form-control-sm"></select>
                        </div>
                        <div class="col-md-2">
                            <label class="small font-weight-bold text-dark">Location</label>
                            <select name="location" id="location_f" class="form-control form-control-sm"></select>
                        </div>
                        <div class="col-md-2">
                            <label class="small font-weight-bold text-dark">Department</label>
                            <select name="department" id="department_f" class="form-control form-control-sm"></select>
                        </div>
                        <div class="col-md-2">
                            <label class="small font-weight-bold text-dark">Employee</label>
                            <select name="employee" id="employee_f" class="form-control form-control-sm"></select>
                        </div>
                        <div class="col-md-4">
                            <label class="small font-weight-bold text-dark">Date : From - To</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="date" id="from_date" name="from_date" class="form-control form-control-sm border-right-0" placeholder="yyyy-mm-dd">
                                <input type="date" id="to_date" name="to_date" class="form-control" placeholder="yyyy-mm-dd">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm filter-btn float-right ml-2" id="btn-filter"><i class="fas fa-search mr-2"></i>Filter</button>
                            <button type="button" class="btn btn-danger btn-sm filter-btn float-right" id="btn-clear"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="card">
            <div class="card-body p-0 p-2">
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-outline-primary btn-sm fa-pull-right mr-2" name="create_record" id="create_record">
                            <i class="fas fa-plus mr-2"></i>Add Meter Reading
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm fa-pull-right mr-2" name="csv_upload" id="csv_upload">
                            <i class="fas fa-upload mr-2"></i>CSV Upload
                        </button>
                    </div>
                    <div class="col-12">
                        <hr class="border-dark">
                    </div>
                    <div class="col-12">
                        <div class="center-block fix-width scroll-inner">
                            <table class="table table-striped table-bordered table-sm small nowrap display" style="width: 100%" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>EMP ID</th>
                                        <th>DATE</th>
                                        <th>EMP NAME</th>
                                        <th>COUNT</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="formModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Meter Reading Count</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <span id="form_result"></span>
                            <form method="post" id="formTitle" class="form-horizontal">
                                {{ csrf_field() }}
                                <div class="form-row mb-1">
                                    <div class="col-6">
                                        <label class="small font-weight-bold text-dark">Date*</label>
                                        <input type="date" name="date" id="date" class="form-control form-control-sm" required />
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row mb-1">
                                    <div class="col-6">
                                        <label class="small font-weight-bold text-dark">Employee*</label>
                                        <select name="employee" id="employee" class="form-control form-control-sm" required></select>
                                    </div>
                                    <div class="col-6">
                                        <label class="small font-weight-bold text-dark">Count*</label>
                                        <input type="number" name="count" id="count" class="form-control form-control-sm" required />
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <div class="col-6">
                                        <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4 float-right">
                                            <i class="fas fa-plus"></i>&nbsp;Add
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="action" id="action" value="Add" />
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                            </form>
                        </div>
                        
                        <!-- Preview Table -->
                        <div class="col-12 mt-3">
                            <table class="table table-striped table-bordered table-sm small" id="tableorder">
                                <thead>
                                    <tr>
                                        <th>Emp ID</th>
                                        <th>Employee Name</th>
                                        <th>Date</th>
                                        <th>Count</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableorderlist"></tbody>
                            </table>
                            <div class="form-group mt-2">
                                <button type="button" name="btncreateorder" id="btncreateorder" class="btn btn-outline-primary btn-sm fa-pull-right px-4">
                                    <i class="fas fa-save"></i>&nbsp;Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CSV Upload Modal -->
    <div class="modal fade" id="uploadAtModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="csvmodal-title" id="staticBackdropLabel1">Upload CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="upload_response"></div>
                    <div class="row">
                        <div class="col">
                            <a href="{{ url('/public/csvsample/Meter Reading Count.csv') }}" class="control-label d-flex justify-content-end">
                                CSV Format - Download Sample File
                            </a>
                        </div>
                    </div>
                    <form method="post" id="formUpload" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <div class="form-row mb-1">
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">Date</label>
                                        <input required type="date" id="date_u" name="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" />
                                    </div>
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">CSV File</label>
                                        <input required type="file" id="csv_file_u" name="csv_file_u" class="form-control form-control-sm" accept=".csv" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mt-3">
                                    <button type="submit" name="action_button" id="btn-upload" class="btn btn-outline-primary btn-sm fa-pull-right px-4">
                                        <i class="fas fa-upload"></i>&nbsp;Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col text-center">
                            <h4 class="font-weight-normal">Are you sure you want to remove this data?</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger px-3 btn-sm">OK</button>
                    <button type="button" class="btn btn-dark px-3 btn-sm closebtn" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Edit Modal -->
    <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title" id="editModalLabel">Edit Meter Reading</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="edit_form_result"></div>
                    <form id="editForm">
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Date*</label>
                            <input type="date" name="edit_date" id="edit_date" class="form-control form-control-sm" required />
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Employee*</label>
                            <input type="text" id="edit_employee_name" class="form-control form-control-sm" readonly />
                            <input type="hidden" name="edit_employee_id" id="edit_employee_id" />
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Count*</label>
                            <input type="number" name="edit_count" id="edit_count" class="form-control form-control-sm" required min="0" />
                        </div>
                        <input type="hidden" id="edit_record_id" />
                    </form>
                </div>
                <div class="modal-footer p-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" id="updateRecord" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i>&nbsp;Update
                    </button>
                </div>
            </div>
        </div>
    </div>

</main>

@endsection

@section('script')
<script>
$(document).ready(function () {
    
    $('#employee_menu_link').addClass('active');
    $('#employee_menu_link_icon').addClass('active');
    $('#meterreading').addClass('navbtnactive');

    // Initialize filter dropdowns
    let company_f = $('#company_f');
    let department_f = $('#department_f');
    let employee_f = $('#employee_f');
    let location_f = $('#location_f');

    company_f.select2({
        placeholder: 'Select a Company',
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

    department_f.select2({
        placeholder: 'Select a Department',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '{{url("department_list_sel2")}}',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    company: company_f.val(),
                    location: location_f.val()
                }
            },
            cache: true
        }
    });

    employee_f.select2({
        placeholder: 'Select an Employee',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '{{url("employee_list_sel2")}}',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    company: company_f.val(),
                    location: location_f.val(),
                    department: department_f.val()
                }
            },
            cache: true
        }
    });

    location_f.select2({
        placeholder: 'Select Location',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '{{url("location_list_sel2")}}',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    company: company_f.val(),
                }
            },
            cache: true
        }
    });

    // Initialize employee dropdown in modal
    let employee = $("#employee").select2({
        placeholder: 'Select Employees',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '{{url("employee_list_sel2")}}',
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

    // Date change handler
    $('#date').on('change', function() {
        if ($(this).val()) {
            $('#employee').prop('disabled', false);
            $('#employee').val(null).trigger('change'); 
        } else {
            $('#employee').prop('disabled', true);
            $('#employee').val(null).trigger('change'); 
        }
    });

    // Load DataTable
    function load_dt(company, department, employee, location, from_date, to_date) {
        $('#dataTable').DataTable({
            lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    className: 'btn btn-default',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Print',
                    className: 'btn btn-default',
                    exportOptions: {
                        columns: 'th:not(:last-child)'
                    }
                }
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: scripturl + "/meter_reading_list.php",
                type: "POST",
                data: {
                    company: company,
                    department: department,
                    employee: employee,
                    location: location,
                    from_date: from_date,
                    to_date: to_date
                },
            },
            columns: [
                { data: 'emp_id', name: 'emp_id' },
                { data: 'date', name: 'date' },
                { data: 'emp_name_with_initial', name: 'emp_name_with_initial' },
                { data: 'count', name: 'count' },
                {
                    data: 'id',
                    name: 'action',
                    className: 'text-right',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-outline-primary btn-sm edit" id="' + row.id + '"><i class="fas fa-edit"></i></button>' +
                               '<button style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="Delete" class="btn btn-outline-danger btn-sm delete" id="' + row.id + '"><i class="far fa-trash-alt"></i></button>';
                    }
                }
            ],
            order: [[1, "desc"]],
            destroy: true
        });
    }

    // Initial load
    load_dt('', '', '', '', '', '');

    // Filter functionality
    $('#formFilter').on('submit', function(e) {
        e.preventDefault();
        load_dt(
            company_f.val() || '',
            department_f.val() || '',
            employee_f.val() || '',
            location_f.val() || '',
            $('#from_date').val() || '',
            $('#to_date').val() || ''
        );
    });

    $('#btn-clear').click(function() {
        $('#formFilter')[0].reset();
        company_f.val(null).trigger('change');
        department_f.val(null).trigger('change');
        employee_f.val(null).trigger('change');
        location_f.val(null).trigger('change');
        load_dt('', '', '', '', '', '');
    });

    // Create new record
    $('#create_record').click(function () {
        $('.modal-title').text('Add Meter Reading Count');
        $('#action').val('Add');
        $('#form_result').html('');
        $('#formTitle')[0].reset();
        $('#btncreateorder').prop('disabled', false).html('<i class="fas fa-save"></i>&nbsp;Save');
        $('#tableorder > tbody').html('');
        $('#hidden_id').val('');
        $('#employee').prop('disabled', true);
        $('#formModal').modal('show');
    });

    // Add to list functionality
    $("#formsubmit").click(function () {
        let employee = $('#employee').val();
        let date = $('#date').val();
        let count = $('#count').val();
        
        if (!employee) {
            alert('Please select an employee');
            return;
        }
        
        if (!date || !count) {
            alert('Please fill in all required fields');
            return;
        }
        
        let empName = $('#employee option[value="' + employee + '"]').text();
        let existingRow = false;
        
        // Check if employee already exists in table
        $('#tableorder tbody tr').each(function() {
            if ($(this).find('td:first').text() === employee) {
                existingRow = true;
                return false;
            }
        });
        
        if (!existingRow) {
            $('#tableorder > tbody:last').append('<tr class="pointer">' +
                '<td>' + employee + '</td>' +
                '<td>' + empName + '</td>' +
                '<td>' + date + '</td>' +
                '<td>' + count + '</td>' +
                '<td class="text-right"><button type="button" onclick="productDelete(this);" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td>' +
                '</tr>');
        } else {
            alert('Employee already added to the list');
        }
        
        $('#employee').val('').trigger('change');
        $('#count').val('');
    });

    // Save/Update functionality
    $('#btncreateorder').click(function () {
        var action_url = '';

        if ($('#action').val() == 'Add') {
            action_url = "{{ route('meter_reading_insert') }}";
        }
        if ($('#action').val() == 'Edit') {
            action_url = "{{ route('meter_reading_update') }}";
        }

        $('#btncreateorder').prop('disabled', true).html(
            '<i class="fas fa-circle-notch fa-spin mr-2"></i> Saving');

        var tbody = $("#tableorder tbody");

        if (tbody.children().length > 0) {
            var jsonObj = [];
            $("#tableorder tbody tr").each(function () {
                var item = {};
                $(this).find('td').each(function (col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObj.push(item);
            });

            var hidden_id = $('#hidden_id').val();

            $.ajax({
                method: "POST",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    tableData: jsonObj,
                    hidden_id: hidden_id,
                },
                url: action_url,
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#formTitle')[0].reset();
                        $('#tableorder tbody').empty();
                        $('#dataTable').DataTable().ajax.reload();
                        setTimeout(function(){
                            $('#formModal').modal('hide');
                        }, 2000);
                    }
                    $('#form_result').html(html);
                    $('#btncreateorder').prop('disabled', false).html('<i class="fas fa-save"></i>&nbsp;Save');
                },
                error: function(xhr) {
                    var html = '<div class="alert alert-danger">An error occurred while saving</div>';
                    $('#form_result').html(html);
                    $('#btncreateorder').prop('disabled', false).html('<i class="fas fa-save"></i>&nbsp;Save');
                }
            });
        } else {
            alert('Cannot Save. Table is empty!');
            $('#btncreateorder').prop('disabled', false).html('<i class="fas fa-save"></i>&nbsp;Save');
        }
    });

    // Edit functionality
    $(document).on('click', '.edit', function () {
        var id = $(this).attr('id');
        
        $.ajax({
            url: '{{ route("meter_reading_edit") }}',
            type: 'POST',
            dataType: "json",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {
                $('#edit_date').val(data.result.mainData.date);
                $('#edit_count').val(data.result.mainData.count);
                $('#edit_employee_id').val(data.result.mainData.emp_id);
                $('#edit_employee_name').val(data.result.mainData.employee ? data.result.mainData.employee.emp_name_with_initial : data.result.mainData.emp_id);
                $('#edit_record_id').val(id);
                $('#edit_form_result').html('');
                $('#editModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('Error details:', xhr.responseText);
                alert('Error loading data for edit: ' + (xhr.responseJSON ? xhr.responseJSON.message : error));
            }
        });
    });

    $('#updateRecord').click(function() {
        let updateBtn = $(this);
        let originalText = updateBtn.html();
        
        updateBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        
        let tableData = [{
            col_1: $('#edit_employee_id').val(),
            col_2: $('#edit_employee_name').val(), 
            col_3: $('#edit_date').val(),
            col_4: $('#edit_count').val()
        }];
        
        $.ajax({
            url: '{{ route("meter_reading_update") }}',
            type: 'POST',
            dataType: "json",
            data: {
                _token: '{{ csrf_token() }}',
                tableData: tableData,
                hidden_id: $('#edit_record_id').val()
            },
            success: function(data) {
                if (data.success) {
                    $('#edit_form_result').html('<div class="alert alert-success">' + data.success + '</div>');
                    $('#dataTable').DataTable().ajax.reload();
                    setTimeout(function() {
                        $('#editModal').modal('hide');
                    }, 1500);
                } else if (data.errors) {
                    let html = '<div class="alert alert-danger">';
                    data.errors.forEach(function(error) {
                        html += '<p>' + error + '</p>';
                    });
                    html += '</div>';
                    $('#edit_form_result').html(html);
                }
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'An error occurred while updating';
                $('#edit_form_result').html('<div class="alert alert-danger">' + errorMsg + '</div>');
            },
            complete: function() {
                updateBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // CSV Upload functionality
    $('#csv_upload').click(function() {
        $('#uploadAtModal').modal('show');
        $('#upload_response').html('');
    });

    $('#date_u').on('change', function() {
        if ($(this).val()) {
            $('#csv_file_u').prop('disabled', false);
        } else {
            $('#csv_file_u').prop('disabled', true);
            $('#csv_file_u').val('');
        }
    });

    if (!$('#date_u').val()) {
        $('#csv_file_u').prop('disabled', true);
    }

    $('#formUpload').on('submit', function(e) {
        e.preventDefault();
        let save_btn = $("#btn-upload");
        let btn_prev_text = save_btn.html();
        
        save_btn.html('<i class="fa fa-spinner fa-spin"></i> Uploading...');
        let formData = new FormData($('#formUpload')[0]);
        
        $.ajax({
            url: '{{ route("meter_reading_upload_csv") }}',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function(res) {
                if (res.status) {
                    let successHtml = `<div class='alert alert-success'>${res.msg}</div>`;
                    
                    if (res.errors && res.errors.length > 0) {
                        let errorHtml = '<div class="alert alert-warning mt-2"><strong>Some issues occurred:</strong><ul>';
                        res.errors.forEach(error => {
                            errorHtml += `<li>${error}</li>`;
                        });
                        errorHtml += '</ul></div>';
                        successHtml += errorHtml;
                    }
                    
                    $('#upload_response').html(successHtml);
                    
                    if (!res.errors || res.errors.length === 0) {
                        $("#formUpload")[0].reset();
                        setTimeout(function() {
                            $('#uploadAtModal').modal('hide');
                        }, 2000);
                    }
                } else {
                    let html = '<div class="alert alert-danger">';
                    if (res.errors && Array.isArray(res.errors)) {
                        html += '<strong>Errors occurred:</strong><ul>';
                        res.errors.forEach(error => {
                            html += `<li>${error}</li>`;
                        });
                        html += '</ul>';
                    } else {
                        html += res.msg || 'Something went wrong. Please check your file.';
                    }
                    html += '</div>';
                    $('#upload_response').html(html);
                }
                
                save_btn.html(btn_prev_text);
                $('#uploadAtModal').scrollTop(0);
                $('#dataTable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                let errorMessage = 'Something went wrong. Please check your file.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $('#upload_response').html(`<div class="alert alert-danger">${errorMessage}</div>`);
                save_btn.html(btn_prev_text);
            }
        });
    });

    // Delete functionality
    var user_id;

    $(document).on('click', '.delete', function () {
        user_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            url: '{!! route("meter_reading_delete") !!}',
            type: 'POST',
            dataType: "json",
            data: {
                id: user_id
            },
            beforeSend: function () {
                $('#ok_button').text('Deleting...');
            },
            success: function (data) {
                setTimeout(function () {
                    $('#confirmModal').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                }, 1000);
            },
            complete: function() {
                $('#ok_button').text('OK');
            },
            error: function() {
                alert('Error deleting record');
                $('#ok_button').text('OK');
            }
        });
    });

});

// Helper functions
function productDelete(row) {
    $(row).closest('tr').remove();
}
</script>

@endsection