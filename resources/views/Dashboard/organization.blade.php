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
            <div class="card-header d-flex flex-wrap border-0 pb-0">
                <div class="me-auto mb-sm-0 mb-3">
                    <h4 class="card-title mb-2">Managing Level Details</h4>
                </div>
            </div>
            <div class="card-body p-0 p-2">
                <div class="row">
                    <div class="col-12">
                        {{-- <h3>Managing Level Details</h3> --}}
                        <div class="center-block fix-width scroll-inner">
                            <table class="table table-striped table-bordered table-sm small nowrap" style="width: 100%"
                                id="divicestable">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Employee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($chairman_dettails as $chairman_dettail)
                                    <th>{{$chairman_dettail->title}}</th>
                                    <th>{{$chairman_dettail->emp_name_with_initial}} - {{$chairman_dettail->calling_name}}</th>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr class="border-dark">
                    </div>
                    <div class="col-12">
                        <div class="card-header d-flex flex-wrap border-0 pb-0">
                            <div class="me-auto mb-sm-0 mb-3">
                                <h4 class="card-title mb-2">Department wise Employees</h4>
                            </div>
                        </div>
                        <div class="card-body pb-2">
                            <canvas id="myAreaChart" width="100%" height="30"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Area Start -->

    <!-- Modal Area End -->
</main>

@endsection


@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {

        $('#organization_menu_link').addClass('active');
        $('#organization_menu_link_icon').addClass('active');

        getattend();
    });

    function getattend(){

        var url = "{{url('getcoparatedashboard_EmployeeChart')}}";

        var label  = new Array();
        var count  = new Array();
        var color  = new Array();
        $(document).ready(function(){
          $.get(url, function(response){
            response.forEach(function(data){
                label.push(data.name);
                count.push(data.count);

                var randomColor = 'rgba(' + Math.floor(Math.random() * 255) + ',' + 
                              Math.floor(Math.random() * 255) + ',' + 
                              Math.floor(Math.random() * 255) + ', 0.8)'; 
                color.push(randomColor);
            });

            var ctx = document.getElementById("myAreaChart");
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels:label,
                      data: count, 
                      backgroundColor: color,  
                      borderWidth: 1,
                      datasets: [{
                        label: '', 
                        data: count, 
                        backgroundColor: color,  
                        borderColor: color,      
                        borderWidth: 1                        
                    }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      },
                      tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: "#6e707e",
                            titleFontSize: 14,
                            borderColor: "#dddfeb",
                        
                        }
                      
                  }
              });
          });
        });
};
</script>

@endsection