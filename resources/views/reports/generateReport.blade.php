@extends('master')

@section('content')
    <!-- Breadcrumb -->
    <ol class="breadcrumb hidden-xs">
        <li><a href="#">Administration</a></li>
        <li><a href="#">Reports</a></li>
        <li class="active">Reports</li>
    </ol>

    <h4 class="page-title">Reports</h4>
    <!-- Alternative -->
    <div class="block-area" id="alternative-buttons">


        <h3 class="block-title">FILTERS</h3>

        {!! Form::open(['url' => '/generateReport', 'method' => 'post', 'class' => 'form-horizontal']) !!}
        <div class="row">
            <div class="col-md-4 m-b-15">
                <p>From:</p>
                <div class="input-icon datetime-pick date-only">
                    <input data-format="yyyy-MM-dd" type="text" id='fromDate' name ='fromDate' class="form-control input-sm" />
                    <span class="add-on">
                  <i class="sa-plus"></i>
              </span>
                </div>
            </div>

            <div class="col-md-4 m-b-15">
                <p>To:</p>
                <div class="input-icon datetime-pick date-only">
                    <input data-format="yyyy-MM-dd" type="text" value ="" id='toDate' name ='toDate' class="form-control input-sm" />
                    <span class="add-on">
                  <i class="sa-plus"></i>
              </span>
                </div>
            </div>
        </div>
        <br/>

        <div class="row">

            <div class="col-md-4 m-b-15">
                <p>Companies:</p>
                <div class="p-relative">
                    <select class="form-control"  id="company" name="company">
                        <option selected disabled>Select Company</option>
                        @foreach($companies as $company)
                            <option id="{{$company->id}}" class="companyId">{{$company->name}}</option>
                        @endforeach
                    </select>
                    {{--{!! Form::select('company',$selectCompanies,0,['class' => 'form-control input-sm' ,'id' => 'companies']) !!}--}}
                </div>
            </div>

            <div class="col-md-4 m-b-15">
                <p>Business Units:</p>
                <div class="p-relative">
                    <select class="form-control"  id="department-list" name="department" style="height: 28px;">
                        <option selected disabled>Select Department</option>
                    </select>
                    {{--{!! Form::select('department',$selectDepartments,0,['class' => 'form-control input-sm' ,'id' => 'department']) !!}--}}
                </div>
            </div>
        </div>

        <br/>

        <div class="row">
            <div class="col-md-4 m-b-15">
                <p>Category:</p>
                <div class="p-relative">

                    <select class="form-control"  id="category_id" name="category">
                        <option selected disabled>Select Category</option>
                    </select>
                    {{--{!! Form::select('category',$selectCategories,0,['class' => 'form-control input-sm' ,'id' => 'category']) !!}--}}
                </div>
            </div>

            <div class="col-md-4 m-b-15">
                <p>Status:</p>

                <div>
                    {{--<select class="form-control"  id="status_id" name="status">--}}
                        {{--<option selected disabled>Select Status</option>--}}
                        @foreach($statuses as $status)
                            {{--<option id="{{$status->id}}">{{$status->name}}</option>--}}
                            {{$status->name}}<input type="checkbox" value="{{$status->id}}" id="{{$status->id}}" name="status[]"><br>
                        @endforeach
                    {{--</select>--}}

                </div>
            </div>

            <div class="col-md-4 m-b-15">

                <p>Overview Report:</p>
                <div>
                    No. of Cases <input type="checkbox" value="totalCases" id="" name="overviewReport[]"><br>
                    No. of Open & Close Case<input type="checkbox" value="openClose" id=""  name="overviewReport[]"><br>
                    Longest To close Case<input type="checkbox" value="longest" id=""  name="overviewReport[]"><br>
                    Shotest To close Case<input type="checkbox" value="shortest" id=""  name="overviewReport[]"><br>
                    Average To close Case<input type="checkbox" value="average" id=""  name="overviewReport[]"><br>
                </div>


            </div>





        </div>

        <br/>

        <br/>

        <div class="col-md-4 m-b-15">
            <p>Reporter:</p>
            <div class="p-relative">
                {!! Form::select('reporter',$selectCasesReporters,0,['class' => 'form-control input-sm' ,'id' =>'reporter ']) !!}
            </div>
        </div>


        <div class="row">

            <div class="col-md-4 m-b-15">
                <p>Type of Report:</p>
                <div class="p-relative">

                    <div class="bar-graph" >
                        <div id="label-f" style="background-color: inherit;  color: #ffffff; ">
                            Bar Graph
                        </div>
                        <div id="check-box">
                            <input type="checkbox" id="case-type" name="graph[]" value="bar" style="width: 100px">
                        </div>
                    </div>


                    <div class="line-graph">
                        <div id="label-f" style="background-color: inherit; color: #ffffff; ">
                            Line Graph
                        </div>
                        <div id="check-box">
                            <input type="checkbox" id="case-type" name="graph[]" value="line" style="width: 100px">
                        </div>
                    </div>


                    <div class="pie-chart">
                        <div id="label-f" style="background-color: inherit; color: #ffffff; ">
                            Pie Chart
                        </div>
                        <div id="check-box" style="background-color: inherit; ">
                            <input type="checkbox" id="case-type" name="graph[]" value="pie" style="width: 100px">
                        </div>
                    </div>

                    <div class="column-graph">
                        <div id="label-f" style="background-color: inherit; color: #ffffff; ">
                            Column Graph
                        </div>
                        <div id="check-box">
                            <input type="checkbox" id="case-type" name="graph[]" value="column" style="width: 100px">
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 m-b-15">
               <br/>
                <div class="p-relative">
                    <button type="submit" id="generate"  class="btn btn-sm">Generate Report</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>



    <!-- Responsive Table -->
    {{--<div class="block-area hidden" id="responsiveTable">--}}


        {{--<h3 class="block-title">Toggle columns</h3>--}}

        {{--<div>--}}
            {{--Toggle column:--}}
            {{--<a class="toggle-vis" data-column="0">ID</a>--}}
            {{-----}}
            {{--<a class="toggle-vis" data-column="1">Created At</a>--}}
            {{-----}}
            {{--<a class="toggle-vis" data-column="2">Description</a>--}}
            {{-----}}
            {{--<a class="toggle-vis" data-column="3">Business Unit</a>--}}
            {{-----}}
            {{--<a class="toggle-vis" data-column="4">Precinct</a>--}}
            {{-----}}
            {{--<a class="toggle-vis" data-column="5">Reporter</a>--}}
            {{-----}}
            {{--<a class="toggle-vis" data-column="6">Category</a>--}}
            {{-----}}
            {{--<a class="toggle-vis" data-column="7">Priority</a>--}}
            {{-----}}
            {{--<a class="toggle-vis" data-column="8">Severity</a>--}}
            {{-----}}
            {{--<a class="toggle-vis" data-column="9">Status</a>--}}
        {{--</div>--}}
        {{--<br/>--}}

        {{--<h3 class="block-title">Export options</h3>--}}

        {{--<div class="table-responsive overflow">--}}
            {{--<table class="table tile table-striped" id="reportsTable">--}}
                {{--<thead>--}}
                {{--<tr>--}}
                    {{--<th>Id</th>--}}
                    {{--<th>Created At</th>--}}
                    {{--<th>Description </th>--}}
                    {{--<th>Precinct</th>--}}
                    {{--<th>Business Unit</th>--}}
                    {{--<th>Reporter</th>--}}
                    {{--<th>Category</th>--}}
                    {{--<th>Priority</th>--}}
                    {{--<th>Severity</th>--}}
                    {{--<th>Status</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}

            {{--</table>--}}
        {{--</div>--}}

    {{--</div>--}}

    {{--<br/>--}}
    <!-- <div class="block-area">
      <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h2 class="tile-title">Pie Chart</h2>
                <div class="tile-config dropdown">
                    <a data-toggle="dropdown" href="" class="tooltips tile-menu" title="Options"></a>
                    <ul class="dropdown-menu pull-right text-right">
                        <li><a href="">Refresh</a></li>
                        <li><a href="">Settings</a></li>
                    </ul>
                </div>
                <div class="p-10">
                    <div id="pie-chart" class="main-chart" style="height: 300px"></div>
                </div>
            </div>
        </div>
      </div>
     </div>
     -->
@endsection

@section('footer')

    <script>
        $(document).ready(function()
        {
            var defaultDate = $.datepicker.formatDate('yy-mm-dd', new Date());
            $("#fromDate").val(defaultDate);
            $("#toDate").val(defaultDate);
            var oReportsTable;

        });

        $('#company').on('change',function()
        {
            var companyName = this.value;
            $('#department-list').empty();
            $.get('companyDept/'+ companyName,function(response)
            {
                $('#department-list').append("<option  selected disabled>Select Department</option>");
                $.each(response,function(key,value)
                {
                    $('#department-list').append("<option id ="+value.id+">"+ value.name +"</option>");
                });
            });

        });
        $('#department-list').on('change', function () {
            var dptName = this.value;
            console.log(dptName);
            $('#category_id').empty();
            $.get('deprtCategories/' + dptName, function (response) {
                $('#category_id').append("<option  selected disabled>Select Category</option>");
                $.each(response, function (key, value) {
                    $('#category_id').append("<option  id=" + value.id + ">" + value.name + "</option>");
                });
            });
        });

        $('#label-f').click(function() {
            var sel = $('input[type=checkbox]:checked').map(function(_, el) {
                return $(el).val();
            }).get();

        });

        $('#overviewReport').click(function() {
            var sel = $('input[type=checkbox]:checked').map(function(_, el) {
                return $(el).val();
            }).get();

        });

        $('#status').click(function() {
            var sel = $('input[type=checkbox]:checked').map(function(_, el) {
                return $(el).val();
            }).get();

        })


    </script>

@endsection
