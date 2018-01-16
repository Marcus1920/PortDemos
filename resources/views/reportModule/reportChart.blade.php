@extends('master')

@section('content')
{!! Charts::assets() !!}
<section class="content">

	<div class="row" >
		<div class="col-md-1" >
		</div>
		<div class="col-md-5" >
			<!-- AREA CHART -->
			<a>
				<div class="box box-primary">
					<div class="box-header">
						<hr class="whiter m-b-20">
					</div>
					@if(!empty($bar_chart))
						<div class="box-body chart-responsive">
							{!! $bar_chart->render() !!}
						</div>
				@endif<!-- /.box-body -->
				</div><!-- /.box -->
			</a>
			<strong> </strong>



		</div>
		<div class="col-md-5">
			<a>
				<div class="box box-info">
					<div class="box-header">
						<hr class="whiter m-b-20">
					</div>
					@if(!empty($line_chart))
						<div class="box-body chart-responsive ">
							{!! $line_chart->render() !!}
						</div>
				@endif
				</div>

			</a>
			<strong></strong>



		</div>
		<div class="col-md-1" >
		</div>
	</div>
	<br/><br/><br/>
	<div class="row" >
		<div class="col-md-3" >
		</div>
		<div class="col-md-6" >

			<a>
				<div class="box box-primary">
					<div class="box-header">

					</div>
					@if(!empty($pie_chart))
						<div class="box-body chart-responsive">
							{!!$pie_chart->render()!!}
						</div>
					@endif
				</div>
			</a>
			<strong> </strong>



		</div>
		<div class="col-md-3" >
		</div>
	</div>
</section>

@endsection