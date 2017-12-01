
            {{--{!! Form::open(['url' => '/api/v1/drone', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"requestDroneForm" ]) !!}--}}
            {{--{!! Form::hidden('created_by',Auth::user()->id)!!}--}}
            {{--{!! Form::hidden('caseNumber',$case->id )!!}--}}
            {{--<div class="form-group">--}}
                {{--{!! Form::label('Search Department', 'Search Department', array('class' => 'col-md-3 control-label')) !!}--}}
                {{--<div class="col-md-6">--}}
                    {{--{!! Form::text('dronesDepartment',null,['class' => 'form-control validate[required]' ,'id' => 'dronesDepartment', old('department')]) !!}--}}
                    {{--@if ($errors->has('dronesDepartment')) <p class="help-block red">*{{ $errors->first('dronesDepartment') }}</p> @endif--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="form-group">--}}
                {{--{!! Form::label('Select Drone', 'Select Drone', array('class' => 'col-md-3 control-label')) !!}--}}
                {{--<div class="col-md-6">--}}
                    {{--{!! Form::select('drone_type_id',$selectDroneTypes,"",['class' => 'form-control validate[required]','id' => 'drone_type_id', old('drone_type_id')]) !!}--}}
                    {{--@if ($errors->has('drone_type_id')) <p class="help-block red">*{{ $errors->first('drone_type_id') }}</p> @endif--}}
                {{--</div>--}}

            {{--</div>--}}

            {{--<div class="form-group">--}}
                {{--{!! Form::label('Select Drone Services', 'Select Drone Services', array('class' => 'col-md-3 control-label')) !!}--}}
                {{--<div class="col-md-6">--}}
                    {{--{!! Form::select('sub_drone_type_id',Null,['class' => 'form-control validate[required]' ,'id' => 'sub_drone_type_id']) !!}--}}
                    {{--@if ($errors->has('sub_drone_type_id')) <p class="help-block red">*{{ $errors->first('sub_drone_type_id') }}</p> @endif--}}

                    {{--<select class="form-control" id="sub_drone_type_id" name="sub_drone_type_id"  value ="old('sub_drone_type_id')">--}}
                        {{--<option selected disabled>Nothing selected</option>--}}
                    {{--</select>--}}
                    {{--@if ($errors->has('sub_drone_type_id')) <p class="help-block red">*{{ $errors->first('sub_drone_type_id') }}</p> @endif--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="form-group">--}}
                {{--{!! Form::label('Comment', 'Comment', array('class' => 'col-md-3 control-label')) !!}--}}
                {{--<div class="col-md-6">--}}
                    {{--<textarea rows="5" id="comment" name="comment" class="form-control" maxlength="500" title="short" value=" old('comment')"></textarea>--}}
                    {{--@if ($errors->has('comment')) <p class="help-block red">*{{ $errors->first('comment') }}</p> @endif--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="form-group">--}}
                {{--<div class="col-md-6">--}}
                    {{--<div class="col-sm-offset-6 col-sm-6">--}}
                        {{--<button type="submit" class="btn btn-default">Request</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
       {{--{!! Form::close() !!}--}}

            {!! Form::open(['url' => '/api/v1/drone', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"requestDroneForm" ]) !!}
            {!! Form::hidden('created_by',Auth::user()->id)!!}
            {!! Form::hidden('caseNumber',$case->id )!!}
            <div class="form-group">
                {!! Form::label('Search Department', 'Search Department', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('dronesDepartment',null,['class' => 'form-control validate[required]' ,'id' => 'dronesDepartment', old('department')]) !!}
                    @if ($errors->has('dronesDepartment')) <p class="help-block red">*{{ $errors->first('dronesDepartment') }}</p> @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Select Drone', 'Select Drone', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::select('drone_type_id',$selectDroneTypes,"",['class' => 'form-control validate[required]','id' => 'drone_type_id', old('drone_type_id')]) !!}
                    @if ($errors->has('drone_type_id')) <p class="help-block red">*{{ $errors->first('drone_type_id') }}</p> @endif
                </div>

            </div>

            <div class="form-group">
                {!! Form::label('Select Drone Types ', 'Select Drone Types', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {{--{!! Form::select('sub_drone_type_id',Null,['class' => 'form-control validate[required]' ,'id' => 'sub_drone_type_id']) !!}--}}
                    {{--@if ($errors->has('sub_drone_type_id')) <p class="help-block red">*{{ $errors->first('sub_drone_type_id') }}</p> @endif--}}

                    <select class="form-control" id="sub_drone_type_id" name="sub_drone_type_id"  value ="old('sub_drone_type_id')">
                        <option selected disabled>Nothing selected</option>
                    </select>
                    @if ($errors->has('sub_drone_type_id')) <p class="help-block red">*{{ $errors->first('sub_drone_type_id') }}</p> @endif
                </div>
            </div>
            <div class="form-group realTime hidden">
                {!! Form::label('Service Required ', 'Service Required ', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('service',NULL,['class' => 'form-control input-sm','id' => 'service']) !!}
                </div>
            </div>

            <div class="form-group droneService hidden">
                {!! Form::label('Select Drone Services', 'Select Drone Services', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    <select class="form-control" id="drone_service_type_id" name="drone_service_type_id"  value ="old('sub_drone_type_id')">
                        <option selected disabled>Nothing selected</option>
                    </select>
                    @if ($errors->has('drone_service_type_id')) <p class="help-block red">*{{ $errors->first('drone_service_type_id') }}</p> @endif
                </div>
            </div>
            <div class="form-group droneSubService hidden">
                {!! Form::label('Select Drone Sub Services', 'Select Drone Sub Services', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    <select class="form-control" id="drone_sub_service_type_id" name="drone_sub_service_type_id"  value ="old('sub_drone_type_id')">
                        <option selected disabled>Nothing selected</option>
                    </select>
                    @if ($errors->has('drone_sub_service_type_id')) <p class="help-block red">*{{ $errors->first('drone_sub_service_type_id') }}</p> @endif
                </div>
            </div>
            <div class="form-group surveys hidden" id="reloadMap">
                {!! Form::label('Area of Interest', 'Area of Interest', array('class' => 'col-md-3 control-label  ')) !!}
                <div class="col-md-6 col-offset-3">

                    <div style="width:100% ; min-height: 500px"; id="map" onmouseover="showMap()"></div>
                    @if ($errors->has('area_of_interest')) <p class="help-block red">*{{ $errors->first('area_of_interest') }}</p> @endif
                </div>
            </div>
            <div class="form-group purposeOfSurvey hidden">
                {!! Form::label('Purpose Of Survey ', 'Purpose Of Survey', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('purpose_of_survey',NULL,['class' => 'form-control input-sm','id' => 'purpose_of_survey','disabled']) !!}
                </div>
            </div>
            <div class="form-group numberOfStockPile hidden">
                {!! Form::label('Number of Stockpiles', 'Number of Stockpiles', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('number_of_stockpiles',NULL,['class' => 'form-control input-sm','id' => 'number_of_stockpiles','disabled','rows'=>'7']) !!}
                </div>
            </div>
            <div class="form-group verticalAccuracy hidden">
                {!! Form::label('Vertical Accuracy', 'Vertical Accuracy', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('vertical_accuracy',NULL,['class' => 'form-control input-sm','id' => 'vertical_accuracy','disabled','rows'=>'7']) !!}
                </div>
            </div>
            <div class="form-group auxiliaryServices hidden">
                {!! Form::label('Object of Interest ', 'Object of Interest ', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('interest',NULL,['class' => 'form-control input-sm','id' => 'interest','disabled','rows'=>'7']) !!}
                </div>
            </div>
            <div class="form-group scopeOfWOrk hidden">
                {!! Form::label('Scope of Work ', 'Scope of Work  ', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('scope_of_work',NULL,['class' => 'form-control input-sm','id' => 'scope_of_work']) !!}
                </div>
            </div>
            <div class="form-group Notes hidden">
                {!! Form::label('Notes', 'Notes ', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::textarea('notes',NULL,['class' => 'form-control input-sm','id' => 'notes']) !!}
                </div>
            </div>
            <div class="form-group surveys hidden">
                {!! Form::label('Geo Fence Clipboard', 'clip Board', array('class' => 'col-md-3 control-label  ')) !!}
                <div class="col-md-6">
                    <div>
                        {!! Form::text('geoFenceCoords',NULL,['class' => 'form-control input-sm','id' => 'geoFenceCoords','rows'=>5]) !!}
                    </div>
                    @if ($errors->has('geoFenceCoords')) <p class="help-block red">*{{ $errors->first('geoFenceCoords') }}</p> @endif
                </div>
            </div>
            <div class="form-group " style="margin-top: 10px;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="col-sm-6 col-sm-offset-5">
                        <button type="submit" class="btn btn-lg">Request</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
