<!-- Modal Default -->
<div class="modal fade modalSubResponder" id="modalSubSubResponder" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id='depTitle'>Sub Category Responders</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => 'addSubCategoryResponder', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"SubCategoryResponderForm" ]) !!}
                {!! Form::hidden('deptID',$deptName->id) !!}
                {!! Form::hidden('catID',$catObj->id) !!}
                {!! Form::hidden('subCatID',NULL,['id' => 'subCatID']) !!}
                {!! Form::hidden('id',Auth::user()->id) !!}

                <div class="form-group">
                    {!! Form::label('First Responder', 'First Responder', array('class' => 'col-md-2 control-label')) !!}

                    <div class="col-md-8">

                        {!! Form::text('firstResponder',NULL,['class' => 'form-control','id' => 'firstResponder']) !!}
                    </div>

                    <div class="col-md-2">

                        {!! Form::text('first_responder_interval_time',NULL,['class' => 'form-control','id' => 'first_responder_interval_time','placeholder' =>"Time"]) !!}
                    </div>


                </div>

                <div class="form-group">
                    {!! Form::label('Second Responder', 'Second Responder', array('class' => 'col-md-2 control-label')) !!}

                    <div class="col-md-8">
                        {!! Form::text('secondResponder',NULL,['class' => 'form-control input-sm','id' => 'secondResponder']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('second_responder_interval_time',NULL,['class' => 'form-control','id' => 'second_responder_interval_time','placeholder' =>""]) !!}
                    </div>

                </div>

                <div class="form-group">
                    {!! Form::label('Third Responder', 'Third Responder', array('class' => 'col-md-2 control-label')) !!}

                    <div class="col-md-8">
                        {!! Form::text('thirdResponder',NULL,['class' => 'form-control input-sm','id' => 'thirdResponder']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('third_responder_interval_time',NULL,['class' => 'form-control','id' => 'third_responder_interval_time','placeholder' =>""]) !!}

                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Admin Responder', 'Admin Responder', array('class' => 'col-md-2 control-label')) !!}

                    <div class="col-md-8">
                        {!! Form::text('fourthResponder',NULL,['class' => 'form-control input-sm','id' => 'fourthResponder']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('fourth_responder_interval_time',NULL,['class' => 'form-control','id' => 'fourth_responder_interval_time','placeholder' =>""]) !!}

                    </div>
                </div>

                <hr class="whiter m-t-20">
                <hr class="whiter m-b-20">


                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <button type="submit" id='submitUpdateCategoryForm' type="button" class="btn btn-sm">Save Changes</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
