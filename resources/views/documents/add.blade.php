<!-- Modal Default -->
<style>
    .ckfield{z-index: 9999;}
</style>
<div class="modal fade modalAddDocument" id="modalAddDocument" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id='depTitle'> Add Folder </h4>
            </div>
            <div class="modal-body">
            {!! Form::open(['url' => 'addDocument', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"UpdateDocumentForm" ]) !!}

            <!-- <input type="hidden" name="folder_id" id="folder_id"  value=""> 
            <input type="hidden" name="folder_lavel" id="folder_lavel"  value=""> -->
 
               {!! Form::hidden('folder_id',NULL, ['id' => 'folder_id']) !!}

               {!! Form::hidden('folder_lavel',NULL, ['id' => 'folder_lavel']) !!}



            {!! Form::hidden('user_id',Auth::user()->id) !!}

            <div class="form-group">
                {!! Form::label('Name', 'Name', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-10">
                  {!! Form::text('name',NULL,['class' => 'form-control input-sm','id' => 'name']) !!}
                  @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Description', 'Description', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-10">
                  {!! Form::text('description',NULL,['class' => 'form-control input-sm','id' => 'Description']) !!}
                  @if ($errors->has('description')) <p class="help-block red">*{{ $errors->first('description') }}</p> @endif
                </div>
            </div>  

            <div class="form-group">
                {!! Form::label('User Group', 'User Group', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::select('role',$selectRoles1,0,['class' => 'form-control input-sm' ,'id' => 'role']) !!}
                  @if ($errors->has('role'))
                   <p class="help-block red">*{{ $errors->first('role') }}</p> @endif
              </div>
            </div>
            

            <div class="form-group">
                {!! Form::label('Version', 'Version', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-10">
                  {!! Form::text('version',NULL,['class' => 'form-control input-sm','id' => 'version']) !!}
                  @if ($errors->has('version')) <p class="help-block red">*{{ $errors->first('version') }} </p>
                   @endif

                </div>    

            </div>  
           

            <div class="form-group">
                {!! Form::label('Notes', 'Notes', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-10">
                  {!! Form::text('note',NULL,['class' => 'form-control input-sm','id' => 'document_note']) !!}
                  @if ($errors->has('note')) <p class="help-block red">*{{ $errors->first('note') }} </p> @endif
                </div>
            </div>  

            <div class="form-group">
                {!! Form::label('Status', ' Status', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::select('status',['1'=>'Active','2'=>'Inactive'],1,['class' => 'form-control input-sm' ,'id' => 'role']) !!}
               
              </div>
            </div>



           <!--  <div class="form-group">
                {!! Form::label('Permisssions', 'Permisssions', array('class' => 'col-md-2 control-label')) !!}
                
                <div class="col-md-10">                 
                  {!!  Form::select('premissions', [''=>'Select Permission','1' => 'Read','2' => 'Write',
                  '3' => 'Delete'],null,['class' => 'form-control input-sm','id' => 'permission','multiple'=>'multiple']) !!}                 

                </div>
            </div>   -->     

             <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <button type="submit" id='submitUpdateDocumentForm' type="button" class="btn btn-sm">Add Folder</button>
                </div>
             </div>

            </div>
            <div class="modal-footer">

                <!-- <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button> -->
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>



<div class="modal fade modalAddDocument1" id="modalAddDocument1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id='depTitle'> Uploading a File / Image </h4>
            </div>

            <div class="modal-body">
            {!! Form::open(['url' => 'addDocumentfile', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"UpdateDocumentForm1","files" => true ]) !!}


             {!! Form::hidden('folder_id',NULL, ['id' => 'folder_id1']) !!}

             {!! Form::hidden('folder_lavel',NULL, ['id' => 'folder_lavel1']) !!}


            {!! Form::hidden('user_id',Auth::user()->id) !!}

            <div class="form-group">
                {!! Form::label('File Name', 'File Name', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-10">

                    {!! Form::file('upload_doc') !!}   
                 
                  @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Description', 'Description', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-10">
                  {!! Form::text('description',NULL,['class' => 'form-control input-sm','id' => 'Description']) !!}
                  @if ($errors->has('description')) <p class="help-block red">*{{ $errors->first('description') }}</p> @endif
                </div>
            </div>  

            <div class="form-group">
                {!! Form::label('User Group', 'User Group', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::select('group_id',$selectRoles1,0,['class' => 'form-control input-sm' ,'id' => 'group_id']) !!}
                  @if ($errors->has('role'))
                   <p class="help-block red">*{{ $errors->first('role') }}</p> @endif
              </div>
            </div>      

            <div class="form-group">
                {!! Form::label('Notes', 'Notes', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-10">
                  {!! Form::text('note',NULL,['class' => 'form-control input-sm','id' => 'document_note']) !!}
                  @if ($errors->has('note')) <p class="help-block red">*{{ $errors->first('note') }} </p> @endif
                </div>
            </div>              
         

             <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <button type="submit" id='submitUpdateDocumentForm1' type="button" class="btn btn-sm">Add File </button>
                </div>
             </div>

            </div>
            <div class="modal-footer">

                <!-- <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button> -->
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>



