@extends('master')

@section('content')
{!! Charts::assets() !!}
<div style=" width: 100%;height: 50%;">
	@if($bar_chart)
	     <div style="width: 50%; float: left;height: 80%;margin-bottom: 10px;">
		     {!! $bar_chart->render() !!}
	    </div>
	@endif
	@if($line_chart)
	     <div style="width: 50%; float: right;height: 80%;margin-bottom: 10px;">
		     {!! $line_chart->render() !!}
	    </div>
	@endif

</div>
<div style=" width: 100%;">
	@if($pie_chart)
	     <div style="width: 50%; float: left;margin-bottom: 10px;">
		     {!! $pie_chart->render() !!}
	    </div>
	@endif
</div>
@endsection