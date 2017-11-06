@extends('master')

@section('content')

<!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="{{ url('user-profile') }}">Profile</a></li>
    <li class="active">Edit Profile</li>
</ol>
<h4 class="page-title">{{ Auth::user()->name }} {{ Auth::user()->surname }}</h4>

<div class="container" style="margin-left: 10%; margin-right: 10%; margin-top: 3%;">


<div class="tile">
  <h2 class="tile-title">
      BASIC INFO            
  </h2>

  <div class="listview narrow">
      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">First Name</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->name }}">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Last Name</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->surname }}">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Preffered Language</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="English">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">ID Number</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->surname }}">
          </div>
      </div>
   </div>                     
</div>

<div class="tile">
  <h2 class="tile-title">
      CONTACT INFO         
  </h2>

  <div class="listview narrow">
      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Cell Number</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->cellphone }}">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Alternative Cell Number</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->alt_cellphone }}">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Email</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->email }}">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Alternative Email</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->alt_email }}">
          </div>
      </div>
   </div>                     
</div>

<div class="tile">
  <h2 class="tile-title">
      ADDRESS DETAILS           
  </h2>

  <div class="listview narrow">
      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Street Number</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value=" {{ Auth::user()->street_number }}">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Route</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->route }}">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Locality</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->locality }}">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Area</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->area }}">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Postal Code</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->postal_code }}">
          </div>
      </div>

      <div class="media p-l-5">
          <div class="media-body pull-left col-md-2">
            <a class="t-overflow" style="margin-top: 3px;">Country</a>
          </div>
          <div class="media-body pull-right col-md-4">
            <input type="text" class="form-control input-sm pull-right" value="{{ Auth::user()->country }}">
          </div>
      </div>
   </div>                     
</div>

<div class="form-group">
                <div class="col-md-offset-11 col-md-6 ">
                    <button type="submit" id='submitMemberForm' class="btn btn-info btn-sm m-t-10" style="padding-left: 10px;">SAVE</button>
                </div>
            </div>


<div>

<!-- Basic with panel
<div class="block-area" id="basic">
     
    <div class="tile p-15">
        {!! Form::open(['url' => 'users', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"registrationForm" ]) !!}

            <div class="form-group">
                {!! Form::label('User  Role', 'User Role', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::select('role',$selectRoles,0,['class' => 'form-control input-sm' ,'id' => 'role']) !!}
                  @if ($errors->has('role')) <p class="help-block red">*{{ $errors->first('role') }}</p> @endif
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('Title', 'Title', array('class' => 'col-md-2 control-label')) !!}
              <div class="col-md-6">
                {!! Form::select('title',$selectTitles,0,['class' => 'form-control' ,'id' => 'title']) !!}
                @if ($errors->has('title')) <p class="help-block red">*{{ $errors->first('title') }}</p> @endif
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('Gender', 'Gender', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                {!! Form::select('gender',['0' => 'Select/All','1' => 'Male','2' => 'Female'],0,['class' => 'form-control' ,'id' => 'gender']) !!}
                @if ($errors->has('gender')) <p class="help-block red">*{{ $errors->first('gender') }}</p> @endif
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('Preferred Language', 'Preferred Language', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                {!! Form::select('language',$selectLanguages,0,['class' => 'form-control' ,'id' => 'language']) !!}
                @if ($errors->has('language')) <p class="help-block red">*{{ $errors->first('language') }}</p> @endif
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('First Name', 'First Name', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::text('name',NULL,['class' => 'form-control input-sm','id' => 'name']) !!}
                  @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Surname', 'Surname', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::text('surname',NULL,['class' => 'form-control input-sm','id' => 'surname']) !!}
                  @if ($errors->has('surname')) <p class="help-block red">*{{ $errors->first('surname') }}</p> @endif
                </div>
            </div>




            <div class="form-group">
                {!! Form::label('ID No', 'ID No', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::text('id_number',NULL,['class' => 'form-control input-sm','id' => 'id_number'  ]) !!}
                  @if ($errors->has('id_number')) <p class="help-block red">* {{ $errors->first('id_number') }}</p> @endif
                </div>
            </div>
            <hr class="whiter m-t-20">
            <hr class="whiter m-b-20">

            <div class="form-group">
                {!! Form::label('Cell Number', 'Cell Number', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::text('cellphone',NULL,['class' => 'form-control input-sm','id' => 'cellphone' ,'placeholder'=> ' +27 612 11 000']) !!}
                  @if ($errors->has('cellphone')) <p class="help-block red">* {{ $errors->first('cellphone') }}</p> @endif
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('Alternative Cell Number', 'Alternative Cell Number', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::text('alt_cellphone',NULL,['class' => 'form-control input-sm','id' => 'alt_cellphone' ,'placeholder'=> ' +27 612 364 457']) !!}
                  @if ($errors->has('alt_cellphone')) <p class="help-block red">* {{ $errors->first('alt_cellphone') }}</p> @endif
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('Email', 'Email', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::text('email',NULL,['class' => 'form-control input-sm','email' ,'placeholder'=> '  infor@yahoo.net']) !!}
                  @if ($errors->has('email')) <p class="help-block red">* {{ $errors->first('email') }}</p> @endif
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('Alternative Email', 'Alternative Email', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::text('alt_email',NULL,['class' => 'form-control input-sm','alt_email']) !!}
                  @if ($errors->has('alt_email')) <p class="help-block red">* {{ $errors->first('alt_email') }}</p> @endif
              </div>
            </div>

            <hr class="whiter m-t-20">
            <hr class="whiter m-b-20">

            <div class="form-group">
              {!! Form::label('Enter Address', 'Enter Address', array('class' => 'col-md-2 control-label')) !!}
              <div class="col-md-6">
                {!! Form::text('autocomplete',NULL,['class' => 'form-control input-sm','id' => 'autocomplete', "onfocus"=>"geolocate()"]) !!}

              </div>
            </div>


            <div class="form-group">
              {!! Form::label('Street Number', 'Street Number', array('class' => 'col-md-2 control-label')) !!}
              <div class="col-md-6">
                {!! Form::text('street_number',NULL,['class' => 'street_number form-control input-sm','id' => 'street_number' , 'required']) !!}

              </div>
            </div>

            <div class="form-group">
              {!! Form::label('Route', 'Route', array('class' => 'col-md-2 control-label')) !!}
              <div class="col-md-6">
                {!! Form::text('route',NULL,['class' => 'route form-control input-sm','id' => 'route' , 'required']) !!}

              </div>
            </div>

            <div class="form-group">
              {!! Form::label('Locality', 'Locality', array('class' => 'col-md-2 control-label')) !!}
              <div class="col-md-6">
                {!! Form::text('locality',NULL,['class' => 'locality form-control input-sm','id' => 'locality' , 'required']) !!}

              </div>
            </div>

            <div class="form-group">
              {!! Form::label('Area', 'Area', array('class' => 'col-md-2 control-label')) !!}
              <div class="col-md-6">
                {!! Form::text('administrative_area_level_1',NULL,['class' => 'administrative_area_level_1 form-control input-sm','id' => 'administrative_area_level_1', 'required']) !!}

              </div>
            </div>

            <div class="form-group">
              {!! Form::label('Postal Code', 'Postal Code', array('class' => 'col-md-2 control-label' , 'required' )) !!}
              <div class="col-md-6">
                {!! Form::text('postal_code',NULL,['class' => 'postal_code form-control input-sm','id' => 'postal_code' , 'required']) !!}

              </div>
            </div>

             <div class="form-group">
              {!! Form::label('Country', 'Country', array('class' => 'col-md-2 control-label')) !!}
              <div class="col-md-6">
                {!! Form::text('country',NULL,['class' => 'country form-control input-sm','id' => 'country' , 'required']) !!}

              </div>
            </div>




            <hr class="whiter m-t-20">
            <hr class="whiter m-b-20">

            <div class="form-group">
                {!! Form::label('Company', 'Company', array('class' => 'col-md-2 control-label')) !!}
              <div class="col-md-6">
                {!! Form::text('company',NULL,['class' => 'company form-control input-sm','id' => 'company']) !!}
                  @if ($errors->has('company')) <p class="help-block red">*{{ $errors->first('company') }}</p> @endif
              </div>
            </div>


            <div class="form-group">
                {!! Form::label('Department', 'Department', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::select('department',$selectDepartments,0,['class' => 'form-control input-sm' ,'id' => 'department']) !!}
                  @if ($errors->has('department')) <p class="help-block red">*{{ $errors->first('department') }}</p> @endif
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('Position', 'Position', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::select('position',$selectPositions,0,['class' => 'form-control input-sm' ,'id' => 'position']) !!}
                  @if ($errors->has('position')) <p class="help-block red">*{{ $errors->first('position') }}</p> @endif
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('Association', 'Association', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::select('affiliation',$selectAffiliations,0,['class' => 'form-control input-sm' ,'id' => 'affiliation']) !!}
                  @if ($errors->has('affiliation')) <p class="help-block red">*{{ $errors->first('affiliation') }}</p> @endif
              </div>
            </div>


            <div class="form-group">
                <div class="col-md-offset-2 col-md-6">
                    <button type="submit" id='submitMemberForm' class="btn btn-info btn-sm m-t-10">SUBMIT FORM</button>
                </div>
            </div>

        {!! Form::close() !!}
    </div>
</div>-->

@endsection

@section('footer')
<script>
   $(document).ready(function() {

      $("#province").change(function(){

        $.get("{{ url('/api/dropdown/districts/province')}}",
        { option: $(this).val()},
        function(data) {
        $('#district').empty();
        $('#municipality').empty();
        $('#ward').empty();
        $('#district').removeAttr('disabled');
        $('#district').append("<option value='0'>Select one</option>");
        $('#municipality').append("<option value='0'>Select one</option>");
        $('#ward').append("<option value='0'>Select one</option>");
        $.each(data, function(key, element) {
        $('#district').append("<option value="+ key +">" + element + "</option>");
        });
        });

   })

    $("#district").change(function(){
        $.get("{{ url('/api/dropdown/municipalities/district')}}",
        { option: $(this).val() },
        function(data) {
        $('#municipality').empty();
        $('#municipality').removeAttr('disabled');
        $('#municipality').append("<option value='0'>Select one</option>");
        $.each(data, function(key, element) {
        $('#municipality').append("<option value="+ key +">" + element + "</option>");
        });
        });
    });

    $("#municipality").change(function(){
        $.get("{{ url('/api/dropdown/wards/municipality')}}",
        { option: $(this).val() },
        function(data) {
        $('#ward').empty();
        $('#ward').removeAttr('disabled');
        $('#ward').append("<option value='0'>Select one</option>");
        $.each(data, function(key, element) {
        $('#ward').append("<option value="+ key +">" + element + "</option>");
        });
        });
    });

  })

</script>
@endsection
