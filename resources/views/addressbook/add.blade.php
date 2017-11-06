<!-- Modal Default -->
@extends('master')

@section('content')
    <div class="block-area" id="basic">
        <!-- Breadcrumb -->
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('addressbookList') }}">Address Book</a></li>
            <li class="active">Add New Contact</li>
        </ol>

        <h4 class="page-title">ADD A NEW CONTACT </h4>

        <br>
        <div class="tile p-15">
              {!! Form::open(['url' => 'addContact', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"AddNewContactForm"]) !!}
              {!! Form::hidden('uid',Auth::user()->id,['id' => 'uid']) !!}

              <div class="form-group">
                  {!! Form::label('First Name', 'First Name', array('class' => 'col-md-4 control-label')) !!}
                  <div class="col-md-5">
                    {!! Form::text('FirstName',NULL,['class' => 'form-control input-sm','id' => 'FirstName']) !!}
                      @if ($errors->has('FirstName')) <p class="help-block red">*{{ $errors->first('FirstName') }}</p> @endif
                    <div id='error_firstname'></div>
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('Surname', 'Surname', array('class' => 'col-md-4 control-label')) !!}
                  <div class="col-md-5">
                    {!! Form::text('Surname',NULL,['class' => 'form-control input-sm','id' => 'Surname']) !!}
                      @if ($errors->has('Surname')) <p class="help-block red">*{{ $errors->first('Surname') }}</p> @endif
                   <div id='error_surname'></div>
                  </div>
              </div>
               <div class="form-group">
                  {!! Form::label('Email Address', 'Email Address', array('class' => 'col-md-4 control-label')) !!}
                  <div class="col-md-5">
                    {!! Form::text('email',NULL,['class' => 'form-control input-sm','id' => 'email']) !!}
                      @if ($errors->has('email')) <p class="help-block red">*{{ $errors->first('email') }}</p> @endif
                    <div id='error_email'></div>
                  </div>
              </div>
              <div class="form-group">
                  {!! Form::label('Cellphone', 'Cellphone', array('class' => 'col-md-4 control-label')) !!}
                  <div class="col-md-5">
                    {!! Form::text('cellphone',NULL,['class' => 'form-control input-sm','id' => 'cellphone']) !!}
                      @if ($errors->has('cellphone')) <p class="help-block red">*{{ $errors->first('cellphone') }}</p> @endif
                    <div id='error_cellphone'></div>
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('Relationship', 'Relationship', array('class' => 'col-md-4 control-label')) !!}
                  <div class="col-md-5">
                    {!! Form::select('relationship',$selectRelationships,0,['class' => 'form-control input-sm' ,'id' => 'relationship']) !!}
                    @if ($errors->has('relationship')) <p class="help-block red">*{{ $errors->first('relationship') }}</p> @endif
                </div>
              </div>


              <div class="form-group">
                  <div class="col-md-offset-4 col-md-6">
                      <button type="submit" id='submitAddContactForm' class="btn btn-sm">Add Contact</button>
                  </div>
              </div>
              {!! Form::close() !!}
        </div>
    </div>
@endsection