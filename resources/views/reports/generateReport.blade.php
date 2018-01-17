@extends('master')

@section('content')


    <ol class="breadcrumb hidden-xs">
        <li><a href="{{'home'}}">Home</a></li>
        <li class="active">Reports</li>
    </ol>

    <h4 class="page-title">Reports</h4>
    <!-- Alternative -->
    <div class="block-area" id="report">


        <h3 class="block-title">FILTERS</h3>

        {!! Form::open(['url' => '/generateReport', 'method' => 'post', 'class' => 'form-horizontal' ,'id'=>'reportId'  ,'v-on:submit'=>"validateForm"]) !!}
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <p>From:</p>
                <div class="input-icon datetime-pick date-only">
                    <input   data-format="yyyy-MM-dd" type="text" id='fromDate' name ='fromDate' class="form-control input-sm"/>
                    <span class="add-on">
                  <i class="sa-plus"></i>
              </span>
                </div>

            </div>

            <div class="col-md-4">
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

            <div class="col-md-4 col-md-offset-2">
                <p>Companies:</p>
                <div class="p-relative">

                    <select class="form-control"  id="company" name="company" v-model="company">
                        <option selected disabled>Select Company</option>
                        @foreach($companies as $company)
                            <option id="{{$company->id}}" class="companyId">{{$company->name}}</option>
                        @endforeach
                    </select>

                    <span class="help-block" v-cloak v-if="submition && wrongCompany" style="color:red;">@{{companyFB}}</span>
                </div>
            </div>

            <div class="col-md-4">
                <p>Business Units:</p>
                <div class="p-relative">
                    <select class="form-control"  id="department-list" name="department" style="height: 28px;" v-model="department">
                        <option selected disabled style="display: inherit">Select Department</option>
                    </select>
                    <span class="help-block" v-cloak v-if="submition && wrongDepartment" style="color:red;">@{{departmentFB }}</span>
                </div>
            </div>
        </div>

        <br/>

        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <p>Category:</p>
                <div class="p-relative">

                    <select class="form-control"  id="category_id" name="category" v-model="category">
                        <option selected disabled>Select Category</option>
                    </select>
                    <span class="help-block" v-cloak v-if="submition && wrongCategory" style="color:red;">@{{categoryFB}}</span>
                </div>
            </div>

            <div class="col-md-4">
                <p>Reporter:</p>
                <div class="p-relative">
                    {!! Form::select('reporter',$selectCasesReporters,0,['class' => 'form-control input-sm' ,'id' =>'reporter ' ,'v-model'=>'reporter']) !!}
                    <span class="help-block" v-cloak v-if="submition && wrongReporter" style="color:red;">@{{reporterFB}}</span>
                </div>
            </div>

        </div>

        <br/>

        <div clas="row">
            <div class="col-md-4 col-md-offset-2">

                <p>Overview Report:</p>
                <div>
                    <input type="radio" name="overviewReport" value="totalCases" checked> No. of Cases <br>
                    <input type="radio" name="overviewReport" value="openClose"> No. of Open & Close Case<br>
                    <input type="radio" name="overviewReport" value="longest"> Longest To close Case<br>
                    <input type="radio" name="overviewReport" value="shortest"> Shortest To close Case<br>
                    <input type="radio" name="overviewReport" value="average"> Average To close Case<br>
                </div>


            </div>

            <div class="col-md-4">
                <p>Status:</p>
                <div>
                    @foreach($statuses as $status)
                        {{$status->name}}<input type="checkbox" value="{{$status->id}}" id="{{$status->id}}" name="statuses[]"><br>
                    @endforeach
                </div>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <p>Type of Report:</p>
                <div >
                    <input type="checkbox"  value="bar"    v-model="graph" >Bar Graph<br>
                    <input type="checkbox"  value="line"   v-model="graph">Line Graph<br>
                    <input type="checkbox"  value="pie"    v-model="graph">Pie Chart<br>
                </div>
                <span v-cloak>@{{graph }}</span>
                <span v-cloak>@{{graphTypes }}</span>
                {{--<span class="help-block" v-cloak v-if="submition && wrongGraph" style="color:red;">@{{graphFB }}</span>--}}
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-6">
                <br/>
                <div class="p-relative">
                    <button type="submit" id="generate"  class="btn btn-sm">Generate Report</button>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

@endsection

@section('footer')
    <script  src="{{asset('js/reportsValidation.js')}}" ></script>
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
            var sel = $('input[type=radio]:checked')
            (function(_, el) {
                return $(el).val();
            }).get();

        });

        $('#statuses').click(function() {
            var sel = $('input[type=checkbox]:checked').map(function(_, el) {
                return $(el).val();
            }).get();

        });

    </script>

@endsection
