{!! Form::open(['url' => 'addCaseNote', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addCaseNoteForm" ]) !!}

{!! Form::hidden('uid',Auth::user()->id,['id' => 'uid']) !!}
{!! Form::hidden('caseID',NULL,['id' => 'caseID']) !!}
<input type="hidden" name="caseID" value="{{ $case->id }}">

<div class="form-group">
    {!! Form::label('Your Note', 'Your Note', array('class' => 'col-md-2 control-label')) !!}
    <div class="col-md-10">
        <textarea rows="5" id="caseNote" name="caseNote" class="sms form-control" maxlength="500"></textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-2 col-md-10">
        <button type="submit" id='submitAddCaseNoteForm' class="btn btn-sm">Add Case Note</button>
    </div>
</div>

{!! Form::close() !!}
