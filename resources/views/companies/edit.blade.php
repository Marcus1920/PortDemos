<!-- Modal Default -->
<div class="modal fade modalEditCompany" id="modalEditCompany" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id='depTitle'>Province</h4>
            </div>
            <div class="modal-body">
            {!! Form::open(['url' => 'updateCompany', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"updateCompanyForm" ]) !!}
            {!! Form::hidden('id',NULL,['id' => 'id']) !!}
            {!! Form::hidden('uid',Auth::user()->id) !!}
            <div class="form-group">
                {!! Form::label('Name', 'Name', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-9">
                  {!! Form::text('name',NULL,['class' => 'form-control input-sm','id' => 'name']) !!}
                  @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                </div>
            </div>
                <div class="form-group">
                    {!! Form::label('Name', 'Address', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-9">
                        {!! Form::textarea('address',NULL,['class' => 'form-control input-sm','id' => 'address', 'rows'=>3]) !!}
                        @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('Name', 'Company Number', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-9">
                        {!! Form::text('company_number',NULL,['class' => 'form-control input-sm','id' => 'company_number']) !!}
                        @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                    </div>
                </div><div class="form-group">
                    {!! Form::label('Name', 'Company Email', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-9">
                        {!! Form::text('company_email',NULL,['class' => 'form-control input-sm','id' => 'company_email']) !!}
                        @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('Name', 'Contact Number', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-9">
                        {!! Form::text('contact_number',NULL,['class' => 'form-control input-sm','id' => 'contact_number']) !!}
                        @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                    </div>
                </div><div class="form-group">
                    {!! Form::label('Name', 'Contact Email', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-9">
                        {!! Form::text('contact_email',NULL,['class' => 'form-control input-sm','id' => 'contact_email']) !!}
                        @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
                    </div>
                </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <button type="submit" id='submitUpdateCompanyForm' type="button" class="btn btn-sm">Save Changes</button>
                </div>
            </div>
            </div>
            <div class="modal-footer">

            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
