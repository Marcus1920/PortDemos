@extends('master')

@section('content')
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    var count =0;
    var array = new Array();
    var m = 0;
    
    function increment()
    {
      count +=1;
    } 
    //validating date
    $(document).ready(function(){
      $("#datepicker-8").datepicker({
          maxDate :-0
        });
        $("#datepicker-9").datepicker({
          maxDate :-0
        });
    });
    // Dealing with the date calender
    $(function() 
    {
            $( "#datepicker-8" ).datepicker({
               prevText:"click for previous months",
               nextText:"click for next months",
               showOtherMonths:true,
               selectOtherMonths: false
            });
            $( "#datepicker-9" ).datepicker({
               prevText:"click for previous months",
               nextText:"click for next months",
               showOtherMonths:true,
               selectOtherMonths: true
            });
    });
  </script>

<ol class="breadcrumb hidden-xs">
    <li><a href="#">Administration</a></li>
    <li  class="active"><a href="#">Reports</a></li>
    <li>Reports</li>
</ol>

<h4 class="page-title">Reports</h4>
<div class="block-area" id="alternative-buttons">
<h3 class="block-title">GENERATE THE REPORT</h3>
</div>

<div class="row">

	<div class="col-md-6" >


		<form>
			 <div class="form-group" style="margin-bottom: 20px;">

			   <div  class ="date-div {{ $errors->has('start') ? 'has-error': '' }}"  >
			 	<div class =" date-label">
                 <p>From Date:</p>
               </div>

               <div class="col-md-3 date-input">
                 <p><input type = "text"  name="start" placeholder ="Choose A Date" id = "datepicker-8"></p>
                 {!! $errors->first('start', '<span class="help-block" style="background-color: black; width:60%;"><b>:message</b></span>') !!}
               </div>
           </div>


          <div class="date-div {{ $errors->has('start') ? 'has-error': '' }}">
	           <div class="date-label">
	             <p>To Date:</p>
	           </div>
	           <div class="col-md-3 date-input">
	             <p> <input type = "text" name="end" placeholder ="Pick A Date" id = "datepicker-9"></p>
	               {!! $errors->first('end', '<span class="help-block" style="background-color: linen; width:60%;"><b>:message</b></span>') !!}
	           </div>
         </div>

			 </div>


			 <div class="form-group">
                {!! Form::label('Select Drone', 'Select Drone', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-4">
                    {!! Form::select('id',$optsCompanies,"",['class' => 'form-control validate[required]','id' => 'company', old('drone_type_id')]) !!}
                    @if ($errors->has('drone_type_id')) <p class="help-block red">*{{ $errors->first('drone_type_id') }}</p> @endif
                </div>

            </div>


            <div class="form-group">
                {!! Form::label('Select Drone Services', 'department', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-4">
            
                    <select class="form-control" id="department" name="department" 
                        <option selected>Nothing selected</option>
                    </select>
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('Select Drone Services', 'Category', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-4">
            
                    <select class="form-control" id="categories" name="categories" 
                        <option selected>Nothing selected</option>
                    </select>
                </div>
            </div>


		</form>
	</div>

	<div class="col-md-6">
	</div>

	<div  class="col-md-4">
	</div>

</div>


@stop
@section('footer')
    <script>
        $('#company').on('change',function()
        {
        
            var id = this.value;
            $('#department').empty();
         
            $.get('companyDept/'+ id,function(response){
                $('#department').append("<option  selected>Select department</option>");
                $.each(response,function(key,value)
                {
            
                    $('#department').append("<option  value="+value.id+">"+value.name+"</option>");
                });


            });
        });

        $('#department').on('change',function()
        {
        
            var id = this.value;
            $('#categories').empty();
         
            $.get('deprtCategories/'+ id,function(response){
                $('#categories').append("<option  selected>Select Category</option>");
                $.each(response,function(key,value)
                {
                  alert(value.name);
                    $('#categories').append("<option  value="+value.id+">"+value.name+"</option>");
                });


            });
        });
 
    </script>
@endsection