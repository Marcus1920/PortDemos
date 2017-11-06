@extends('master')

@section('content')


<!-- Modal Default -->



            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="col-md-12">

                        @if($user)


                {!! Form::open(['url' => 'updateUser', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"updateUserForm" ]) !!}
                {!! Form::hidden('userID',NULL,['id' => 'userID']) !!}
                {!! Form::hidden('id',Auth::user()->id) !!}
                <div class="form-group">
                    {!! Form::label('User Type', 'User Type', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('role',['0'=> $user->role ,'1' => $selectRoles],1,['class' => 'form-control input-sm' ,'id' => 'role']) !!}
                        @if ($errors->has('role')) <p class="help-block red">*{{ $errors->first('role') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('User Status', 'User Status', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('status',['0' => $user->active  , '1' => $selectUserStatuses],1,['class' => 'form-control input-sm' ,'id' => 'status']) !!}
                        @if ($errors->has('status')) <p class="help-block red">*{{ $errors->first('status') }}</p> @endif
                    </div>
                </div>



                <div class="form-group">
                    {!! Form::label('Title', 'Title', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('title',['0' => $user->title ,'Mr' => 'Mr','Mrs' => 'Mrs','Miss' => 'Miss','Ms' => 'Ms'],0,['class' => 'form-control' ,'id' => 'title']) !!}
                        @if ($errors->has('title')) <p class="help-block red">*{{ $errors->first('title') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Gender', 'Gender', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('gender',['0' => $user->gender ,'1' => 'Male','2' => 'Female'],0,['class' => 'form-control' ,'id' => 'gender']) !!}
                        @if ($errors->has('gender')) <p class="help-block red">*{{ $errors->first('gender') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Date of Birth', 'Date of Birth', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        <div class="input-icon datetime-pick date-only">
                            <input data-format="yyyy-MM-dd" type="text" id='dob' value="{{$user->dob}}" name ='dob' class="form-control input-sm" />
                            <span class="add-on">
                      <i class="sa-plus"></i>
                  </span>
                        </div>
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

                        {!! Form::text('name',$user-> name ,['class' => 'form-control input-sm','id' => 'name']) !!}
                        @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                    </div>
                </div>

                             {{--<h1>  {{$user->id}}</h1>--}}
                <div class="form-group">
                    {!! Form::label('Surname', 'Surname', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('surname',$user-> surname,['class' => 'form-control input-sm','id' => 'surname']) !!}
                        @if ($errors->has('surname')) <p class="help-block red">*{{ $errors->first('surname') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('ID No /Passport No', 'ID No /Passport No', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('id_number',$user-> id_number,['class' => 'form-control input-sm','id' => 'id_number']) !!}
                        @if ($errors->has('id_number')) <p class="help-block red">*{{ $errors->first('id_number') }}</p> @endif
                    </div>
                </div>

               <br>  <br>

                <div class="form-group">
                    {!! Form::label('Cell Number', 'Cell Number', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('cellphone',$user-> cellphone,['class' => 'form-control input-sm','id' => 'cellphone','disabled']) !!}
                        @if ($errors->has('Cellphone')) <p class="help-block red">*{{ $errors->first('Cellphone') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Alternative Cell Number', 'Alternative Cell Number', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('alt_cellphone',$user-> alt_cellphone,['class' => 'form-control input-sm','id' => 'alt_cellphone']) !!}
                        @if ($errors->has('alt_cellphone')) <p class="help-block red">*{{ $errors->first('alt_cellphone') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Email', 'Email', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('email',$user-> email,['class' => 'form-control input-sm','id' => 'email','disabled']) !!}
                        @if ($errors->has('email')) <p class="help-block red">*{{ $errors->first('email') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Alternative Email', 'Alternative Email', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('alt_email',$user-> alt_email,['class' => 'form-control input-sm','id' => 'alt_email']) !!}
                        @if ($errors->has('alt_email')) <p class="help-block red">*{{ $errors->first('alt_email') }}</p> @endif
                    </div>
                </div>

                        <br>  <br>


                <div class="form-group">
                    {!! Form::label('Province', 'Province', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('province',$selectProvinces,0,['class' => 'form-control' ,'id' => 'province']) !!}
                        @if ($errors->has('province')) <p class="help-block red">*{{ $errors->first('province') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('District', 'District', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('district',['0' => 'dsfs','1' => $selectDistricts],1,['class' => 'form-control input-sm' ,'id' => 'district']) !!}
                        @if ($errors->has('district')) <p class="help-block red">*{{ $errors->first('district') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Municipality', 'Municipality', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('municipality',$selectMunicipalities,0,['class' => 'form-control input-sm' ,'name' => 'municipality','id' => 'municipality']) !!}
                        @if ($errors->has('municipality')) <p class="help-block red">*{{ $errors->first('municipality') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Ward', 'Ward', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('ward',$selectWards,0,['class' => 'form-control input-sm' ,'name' => 'ward','id' => 'ward']) !!}
                        @if ($errors->has('ward')) <p class="help-block red">*{{ $errors->first('ward') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Area', 'Area', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('area',NULL,['class' => 'form-control input-sm','id' => 'area']) !!}
                        @if ($errors->has('area')) <p class="help-block red">*{{ $errors->first('area') }}</p> @endif
                    </div>
                </div>

                        <br>  <br>

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
                    {!! Form::label('Affiliation', 'Affiliation', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('affiliation',$selectAffiliations,0,['class' => 'form-control input-sm' ,'id' => 'affiliation']) !!}
                        @if ($errors->has('affiliation')) <p class="help-block red">*{{ $errors->first('affiliation') }}</p> @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <button type="submit" id='submitUpdateUserForm' type="button" class="btn btn-sm">Save Changes</button>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}

                    @endif
        </div>
    </div>
</div>


@endsection