@extends('master')

@section('content')


    {{--<header>--}}
        {{--<a class="logo pull-left" href="#">--}}
            {{--<img class="" src="{{ asset('/images/dashboard_logo.png') }}" width="60%" alt="">--}}
        {{--</a>--}}
    {{--</header>--}}
    <body>



    {{--<div class="topnav" id="myTopnav">--}}
        {{--<a href="#home">Home</a>--}}
        {{--<a href="#news">News</a>--}}
        {{--<a href="#contact">Contact</a>--}}
        {{--<a href="#about">About</a>--}}
    {{--</div>--}}

    {!! Charts::assets() !!}



    <!-- Main content -->
    <section class="content">
        <div class="row" >
            <div class="col-md-1" >
            </div>
            <div class="col-md-5" >
                <!-- AREA CHART -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Bar Chart</h3>
                        <hr class="whiter m-b-20">
                    </div>
                    <div class="box-body chart-responsive">
                      {!! $chart->render() !!}
                        {{--<div class="chart" id="revenue-chart" style="height: 300px;"></div>--}}

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
				<strong>Export </strong><a href="#">CSV</a> <a href="#">Excel</a> <a href="#">PDF</a>
                <!-- DONUT CHART -->


            </div><!-- /.col (LEFT) -->
            <div class="col-md-5">
                <!-- LINE CHART -->
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Pie Chart</h3>
                        <hr class="whiter m-b-20">
                    </div>
                    <div class="box-body chart-responsive">
                       {!! $charts->render() !!}
                        {{--<div class="chart" id="line-chart" style="height: 300px;"></div>--}}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
				<strong>Export </strong><a href="#">CSV</a> <a href="#">Excel</a> <a href="#">PDF</a>
                <!-- BAR CHART -->


            </div><!-- /.col (RIGHT) -->
            <div class="col-md-1" >
            </div>
        </div><!-- /.row -->
        <div class="row" >
            <div class="col-md-1" >
            </div>
            <div class="col-md-5" >
                <!-- AREA CHART -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Bar Chart</h3>
                        <hr class="whiter m-b-20">
                    </div>
                    <div class="box-body chart-responsive">
                        {!! $chartssz->render() !!}
                        {{--<div class="chart" id="revenue-chart" style="height: 300px;"></div>--}}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
				<strong>Export </strong><a href="#">CSV</a> <a href="#">Excel</a> <a href="#">PDF</a>
                <!-- DONUT CHART -->


            </div><!-- /.col (LEFT) -->
            <div class="col-md-5">
                <!-- LINE CHART -->
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Line Chart</h3>
                        <hr class="whiter m-b-20">
                    </div>
                    <div class="box-body chart-responsive">
                        {!! $chartss->render() !!}
                        {{--<div class="chart" id="line-chart" style="height: 300px;"></div>--}}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
				<strong>Export </strong><a href="#">CSV</a> <a href="#">Excel</a> <a href="#">PDF</a>
                <!-- BAR CHART -->


            </div><!-- /.col (RIGHT) -->
            <div class="col-md-1" >
            </div>
        </div><!-- /.row -->


    </section><!-- /.content -->



        <center>

        </center>

        <center>

        </center>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js" charset="utf-8"></script>
    </body>





@endsection
