@extends('master')

@section('content')

<!-- Breadcrumb -->
          <ol class="breadcrumb hidden-xs">
              <li><a href="#">Administration</a></li>
              <li><a href="{{ url('show_repository') }}"> Documents </a></li>
              <li class="active"> Documents Upload File </li>
          </ol>

             
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id='depTitle'> Uploading a File / Image </h4>
            </div>

            <div class="modal-body">
            {!! Form::open(['url' => 'saveDocumentfile', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"UpdateDocumentForm1","files" => true ]) !!}


             {!! Form::hidden('folder_id',$folder_id, ['id' => 'folder_id']) !!}
             {!! Form::hidden('folder_lavel',$folder_lavel, ['id' => 'folder_lavel']) !!}


            {!! Form::hidden('user_id',Auth::user()->id) !!}

            <div class="form-group">
                {!! Form::label('Parent', 'Parent', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                  {!! Form::text('Parent',$document->name,['class' => 'form-control input-sm','id' => 'name','readonly' => 'readonly']) !!}                 
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('File Name', 'File Name', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">

                    {!! Form::file('upload_doc') !!}   
                 
                  @if ($errors->has('upload_doc')) <p class="help-block red">*{{ $errors->first('upload_doc') }}</p> @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Description', 'Description', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                  {!! Form::text('description',NULL,['class' => 'form-control input-sm','id' => 'Description']) !!}
                  @if ($errors->has('description')) <p class="help-block red">*{{ $errors->first('description') }}</p> @endif
                </div>
            </div>  

            <div class="form-group">
                {!! Form::label('User Group', 'User Group', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                  {!! Form::select('group_id',$selectRoles1,0,['class' => 'form-control input-sm' ,'id' => 'group_id']) !!}
                  @if ($errors->has('group_id'))
                   <p class="help-block red">*{{ $errors->first('group_id') }}</p> 
                   @endif
              </div>
            </div>      

            <div class="form-group">
                {!! Form::label('Notes', 'Notes', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                  {!! Form::text('note',NULL,['class' => 'form-control input-sm','id' => 'document_note']) !!}
                  @if ($errors->has('note')) <p class="help-block red">*{{ $errors->first('note') }} </p> @endif
                </div>
            </div>              
         

             <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <button type="submit" id='submitUpdateDocumentForm1' type="button" class="btn btn-sm">Add File </button>

                    <button type="button" onclick="javascript:history.back();" type="button" class="btn btn-sm"> Back </button>

                </div>
             </div>

            </div>
            <div class="modal-footer">
              
            </div>

            {!! Form::close() !!}   

 

@endsection

@section('footer')

 <script>
  $(document).ready(function() {

    @if (count($errors) > 0)
          @if(Input::get ('docID'))
            $('#modalEditdocuments').modal('show');
          @else
            $('#modalAddDocument').modal('show');
          @endif      
    @endif


</script>

@endsection
