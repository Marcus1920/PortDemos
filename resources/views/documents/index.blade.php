@extends('master')

@section('content')

    <style>
        .box {
            position: relative;
            border-radius: 3px;
            background: whitesmoke;
            border-top: 4px solid #d2d6de;
            margin-bottom: 20px;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }
        .box.box-primary {
            border-top-color: #3c8dbc;
        }
        .box.box-info {
            border-top-color: #00c0ef;
        }
        .box.box-danger {
            border-top-color: #dd4b39;
        }
        .box.box-warning {
            border-top-color: #f39c12;
        }
        .box.box-success {
            border-top-color: #00a65a;
        }
        .box.box-default {
            border-top-color: #d2d6de;
        }



    </style>

    <ol class="breadcrumb hidden-xs">
        <li><a href="#">Home</a></li>
        <li><a style="cursor:pointer;" data-toggle="modal" data-target=".modalCase">Console</a></li>
    </ol>

    <h4 class="page-title">Console</h4>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-4">
                    <!-- AREA CHART -->
                    <div  class="box box-primary" onclick="window.location = '{{ 'list-pending-cases' }}'">
                        <div class="box-header with-border">
                            <h3 style="color: black;margin-left: 10px;" class="box-title">Pending Cases <span class="pull-right" style="margin-right: 10px; color: #3d8ebd;" >{{ count($numberPendingCases,0)}} </span></h3>

                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="areaChart" style="height:250px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- DONUT CHART -->
                    <div class="box box-danger" onclick="window.location = '{{ 'list-pending-closure-cases' }}'">
                        <div class="box-header with-border">
                            <h3 style="color: black; margin-left: 10px;" class="box-title">Pending Closure Cases <span class="pull-right" style="margin-right: 10px; color: #3d8ebd;" >{{ count($numberPendingClosureCases,0)}}</span></h3>

                        </div>
                        <div class="box-body">
                            <canvas id="pieChart" style="height:250px"></canvas>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>
                <!-- /.col (LEFT) -->
                <div class="col-md-4">
                    <!-- LINE CHART -->
                    <div class="box box-info" onclick="window.location = '{{ 'list-allocated-cases' }}'">
                        <div class="box-header with-border">
                            <h3 style="color: black; margin-left: 10px;" class="box-title">Allocated/Referred Cases <span class="pull-right" style="margin-right: 10px; color: #3d8ebd;" >{{ count($numberReferredCases,0)}}</span></h3>

                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="lineChart" style="height:250px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- BAR CHART -->
                    <div class="box box-success" onclick="window.location = '{{ 'list-closed-cases' }}'">
                        <div class="box-header with-border">
                            <h3 style="color: black; margin-left: 10px;" class="box-title">Closed Cases <span class="pull-right" style="margin-right: 10px; color: #3d8ebd;" > {{ count($numberResolvedCases,0)}}</span></h3>

                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="barChart" style="height:230px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>
            <div class="col-md-4">
            <iframe src="map.php" style="width: 100%; height: 490px"></iframe>
            </div>
                <!-- /.col (RIGHT) -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>

    {{--<div class="row">--}}
        {{--<div class="col-md-6">--}}
        {{--<iframe src="map.php"></iframe>--}}
        {{--</div>--}}
    {{--</div>--}}



    <!--------------------------------------------------------------------------   ---------------------------------->


    <!-- Breadcrumb -->




    <!-- Quick Stats
<div class="block-area" id="tabs">
    <div class="tab-container">

        <div class="row nav tab">


            @if(isset($userViewAllocatateReferredCasesPermission) && $userViewAllocatateReferredCasesPermission->permission_id =='17')
        <a href="#reported">
            <div class="col-md-5 col-xs-6">
                <div class="tile quick-stats">
                    <div id="stats-line-2" class="pull-left"></div>
                    <div class="data">
                        <h2 data-value="{{ count($numberReferredCases,0)}}">0</h2>
                            <small>Allocated/Referred Cases </small>
                        </div>
                    </div>
                </div>
             </a>
            @endif


    @if(isset($userViewPendingAllocationCasesPermission) && $userViewPendingAllocationCasesPermission->permission_id =='18')

        <a href="#pendingreferral">
            <div class="col-md-5 col-xs-6">
                <div class="tile quick-stats">
                    <div id="stats-line" class="pull-left"></div>
                    <div class="data">
                        <h2 data-value="{{ count($numberPendingCases,0)}}">0</h2>
                                <small>Pending Allocation Cases </small>
                            </div>
                        </div>
                    </div>
                </a>
            @endif

            </div>

            <div class="row nav tab">
            @if(isset($userViewPendingClosureCasesPermission) && $userViewPendingClosureCasesPermission->permission_id =='19')


        <a href="#closure">
            <div class="col-md-5 col-xs-6">
                <div class="tile quick-stats media">
                    <div id="stats-line-3" class="pull-left"></div>
                    <div class="media-body">
                        <h2 data-value="{{ count($numberPendingClosureCases,0)}}">0</h2>
                            <small>Pending Closure Cases</small>
                        </div>
                    </div>
                </div>
            </a>

            @endif
    @if(isset($userViewResolvedCasesPermission) && $userViewResolvedCasesPermission->permission_id =='20')

        <a href="#resolved">
            <div class="col-md-5 col-xs-6">
                <div class="tile quick-stats media">
                    <div id="stats-line-4" class="pull-left"></div>
                    <div class="media-body">
                        <h2 data-value="{{ count($numberResolvedCases,0)}}">0</h2>
                            <small>Resolved Cases</small>
                        </div>
                    </div>
                </div>
            </a>
            @endif

            </div>

           <hr class="whiter" />

           <!--<div class="tab-content">
                <div class="tab-pane active" id="reported">
                    <!-- Responsive Table
                    <div class="block-area" id="responsiveTable">
                        @if(Session::has('success'))
        <div class="alert alert-info alert-dismissable fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('success') }}
                </div>
                @endif
            <div class="table-responsive overflow">
                <h3 class="block-title">Allocated/Referred Cases</h3>
               @if(isset($userCreateCasesPermission) && $userCreateCasesPermission->permission_id =='21')
        <button class="btn btn-sm m-r-5" data-toggle="modal" onclick="clearCreateCaseModal()" data-target=".modalCreateCaseAgent">Create Case</button>


        <table class="table tile table-striped" id="casesTable">
            <thead>
              <tr>
                   <th>Id</th>
                    <th>Created At</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Department</th>
                    <th>Actions</th>
              </tr>
            </thead>
        </table>
        @endif
            </div>
        </div>
    </div>
    <div class="tab-pane" id="closure">
     <!-- Responsive Table
        <div class="block-area" id="responsiveTable">
            @if(Session::has('success'))
        <div class="alert alert-info alert-dismissable fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('success') }}
                </div>
                @endif
            <div class="table-responsive overflow">
                <h3 class="block-title">Pending Closure Cases</h3>
                 @if(isset($userCreateCasesPermission) && $userCreateCasesPermission->permission_id =='21')
        <button class="btn btn-sm m-r-5" data-toggle="modal" onclick="clearCreateCaseModal()" data-target=".modalCreateCaseAgent">Create Case</button>

        <table class="table tile table-striped" id="deletedCasesTable">
            <thead>
              <tr>
                    <th>Id</th>
                    <th>Created At</th>
                    <th>Description</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Actions</th>
              </tr>
            </thead>
        </table>
         @endif
            </div>
        </div>
    </div>

    <div class="tab-pane" id="pendingreferral">
     <!-- Responsive Table
        <div class="block-area" id="responsiveTable">
            @if(Session::has('success'))
        <div class="alert alert-info alert-dismissable fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('success') }}
                </div>
                @endif
            <div class="table-responsive overflow">
                <h3 class="block-title">Pending Allocation Cases</h3>
                 @if(isset($userCreateCasesPermission) && $userCreateCasesPermission->permission_id =='21')
        <button class="btn btn-sm m-r-5" data-toggle="modal" onclick="clearCreateCaseModal()" data-target=".modalCreateCaseAgent">Create Case</button>

        <table class="table tile table-striped" id="pendingreferralCasesTable">
            <thead>
              <tr>
                    <th>Id</th>
                    <th>Created At</th>
                    <th>Description</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Actions</th>
              </tr>
            </thead>
        </table>
        @endif
            </div>
        </div>
    </div>

    <div class="tab-pane" id="resolved">
     <!-- Responsive Table
        <div class="block-area" id="responsiveTable">
            @if(Session::has('success'))
        <div class="alert alert-info alert-dismissable fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('success') }}
                </div>
                @endif
            <div class="table-responsive overflow">
                <h3 class="block-title">Resolved Cases</h3>
                 @if(isset($userCreateCasesPermission) && $userCreateCasesPermission->permission_id =='21')
        <button class="btn btn-sm m-r-5" data-toggle="modal" onclick="clearCreateCaseModal()" data-target=".modalCreateCaseAgent">Create Case</button>

        <table class="table tile table-striped" id="resolvedCasesTable">
            <thead>
              <tr>
                    <th>Id</th>
                    <th>Created At</th>
                    <th>Description</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Actions</th>
              </tr>
            </thead>
        </table>
        @endif
            </div>
        </div>
    </div>


</div>
</div>
</div>-->

    <a id="anchorID" target="newwindow" class="hidden"></a>

    <hr class="whiter" />




    @include('cases.profile')
    @include('cases.refer')
    @include('cases.report')
    @include('cases.allocation')
    @include('cases.create')
    @include('cases.createCase')
    @include('cases.closeRequest')
    @include('addressbook.list')
    @include('addressbook.add')
    @include('casenotes.add')
    @include('casefiles.add')
    @include('users.edit')
    @include('cases.workflow')
    @include('cases.poi')
    @include('cases.dueDate')



@endsection

@section('footer')
    <script>


        @if (count($errors) > 0)

          $('#modalAddContactModal').modal('show');


        @endif



    </script>
    <script src="{{ asset('/plugins/chartjs/Chart.min.js') }}"></script>

    <script>

        $(function () {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            //--------------
            //- AREA CHART -
            //--------------

            // Get context with jQuery - using jQuery's .get() method.
            var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var areaChart = new Chart(areaChartCanvas);

            var areaChartData = {
                labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
                datasets: [
                    {
                        label: "Port Engineer",
                        fillColor: "rgba(210, 214, 222, 1)",
                        strokeColor: "rgba(210, 214, 222, 1)",
                        pointColor: "rgba(210, 214, 222, 1)",
                        pointStrokeColor: "#c1c7d1",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: [65, 59, 80, 81, 56, 55, 40,81, 56, 55, 40,32]
                    },
                    {
                        label: "Security",
                        fillColor: "rgba(60,141,188,0.9)",
                        strokeColor: "rgba(60,141,188,0.8)",
                        pointColor: "#3b8bba",
                        pointStrokeColor: "rgba(60,141,188,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        data: [65, 59, 80, 81, 56, 55, 40,81, 56, 55, 40,32]
                    },
                    {
                        label: "Real Estate",
                        fillColor: "rgba(60,141,188,0.9)",
                        strokeColor: "rgba(60,141,188,0.8)",
                        pointColor: "red",
                        pointStrokeColor: "rgba(60,141,188,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        data: [65, 59, 80, 81, 56, 55, 40,81, 56, 55, 40,32]
                    }
                    ,
                    {
                        label: "Gate Track",
                        fillColor: "rgba(60,141,188,0.9)",
                        strokeColor: "rgba(60,141,188,0.8)",
                        pointColor: "red",
                        pointStrokeColor: "rgba(60,141,188,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        data: [65, 59, 80, 81, 56, 55, 40,81, 56, 55, 40,32]
                    }
                ]
            };

            var areaChartOptions = {
                //Boolean - If we should show the scale at all
                showScale: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: false,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - Whether the line is curved between points
                bezierCurve: true,
                //Number - Tension of the bezier curve between points
                bezierCurveTension: 0.3,
                //Boolean - Whether to show a dot for each point
                pointDot: false,
                //Number - Radius of each point dot in pixels
                pointDotRadius: 4,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth: 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius: 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke: true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth: 2,
                //Boolean - Whether to fill the dataset with a color
                datasetFill: true,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions);

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas);
    var lineChartOptions = areaChartOptions;
    lineChartOptions.datasetFill = false;
    lineChart.Line(areaChartData, lineChartOptions);

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [
      /*{
        value: 550,
        color: "#f56954",
        highlight: "#f56954",
        label: ""
      },
      {
        value: 500,
        color: "#00a65a",
        highlight: "#00a65a",
        label: "IE"
      },*/
      {
        value: 4,
        color: "#f39c12",
        highlight: "#f39c12",
        label: "Port Engineer"
      },
      {
        value: 6,
        color: "#00c0ef",
        highlight: "#00c0ef",
        label: "Security"
      },
      {
        value: 3,
        color: "#3c8dbc",
        highlight: "#3c8dbc",
        label: "Real Estate"
      },
      {
        value: 1,
        color: "#d2d6de",
        highlight: "#d2d6de",
        label: "Gate Track"
      }
    ];
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[1].fillColor = "#00a65a";
    barChartData.datasets[1].strokeColor = "#00a65a";
    barChartData.datasets[1].pointColor = "#00a65a";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
  });
</script>
@endsection