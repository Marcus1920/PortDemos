@extends('master')

@section('content')


{!! Charts::assets() !!}


<!-- Main content -->
<section class="content">
    <div class="row" >
        <div class="col-md-1" >
        </div>
        <div class="col-md-5" >
            <!-- AREA CHART -->
            <a href="{{url('allocatedCases')}}">
            <div class="box box-primary">
                <div class="box-header">
                    <hr class="whiter m-b-20">
                </div>
                <div class="box-body chart-responsive">
                    {!! $chart->render() !!}


                </div><!-- /.box-body -->
            </div><!-- /.box -->
            </a>
			<strong>Export </strong><a href="#">CSV</a> <a href="#">Excel</a> <a href="#">PDF</a>
            <!-- DONUT CHART -->


        </div><!-- /.col (LEFT) -->
        <div class="col-md-5">
            <!-- LINE CHART -->
            <a href="{{url('tasks')}}">
            <div class="box box-info">
                <div class="box-header">
                    <hr class="whiter m-b-20">
                </div>
                <div class="box-body chart-responsive ">
                    {!! $chartTasks->render() !!}

                </div><!-- /.box-body -->
            </div>

            </a><!-- /.box -->
			<strong>Export </strong><a href="#">CSV</a> <a href="#">Excel</a> <a href="#">PDF</a>
            <!-- BAR CHART -->


        </div><!-- /.col (RIGHT) -->
        <div class="col-md-1" >
        </div>
    </div><!-- /.row -->
    <div class="row" >
        <div class="col-md-1" >
        </div>

        <div class="col-md-10" style="text-align: center">
            <a href="{{url('maps')}}">

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">&nbsp;</h3>
                    <!--<hr class="whiter m-b-20">-->
                </div>
                <div class="box-body chart-responsive">
                    <img style="width: 100%" src="https://maps.googleapis.com/maps/api/staticmap?center=Durban+Port,South+Africa&zoom=13&size=600x400&maptype=roadmap&markers=color:blue&key=AIzaSyAVXK8rT6sSD_sL2ENnIYKaphpWdl5BjW4" />
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <!-- DONUT CHART   -->
            </a>

        </div><!-- /.col (LEFT) -->

        <div class="col-md-5" style="display: none">
            <a href="{{url('closedCases')}}">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Resolve  Cases</h3>
                    <hr class="whiter m-b-20">
                </div>
                <div class="box-body chart-responsive">
                    {!! $chartss->render() !!}

                </div><!-- /.box-body -->
            </div><!-- /.box -->
            </a>
			<strong>Export </strong><a href="#">CSV</a> <a href="#">Excel</a> <a href="#">PDF</a>
            <!-- BAR CHART -->


        </div><!-- /.col (RIGHT) -->
        <div class="col-md-1" >
        </div>
    </div><!-- /.row -->


</section><!-- /.content -->


<script src="bower_components/bootstrap/dist/js/bootstrap.min.js" charset="utf-8"></script>
</body>





@endsection
