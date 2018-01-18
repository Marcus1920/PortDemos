@extends('master')

@section('content')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        function increment()
        {
            count +=1;
        }

        $(document).ready(function(){
            $("#datepicker-Fromdate").datepicker({
                maxDate :-0,
                dateFormat: 'yy-mm-dd'
            });
            $("#datepicker-Todate").datepicker({
                maxDate :-0,
                dateFormat: 'yy-mm-dd'
            });
        });

        $(function()
        {
            $( "#datepicker-Fromdate" ).datepicker({
                prevText:"click for previous months",
                nextText:"click for next months",
                showOtherMonths:true,
                selectOtherMonths: false

            });
            $( "#datepicker-Todate" ).datepicker({
                prevText:"click for previous months",
                nextText:"click for next months",
                showOtherMonths:true,
                selectOtherMonths: true

            });
        });
    </script>

    <ol class="breadcrumb hidden-xs">
        <li><a href="{{'home'}}">Home</a></li>
        <li class="active">Reports</li>
    </ol>

    <h4 class="page-title">Reports</h4>
    <!-- Alternative -->
    <div class="block-area" id="report">


        <h3 class="block-title">FILTERS</h3>

        {!! Form::open(['url' => '/generateReport', 'method' => 'post', 'class' => 'form-horizontal' ,'id'=>'reportId']) !!}
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <p>From:</p>
                {{--<div class="input-icon datetime-pick date-only">--}}
                    {{--<input   data-format="yyyy-MM-dd" type="text" id='fromDate' name ='fromDate' class="form-control input-sm"/>--}}
                    {{--<span class="add-on">--}}
                  {{--<i class="sa-plus"></i>--}}
              {{--</span>--}}
                   {{----}}
                {{--</div>--}}

                <div class="date-input">
                    <p><input type = "text"   data-format="yyyy-MM-dd"  name="fromDate" placeholder ="Choose start date" id = "datepicker-Fromdate" class="form-control input-sm"></p>
                    @if ($errors->has('fromDate')) <p class="help-block red">*{{ $errors->first('fromDate') }}</p> @endif
                </div>

            </div>

            <div class="col-md-4">
                <p>To:</p>
                {{--<div class="input-icon datetime-pick date-only">--}}
                    {{--<input data-format="yyyy-MM-dd" type="text" value ="" id='toDate' name ='toDate' class="form-control input-sm" />--}}
                    {{--<span class="add-on">--}}
                  {{--<i class="sa-plus"></i>--}}
              {{--</span>--}}

                {{--</div>--}}

                <div class="date-input">
                    <p><input type = "text"    data-format="yyyy-MM-dd"  name="toDate" placeholder ="Choose an end date" id = "datepicker-Todate" class="form-control input-sm"></p>
                    @if ($errors->has('toDate')) <p class="help-block red">*{{ $errors->first('toDate') }}</p> @endif
                </div>


            </div>
        </div>

        <br/>

        <div class="row">

            <div class="col-md-4 col-md-offset-2">
                <p>Companies:</p>
                <div class="p-relative">

                    <select class="form-control"  id="company" name="company" >
                        <option selected disabled>Select Company</option>
                        @foreach($companies as $company)
                            <option id="{{$company->id}}" class="companyId">{{$company->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('company')) <p class="help-block red">*{{ $errors->first('company') }}</p> @endif
                </div>
            </div>

            <div class="col-md-4">
                <p>Business Units:</p>
                <div class="p-relative">
                    <select class="form-control"  id="department-list" name="department" style="height: 28px;">
                        <option selected disabled style="display: inherit">Select Department</option>
                    </select>
                    @if ($errors->has('department')) <p class="help-block red">*{{ $errors->first('department') }}</p> @endif
                </div>
            </div>
        </div>

        <br/>

        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <p>Category:</p>
                <div class="p-relative">

                    <select class="form-control"  id="category_id" name="category" >
                        <option selected disabled>Select Category</option>
                    </select>
                    @if ($errors->has('category')) <p class="help-block red">*{{ $errors->first('category') }}</p> @endif
                </div>
            </div>

            <div class="col-md-4">
                <p>Reporter:</p>
                <div class="p-relative">
                    <select class="form-control"  id="reporter" name="reporter">
                        <option selected disabled>Select Reporter</option>
                        @foreach($reporters as $reporter)
                            <option id="{{$reporter->id}}">{{$reporter->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('reporter')) <p class="help-block red">*{{ $errors->first('reporter') }}</p> @endif

                </div>
            </div>

        </div>

        <br/>

        <div clas="row">
            <div class="col-md-3 col-md-offset-2">

                <p>Overview Report:</p>
                <div>
                    <input type="radio" name="overviewReport" value="totalCases" checked> No. of Cases <br>
                    <input type="radio" name="overviewReport" value="openClose"> No. of Open & Close Case<br>
                    <input type="radio" name="overviewReport" value="longest"> Longest To close Case<br>
                    <input type="radio" name="overviewReport" value="shortest"> Shortest To close Case<br>
                    <input type="radio" name="overviewReport" value="average"> Average To close Case<br>
                </div>


            </div>

            <div class="col-md-3">
                <p>Status:</p>
                <div>
                    <input type="radio" name="statuses" value="totalCases" checked>Statuses<br>
                    {{--@foreach($statuses as $status)--}}
                        {{--{{$status->name}}<input type="checkbox" value="{{$status->id}}" id="{{$status->id}}" name="statuses[]"><br>--}}
                    {{--@endforeach--}}

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <p>Report Graphs:</p>
            <div id="graph" >

                <input type="checkbox"  value="bar"  name="graphs[]" >Bar Graph<br>
                <input type="checkbox"  value="line"   name="graphs[]"  >Line Graph<br>
                <input type="checkbox"  value="pie"   name="graphs[]" >Pie Chart<br>
            </div>
            @if ($errors->has('graphs')) <p class="help-block red">*{{ $errors->first('graphs') }}</p> @endif

        </div>

        <br/>

        <div class="row">
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-2">
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

        $('#graph').click(function() {
            var sel = $('input[type=checkbox]:checked').map(function(_, el) {
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
