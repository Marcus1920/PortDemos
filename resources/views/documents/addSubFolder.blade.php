@extends('master')

@section('content')

<!-- Breadcrumb -->
          <ol class="breadcrumb hidden-xs">
              <li><a href="#">Administration</a></li>
              <li><a href="{{ url('show_repository') }}"> Documents </a></li>
              <li class="active"> Add Sub Folder  </li>
          </ol>

             
         
            <div class="modal-header">               
                <h4 class="modal-title" id='depTitle'> Add Sub Folder </h4>
            </div>


            <div class="modal-body">
            {!! Form::open(['url' => 'addDocument', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"UpdateDocumentForm" ]) !!}
            
         
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
                {!! Form::label('Name', 'Name', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                  {!! Form::text('name',NULL,['class' => 'form-control input-sm','id' => 'name']) !!}
                  @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Description', 'Description', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                  {!! Form::text('description',NULL,['class' => 'form-control input-sm','id' => 'Description']) !!}
                  @if ($errors->has('description')) <p class="help-block red">*{{ $errors->first('description') }}</p> @endif
                </div>
            </div>  

           <!--  <div class="form-group">
                {!! Form::label('User Group', 'User Group', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                  {!! Form::select('role',$selectRoles1,0,['class' => 'form-control input-sm' ,'id' => 'role']) !!}
                  @if ($errors->has('role'))
                   <p class="help-block red">*{{ $errors->first('role') }}</p> @endif
              </div>
            </div> -->

            <div class="form-group">
                {!! Form::label('User Group', 'User Group', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                   @foreach($selectRoles1 as $key=>$value) 
                     @if($key>0)
                         <input type="checkbox" id="role_{!! $key !!}" name="role[]" value="{!! $key !!}" style="opacity:1 !important; position:relative;" class="rolechk"  onclick="show_permission('{!! $key !!}')"> {!! $value !!}
                         <div style="margin-left:20px;" id="permission_check_{!! $key !!}"> </div>
                      @endif
                   @endforeach      
                    @if ($errors->has('role'))
                   <p class="help-block red">*{{ $errors->first('role') }}</p> @endif 

                </div>      
            </div>
            

            <div class="form-group">
                {!! Form::label('Version', 'Version', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                  {!! Form::text('version',NULL,['class' => 'form-control input-sm','id' => 'version']) !!}
                  @if ($errors->has('version')) <p class="help-block red">*{{ $errors->first('version') }} </p>
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
                {!! Form::label('Status', ' Status', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                  {!! Form::select('status',['1'=>'Active','2'=>'Inactive'],1,['class' => 'form-control input-sm' ,'id' => 'role']) !!}
               
              </div>
            </div>
       

             <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <button type="submit" id='submitUpdateDocumentForm' type="button" class="btn btn-sm">Add Sub Folder</button>

                    <button type="button" onclick="javascript:history.back();" type="button" class="btn btn-sm"> Back </button>
                </div>
             </div>

            </div>
            <div class="modal-footer">

                <!-- <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button> -->
            </div>

            {!! Form::close() !!}
 
 

@endsection

@section('footer')


 <script>
   $(document).ready(function() {
    $('input.rolechk').iCheck('destroy');
  });
    

    function show_permission(id){
    
       if($("#role_"+id+"").is(':checked'))
        {
            var div = '<input type="checkbox" name="permission['+id+'][]" value="1" style="opacity:1 !important; position:relative;"/> Read <input type="checkbox" name="permission['+id+'][]" value="2" style="opacity:1 !important; position:relative;"/>Write';

            $("#permission_check_"+id+"").html(div);
        }else{           
           $("#permission_check_"+id+"").html('');
        } 
    }


    @if (count($errors) > 0)
          @if(Input::get ('docID'))
            $('#modalEditdocuments').modal('show');
          @else
            $('#modalAddDocument').modal('show');
          @endif      
    @endif


</script>

@endsection
