@extends('layouts.app')

@section('content')

<main>
    <div class="page-header shadow">
        <div class="container-fluid">
            @include('layouts.corporate_nav_bar')
           
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-body p-0 p-2">
                <div class="row">
                    <div class="col-12">
                        @can('company-create')
                        <button type="button" class="btn btn-outline-primary btn-sm fa-pull-right" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add Company</button>
                        @endcan
                    </div>
                    <div class="col-12">
                        <hr class="border-dark">
                    </div>
                    <div class="col-12">
                        <div class="center-block fix-width scroll-inner">
                        <table class="table table-striped table-bordered table-sm small nowrap" style="width: 100%" id="dataTable">
                            <thead>
                                <tr>
                                    <th>ID </th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Address</th>
                                    <th>Contact No</th>
                                    <th>EPF No</th>
                                    <th>ETF No</th>
                                    <th>Ref No</th>
                                    <th>VAT Reg No</th>
                                    <th>SVAT No</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($company as $companies)
                                <tr>
                                    <td>{{$companies->id}}</td>
                                    <td>{{$companies->name}}</td>
                                    <td>{{$companies->code}}</td>
                                    <td>{{$companies->address}}</td>
                                    <td>{{$companies->mobile.' / '.$companies->land}}</td>
                                    <td>{{$companies->epf}}</td>
                                    <td>{{$companies->etf}}</td>
                                    <td>{{$companies->ref_no}}</td>
                                    <td>{{$companies->vat_reg_no}}</td>
                                    <td>{{$companies->svat_no}}</td>
                                    <td class="text-right">
                                        @can('department-list')
                                        <a href="{{ route('DepartmentShow',$companies->id) }}" title="Departments" class="branches btn btn-outline-info btn-sm" > <i class="fas fa-building"></i> </a>
                                        @endcan
                                        @can('location-list')
                                            <a href="{{ route('BranchShow',$companies->id) }}" title="Branch" class="location btn btn-outline-secondary btn-sm" > <i class="fas fa-code-branch"></i> </a>
                                        @endcan
                                        @can('company-edit')
                                            <button style="margin:2px;" name="edit" id="{{$companies->id}}" class="edit btn btn-outline-primary btn-sm" type="submit"><i class="fas fa-pencil-alt"></i></button>
                                        @endcan
                                        @can('company-delete')
                                            <button style="margin:2px;" type="submit" name="delete" id="{{$companies->id}}" class="delete btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        {{ $company->links() }}
                    </div>
                </div>    
            </div>
        </div>
    </div>
    <!-- Modal Area Start -->
    <div class="modal fade" id="formModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <span id="form_result"></span>
                            <form method="post" id="formTitle" class="form-horizontal">
                                {{ csrf_field() }}	
                                <div class="form-row mb-1">
                                    <div class="col-9">
                                        <label class="small font-weight-bold text-dark">Name*</label>
                                        <input type="text" name="name" id="name" class="form-control form-control-sm" />
                                    </div>
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">Code*</label>
                                        <input type="text" name="code" id="code" class="form-control form-control-sm" />
                                    </div>                                    
                                </div>
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Address</label>
                                    <input type="text" name="address" id="address" class="form-control form-control-sm" />
                                </div>
                                <div class="form-row mb-1">
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">Mobile*</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control form-control-sm" />
                                    </div>
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">Landline</label>
                                        <input type="text" name="land" id="land" class="form-control form-control-sm" />
                                    </div>                                    
                                </div>
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Email</label>
                                    <input type="text" name="email" id="email" class="form-control form-control-sm" />
                                </div>
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Domain Name</label>
                                    <input type="text" name="domain_name" id="domain_name" class="form-control form-control-sm" />
                                </div>

                                <div class="form-row mb-1">
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">EPF No</label>
                                        <input type="text" name="epf" id="epf" class="form-control form-control-sm" />
                                    </div>
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">ETF No</label>
                                        <input type="text" name="etf" id="etf" class="form-control form-control-sm" />
                                    </div>                         
                                </div>

                                <div class="form-row mb-1">
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">Ref No</label>
                                        <input type="text" name="ref_no" id="ref_no" class="form-control form-control-sm" />
                                    </div>
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">VAT Reg No</label>
                                        <input type="text" name="vat_reg_no" id="vat_reg_no" class="form-control form-control-sm" />
                                    </div>                         
                                </div>

                                <div class="form-row mb-1">
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">SVAT No</label>
                                        <input type="text" name="svat_no" id="svat_no" class="form-control form-control-sm" />
                                    </div>    
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">Zone Code</label>
                                        <input type="text" name="zone_code" id="zone_code" class="form-control form-control-sm" />
                                    </div>                         
                                </div>
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Bank Account Name</label>
                                    <input type="text" name="account_name" id="account_name" class="form-control form-control-sm" />
                                </div>
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Bank Account No</label>
                                    <input type="text" name="account_no" id="account_no" class="form-control form-control-sm" />
                                </div>
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Bank Account Branch Code</label>
                                    <input type="text" name="account_branchcode" id="account_branchcode" class="form-control form-control-sm" />
                                </div>
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Employee No</label>
                                    <input type="text" name="employeeno" id="employeeno" class="form-control form-control-sm" />
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" name="action_button" id="action_button" class="btn btn-outline-primary btn-sm fa-pull-right px-4"><i class="fas fa-plus"></i>&nbsp;Add</button>
                                </div>
                                <input type="hidden" name="action" id="action" value="Add" />
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-dark px-3 btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Area End -->
</main>
              
@endsection


@section('script')

<script>
$(document).ready(function(){

    $('#organization_menu_link').addClass('active');
    $('#organization_menu_link_icon').addClass('active');
    $('#companylink').addClass('navbtnactive');

    $('#dataTable').DataTable();

    $('#create_record').click(function(){
        $('.modal-title').text('Add New Company');
        $('#action_button').html('Add');
        $('#action').val('Add');
        $('#form_result').html('');
        $('#formTitle')[0].reset();

        $('#formModal').modal('show');
    });
 
    $('#formTitle').on('submit', function(event){
        event.preventDefault();
        var action_url = '';

        if ($('#action').val() == 'Add') {
            action_url = "{{ route('addCompany') }}";
        }
        if ($('#action').val() == 'Edit') {
            action_url = "{{ route('Company.update') }}";
        }

        $.ajax({
            url: action_url,
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (data) {//alert(data);

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
                    //$('#titletable').DataTable().ajax.reload();
                    location.reload()
                }
                $('#form_result').html(html);
            }
        });
    });

    $(document).on('click', '.edit', function () {
        var id = $(this).attr('id');
        $('#form_result').html('');
        $.ajax({
            url: "Company/" + id + "/edit",
            dataType: "json",
            success: function (data) {
                $('#name').val(data.result.name);
                $('#code').val(data.result.code);
                $('#address').val(data.result.address);
                $('#mobile').val(data.result.mobile);
                $('#land').val(data.result.land);
                $('#email').val(data.result.email);
                $('#domain_name').val(data.result.domain_name);
                $('#epf').val(data.result.epf);
                $('#etf').val(data.result.etf);
                $('#ref_no').val(data.result.ref_no);
                $('#vat_reg_no').val(data.result.vat_reg_no);
                $('#svat_no').val(data.result.svat_no);
                $('#account_name').val(data.result.bank_account_name);
                $('#account_no').val(data.result.bank_account_number);
                $('#account_branchcode').val(data.result.bank_account_branch_code);
                $('#employeeno').val(data.result.employer_number);
                $('#zone_code').val(data.result.zone_code);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Company');
                $('#action_button').html('Edit');
                $('#action').val('Edit');
                $('#formModal').modal('show');
            }
        })
    });

    var user_id;

    $(document).on('click', '.delete', function () {
        user_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function () {
        $.ajax({
            url: "Company/destroy/" + user_id,
            beforeSend: function () {
                $('#ok_button').text('Deleting...');
            },
            success: function (data) {//alert(data);
                setTimeout(function () {
                    $('#confirmModal').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                    alert('Data Deleted');
                }, 2000);
                location.reload()
            }
        })
    });
});
</script>

@endsection