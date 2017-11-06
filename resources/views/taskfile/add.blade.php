
<!-- Breadcrumb -->
<div>

    <div class="row">

    <div class="block-area" id="inline">

        {!! Form::open(['url' => 'taskfile', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addTaskFileCaptureForm", 'files' => true]) !!}
        {!! Form::hidden('id',Auth::user()->id) !!}
        {!! Form::hidden('activity_note','added a file') !!}
        <input type="hidden" name="task_id" value="{{$task->id}}">

        <div class="form-group">
            {!! Form::label('File Note', 'File Note', array('class' => 'col-md-3 control-label')) !!}
            <div class="col-md-6">
                <textarea rows="5" id="file_note" name="file_note" class="form-control" maxlength="500" title="short"></textarea>
                @if ($errors->has('file_note')) <p class="help-block red">*{{ $errors->first('file_note') }}</p> @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('Attach File', 'Attach File', array('class' => 'col-md-3 control-label')) !!}

            <div class="fileupload fileupload-new row" data-provides="fileupload">
                <div class="input-group col-md-6">
                    <div class="uneditable-input form-control">
                        <i class="fa fa-file m-r-5 fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
                    <div class="input-group-btn">
                                <span class="btn btn-file btn-alt btn-sm">
                                <span class="fileupload-new">Select file</span>
                                <span class="fileupload-exists">Change</span>
                                <input type="file" name="file" id="file"/>
                            </span>
                        @if ($errors->has('file')) <p class="help-block red">*{{ $errors->first('file') }}</p> @endif
                        <a href="#" class="btn btn-sm btn-gr-gray fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <button type="submit" id='submitAddTaskFileForm' type="button" class="btn btn-info btn-sm">Attach File</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    </div>
</div>

<hr class="whiter m-t-20" />

<br/>
<br/>

<div class="row">
    <div class="col-md-12">
        <div>
            <h2 class="tile-title">Recent Files</h2>

            @include('taskfile.list')

        </div>
    </div>

</div>

