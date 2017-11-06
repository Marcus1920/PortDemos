{!! Form::open(['url' => 'sendCaseMessage', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addCaseMessage"]) !!}
{!! Form::hidden('uid',(Auth::check() ? Auth::user()->id : 0),['id' => 'uid']) !!}
<input type="hidden" name="caseID" value="{{ $case->id }}">

<div class="form-group">
    {!! Form::label('To', 'To', array('class' => 'col-md-2 control-label')) !!}

    <div class="col-md-8">
        {!! Form::text('Recepient',NULL,['class' => 'form-control input-sm','id' => 'Recepient']) !!}
    </div>
    <div class="col-md-2">
        <a class="btn btn-sm" data-toggle="modal" title="Add New Contact on Address Book" onClick="launchAddress();" data-target=".modalAddress">
            <i class="sa-plus"></i>
        </a>
    </div>
</div>

<div class="form-group">
    {!! Form::label('Cc', 'Cc', array('class' => 'col-md-2 control-label')) !!}

    <div class="col-md-8">
        {!! Form::text('Cc',NULL,['class' => 'form-control input-sm','id' => 'Cc']) !!}
    </div>
    <div class="col-md-2">
        <a class="btn btn-sm" data-toggle="modal" title="Add New Contact on Address Book" onClick="launchAddress();" data-target=".modalAddress">
            <i class="sa-plus"></i>
        </a>
    </div>
</div>

<div class="form-group">
    {!! Form::label('Subject', 'Subject', array('class' => 'col-md-2 control-label')) !!}

    <div class="col-md-8">
        {!! Form::text('msgSubject',NULL,['class' => 'form-control input-sm','id' => 'msgSubject']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('Message', 'Message', array('class' => 'col-md-2 control-label')) !!}
    <div class="col-md-8">
        <textarea rows="5" id="msg" name="msg" class="sms form-control" maxlength="500"></textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-2 col-md-8">
        <button type="submit" id='submitAddCaseMessageForm' class="btn btn-sm">Send Message</button>
    </div>
</div>

{!! Form::close() !!}