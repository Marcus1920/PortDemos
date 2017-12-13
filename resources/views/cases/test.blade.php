@extends('master')

@section('content')
  <script>
		$(document).ready(function () {
			jQuery.migrateMute = true;
			$.fn.dataTable.ext.errMode = 'none';
		});
  </script>


  <!-- Modal Default -->
  <style>
    /*  bhoechie tab */
    div.bhoechie-tab-container {
      z-index: 10;
      background-color: rgba(0, 0, 0, 0.35) !important;
      padding: 0 !important;
      border-radius: 4px;
      -moz-border-radius: 4px;
      /*border:1px solid #ddd;*/
      margin-top: 15px;
      margin-left: 20px;
      -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
      box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
      -moz-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
      background-clip: padding-box;
      opacity: 0.97;
      filter: alpha(opacity=97);
      width: 98%;

    }

    div.bhoechie-tab-menu {
      padding-right: 0;
      padding-left: 0;
      padding-bottom: 0;
    }

    div.bhoechie-tab-menu div.list-group {
      margin-bottom: 0;
    }

    div.bhoechie-tab-menu div.list-group > a {
      margin-bottom: 0;
    }

    div.bhoechie-tab-menu div.list-group > a .glyphicon,
    div.bhoechie-tab-menu div.list-group > a .fa {
      /*color: #5A55A3;*/
    }

    div.bhoechie-tab-menu div.list-group > a:first-child {
      border-top-right-radius: 0;
      -moz-border-top-right-radius: 0;
    }

    div.bhoechie-tab-menu div.list-group > a:last-child {
      border-bottom-right-radius: 0;
      -moz-border-bottom-right-radius: 0;
    }

    div.bhoechie-tab-menu div.list-group > a.active,
    div.bhoechie-tab-menu div.list-group > a.active .glyphicon,
    div.bhoechie-tab-menu div.list-group > a.active .fa {
      /*background-color: #5A55A3;*/
      /*background-image: #5A55A3;*/
      /*color: #ffffff;*/
    }

    div.bhoechie-tab-menu div.list-group > a.active:after {
      content: '';
      position: absolute;
      left: 100%;
      top: 50%;
      margin-top: -13px;
      border-left: 0;
      border-bottom: 13px solid transparent;
      border-top: 13px solid transparent;
      border-left: 10px solid #0D3349;
    }

    div.bhoechie-tab-content {
      /*background-color: #0B628D;*/
      /* border: 1px solid #eeeeee; */
      padding-left: 10px;
      padding-top: 10px;
    }

    div.bhoechie-tab div.bhoechie-tab-content:not(.active) {
      display: none;
    }

    .top li a {
      border: 1px solid white;
      border-radius: 15px;
    }
  </style>

  <!-- Breadcrumb -->
  <ol class="breadcrumb hidden-xs">
    <li><a href="{{ url('home') }}">Cases</a></li>
    <li class="active">Case Profile</li>
  </ol>

  <h4 class="page-title">Case Profile</h4>

  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-9 bhoechie-tab-container">
        <div class="row">
          <div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
              <div class="panel-heading">
                <ul class="nav nav-pills nav-justified top">
                  <li class="active">
                    <a href="#1a" data-toggle="tab" onclick="shows(this, 1)"><span class="fa fa-file-text"> Profile</span></a>
                  </li>
                  <li>
                    <a href="#2a" data-toggle="tab" onclick="hides()"><span class="fa fa-briefcase "> Related</span></a>
                  </li>
                  <li>
                    <a href="#3a" data-toggle="tab" onclick="hides()"><span class="fa fa-users "> People Involved</span></a>
                  </li>
                  <li><a href="#4a" data-toggle="tab" onclick="hides()"><span class="fa fa-user "> POI </span></a>
                  </li>
                  <li>
                    <a href="#5a" data-toggle="tab" onclick="hides()"><span class="fa fa-folder-open-o "> Activities</span></a>
                  </li>
                  <li><a href="#6a" data-toggle="tab" onclick="hides()"><span class="fa fa-file-text-o"> Notes</span></a>
                  </li>
                  <li>
                    <a href="#7a" data-toggle="tab" onclick="hides()"><span class="fa fa-paste "> Attachments</span></a>
                  </li>
                  <li>
                    <a href="#8a" data-toggle="tab" onclick="hides()"><span class="fa fa-file-text-o"> Tasks</span></a>
                  </li>
                  <li>
                    <a href="#9a" data-toggle="tab" onclick="hides()"><span class="fa fa-file-text-o"> Drone Request</span></a>
                  </li>
                </ul>
                <hr class="whiter m-t-20">
                <h2 class="fa" style="font-size: x-large; padding: 0; margin: inherit; clear: both">
                  <a href="#" title="Print" class="hasTip">&#xf02f;</a>
                  &nbsp;&nbsp;&nbsp;
                  <a href="{{ url('maps') }}?lat={{ $case[0]->gps_lat }}&lng={{ $case[0]->gps_lng }}&zoom=18" title="View on map" class="hasTip">
                    &#xf041;</a>
                  &nbsp;&nbsp;&nbsp;
                  <a href="#" title="Forms" class="hasTip">&#xf0ea;</a>
                  &nbsp;&nbsp;&nbsp;
                  <a href="#" title="Checklists" class="hasTip">&#xf03a;</a>
                  &nbsp;&nbsp;&nbsp;
                  <a href="#" title="Workflows" class="hasTip">&#xf017;</a>
                </h2>
                <hr class="whiter m-b-20">
                <div class="wAlert" style="margin-top: 1em"></div>
              </div>
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 bhoechie-tab-menu" id="side_navs">
                <div class="list-group">
                  <a id="case" disabled style="border: none;cursor: hand" class="list-group-item text-center active"></a>
                  <a href="#" class="list-group-item text-center" onclick="{shows(this,1);}">
                    <h5 class="glyphicon glyphicon-folder-open"></h5><br/>Allocate Case
                  </a>
                  <a href="#" class="list-group-item text-center" onclick="{shows(this,2);}">
                    <h4 class="glyphicon glyphicon-log-out"></h4><br/>Refer Case
                  </a>
                  <a href="#" class="list-group-item text-center" onclick="{shows(this,3);}">
                    <h5 class="glyphicon glyphicon-plus-sign"></h5><br/> Add Case Note
                  </a>
                  <a href="#" class="list-group-item text-center" onclick="{shows(this,4);}">
                    <h5 class="glyphicon glyphicon-envelope"></h5><br/> Send Email
                  </a>
                  <a href="#" class="list-group-item text-center" onclick="{shows(this,5);}">
                    <h5 class="glyphicon glyphicon-paperclip"></h5><br/>Attach File
                  </a>
                  <a href="#" class="list-group-item text-center" onclick="{shows(this,6);}">
                    <h4 class="glyphicon glyphicon-credit-card"></h4><br/>Add Case Task
                  </a>

                  <a href="#" class="list-group-item text-center" id="acceptCase" onclick="{shows(this,7);acceptCase();}">
                    <h5 class="glyphicon glyphicon-ok-sign"></h5><br/>Accept Case
                  </a>
                  <button class="list-group-item text-center" id="acceptedCase" disabled style="width:100%; display:none">
                    <h5 class="glyphicon glyphicon-remove-sign"></h5><br/>Case accepted
                  </button>
                  <a href="#" class="list-group-item text-center" onclick="{ shows(this,8); closeCase();}">
                    <h4 class="glyphicon glyphicon-off"></h4><br/>Close Case
                  </a>
                  <a href="#" class="list-group-item text-center" onclick="{shows(this,9);}">
                    <h5 class="glyphicon glyphicon-plane"></h5><br/>Request a Drone
                  </a>
                  <a href="#" class="list-group-item text-center" id="acceptCase" onclick="{return false;}">
                    <h5 class="sa-side-page" style="width: initial; margin: 0; padding: 0"></h5>Form Wizard
                  </a>
                </div>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                <!-- flight section -->
              {{--<div class="bhoechie-tab-content active">--}}
              {{--<div class="tab-pane active" id="1a">--}}
              {{--<div id="caseNotesNotification"></div>--}}
              {{--{!! Form::open(['url' => '#', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"caseProfileForm" ]) !!}--}}
              {{--{!! Form::hidden('caseID',NULL,['id' => 'caseID']) !!}--}}
              {{--{!! Form::hidden('userID',NULL,['id' => 'userID']) !!}--}}
              {{--<div class="form-group">--}}
              {{--{!! Form::label('Case Number', 'Case Number', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('id',NULL,['class' => 'form-control input-sm','id' => 'id','disabled' => 'disabled']) !!}--}}
              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Date received', 'Date received', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('created_at',NULL,['class' => 'form-control input-sm','id' => 'created_at','disabled' => 'disabled']) !!}--}}
              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Date booked out', 'Date booked out', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('created_at',NULL,['class' => 'form-control input-sm','id' => 'created_at','disabled' => 'disabled']) !!}--}}
              {{--</div>--}}
              {{--</div>--}}


              {{--<div class="form-group">--}}
              {{--{!! Form::label('Commencement date', 'Commencement date', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('created_at',NULL,['class' => 'form-control input-sm','id' => 'created_at','disabled' => 'disabled']) !!}--}}
              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Last Activity Datetime', 'Last Activity Datetime', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('last_at',NULL,['class' => 'form-control input-sm','id' => 'last_at','disabled' => 'disabled']) !!}--}}
              {{--</div>--}}
              {{--</div>--}}


              {{--<div class="form-group">--}}
              {{--{!! Form::label('Description', 'Description', array('class' => 'col-md-3 control-label','disabled' => 'disabled')) !!}--}}
              {{--<div class="col-md-6">--}}

              {{--{!! Form::textarea('description', null, ['class' => 'form-control input-sm','id' => 'description','size' => '30x5','disabled' => 'disabled']) !!}--}}
              {{--</div>--}}
              {{--</div>--}}
              {{--<div class="form-group">--}}
              {{--{!! Form::label('Client Name', 'Client Name', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('household',NULL,['class' => 'form-control input-sm','id' => 'household','disabled' => 'disabled']) !!}--}}
              {{--<div  id="launchUpdateUserModalHouseID" class="hidden">--}}
              {{--<a class="btn btn-xs btn-alt" id="launchUpdateUserModalHouse"  data-toggle="modal" data-id onClick="launchUpdateUserModal($(this).data('id'));" data-target=".modalEditUser">View More</a>--}}
              {{--</div>--}}
              {{--</div>--}}
              {{--</div>--}}
              {{--<div class="form-group">--}}
              {{--{!! Form::label('Client Cellphone', 'Client Cellphone', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('householdCell',NULL,['class' => 'form-control input-sm','id' => 'householdCell','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}
              {{--<div class="form-group">--}}
              {{--{!! Form::label('Client reference number', 'Client reference number', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('client_reference_number',NULL,['class' => 'form-control input-sm','id' => 'client_reference_number','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}
              {{--<div class="form-group">--}}
              {{--{!! Form::label('SAPS Number', 'SAPS Number', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('sapc_number',NULL,['class' => 'form-control input-sm','id' => 'sapc_number','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('SAPS Station', 'SAPS Station', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('saps_station',NULL,['class' => 'form-control input-sm','id' => 'saps_station','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}
              {{--<div class="form-group">--}}
              {{--{!! Form::label('Investigation Officer', 'Investigation Officer', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('investigation_officer',NULL,['class' => 'form-control input-sm','id' => 'investigation_officer','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Investigation Cellphone', 'Investigation Cellphone', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('investigation_cell',NULL,['class' => 'form-control input-sm','id' => 'investigation_cell','disabled' => 'disabled']) !!}--}}
              {{--<div id = "hse_error_saps_investigation_cellphone"></div>--}}
              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Investigation Email', 'Investigation Email', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('investigation_email',NULL,['class' => 'form-control input-sm','id' => 'investigation_email','disabled' => 'disabled']) !!}--}}
              {{--<div id = "hse_error_saps_investigation_email"></div>--}}
              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Investigation Note', 'Investigation Note', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('investigation_note',NULL,['class' => 'form-control input-sm','id' => 'investigation_note','disabled' => 'disabled']) !!}--}}
              {{--<div id = "hse_error_saps_investigation_note"></div>--}}
              {{--</div>--}}
              {{--</div>--}}
              {{--<div class="form-group">--}}
              {{--{!! Form::label('Case Type', 'Case Type', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('case_type',NULL,['class' => 'form-control input-sm','id' => 'case_type','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Case Sub Type', 'Case Sub Type', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('case_sub_type',NULL,['class' => 'form-control input-sm','id' => 'case_sub_type','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Street Number', 'Street Number', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('street_number',NULL,['class' => 'form-control input-sm','id' => 'street_number','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}
              {{--<div class="form-group">--}}
              {{--{!! Form::label('Route', 'Route', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('route',NULL,['class' => 'form-control input-sm','id' => 'route','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Locality', 'Locality', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('locality',NULL,['class' => 'form-control input-sm','id' => 'locality','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Area', 'Area', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('administrative_area_level_1',NULL,['class' => 'form-control input-sm','id' => 'administrative_area_level_1','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--{!! Form::label('Postal Code', 'Postal Code', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('postal_code',NULL,['class' => 'form-control input-sm','id' => 'postal_code','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>s--}}


              {{--<div class="form-group">--}}
              {{--{!! Form::label('Country', 'Country', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('country',NULL,['class' => 'form-control input-sm','id' => 'country','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}
              {{--<div class="form-group">--}}
              {{--{!! Form::label('Status', 'Status', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('status',NULL,['class' => 'form-control input-sm','id' => 'status','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}


              {{--<div class="form-group">--}}
              {{--{!! Form::label('Captured by', 'Captured by', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('reporter',NULL,['class' => 'form-control input-sm','id' => 'reporter','disabled' => 'disabled']) !!}--}}
              {{--<a class="btn btn-xs btn-alt" data-toggle="modal" data-id  id="launchUpdateUserModalField" onClick="launchUpdateUserModal($(this).data('id'));" data-target=".modalEditUser">View More</a>--}}
              {{--</div>--}}
              {{--</div>--}}
              {{--<div class="form-group">--}}
              {{--{!! Form::label('Cellphone', 'Cellphone', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--{!! Form::text('reporterCell',NULL,['class' => 'form-control input-sm','id' => 'reporterCell','disabled' => 'disabled']) !!}--}}

              {{--</div>--}}
              {{--</div>--}}

              {{--<div class="form-group">--}}
              {{--<div class="">--}}
              {{--{!! Form::label('Report Image', 'Report Image', array('class' => 'col-md-3 control-label')) !!}--}}
              {{--<div class="col-md-6">--}}
              {{--<a data-rel="gallery" id="CaseImageA" class="pirobox_gall img-popup" title="">--}}
              {{--<img src="#" alt="" class="superbox-img" id="CaseImage" width="220">--}}
              {{--</a>--}}
              {{--</div>--}}

              {{--</div>--}}
              {{--</div>--}}
              {{--</div>--}}
              {{--</div>--}}
              <!-- train section -->
                <div class="bhoechie-tab-content active" id="top_navs_action">
                  <center>
                    <div class="row">
                      <div class="btn-group-vertical">
                        <a id="editCaseDiv" data-toggle="modal" onclick data-target="modalCaseReport"></a>
                        @if(isset($userAllocateCasesPermission) && $userAllocateCasesPermission->permission_id =='22')
                          <a class="btn btn-lg btn-alt" style="margin-top: 20%;" data-toggle="modal" onClick="launchReferModal('Allocate');" data-target=".modalReferCase">Allocate
                            Case</a>
                        @endif

                        {{--@if(isset($userCreateCasesPermission) && $userCreateCasesPermission->permission_id =='21')--}}

                        {{--<a id="createCaseDiv" class="btn btn-xs btn-alt hidden" style="margin-top: 20%;" data-toggle="modal" onclick="launchCreateCaseModal()" data-target=".modalCreateCase">Create Case</a>--}}

                        {{--@endif--}}


                        @if(isset($userAcceptCasesPermission) && $userAcceptCasesPermission->permission_id =='23')


                          <a id='acceptCaseClass' class="btn btn-xs btn-alt" style="margin-top: 20%;" onClick="acceptCase()">Accept
                            Case</a>

                        @endif


                        @if(isset($userReferCasesPermission) && $userReferCasesPermission->permission_id =='24')
                        <a class="btn btn-lg btn-alt col-md-1" data-toggle="modal" style="margin-top: 20%;" onClick="launchReferModal('Refer');" data-target=".modalReferCase">Refer
                            Case</a>

                        @endif
                        @if(isset($userAddCasesNotesPermission) && $userAddCasesNotesPermission->permission_id =='25')

                          <a class="btn btn-xs btn-alt col-md-1" style="margin-top: 20%;" onClick="launchCaseNotesModal();">Add
                            Case Note</a>
                        @endif
                        @if(isset($userAddCasesFilesPermission) && $userAddCasesFilesPermission->permission_id =='26')

                          <a class="btn btn-xs btn-alt" style="margin-top: 20%;" onClick="launchCaseFilesModal();">Attach
                            File</a>
                        @endif
                        @if(isset($userViewWorkFlowPermission) && $userViewWorkFlowPermission->permission_id =='27')


                          <a id="viewWorkFlow" class="btn btn-xs btn-alt hidden" style="margin-top: 20%;" onClick="launchWorkFlow();">View
                            WorkFlow</a>

                        @endif

                        @if(isset($userCloseCasePermission) && $userCloseCasePermission->permission_id =='28')

                          <a id='closeCaseClass' class="btn btn-xs btn-alt" style="margin-top: 20%;" onClick="closeCase()">Close
                            Case</a>
                        @endif
                        @if(isset($userRequestCaseClosurePermission) && $userRequestCaseClosurePermission->permission_id =='29')

                          <a id='requestCaseClosureClass' class="btn btn-lg btn-alt" style="margin-top: 20%;" onClick="launchRequestCaseClosureModal();">Request
                            Case Closure</a>

                        @endif
                        <img src="a.png" style="margin-bottom: 50%; visibility: hidden;">
                      </div>
                      {{--<div class="col-md-10" style="border-left: 1px solid white; margin-top: 2%; max-height: calc(100vh - 10px); overflow-y: auto;">--}}

                      @foreach($case as $case)
                        <div class="tab-content clearfix">
                          <div class="tab-pane active" id="1a">
                            <div id="caseNotesNotification"></div>
                            @if(Session::has('success'))
                              <div class="alert alert-success alert-icon">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ Session::get('success') }}
                                <i class="icon">&#61845;</i>
                              </div>
                            @endif
                            {!! Form::open(['url' => 'updateCase', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"caseProfileForm" ]) !!}
                            {!! Form::hidden('caseID',$case->id,['id' => 'caseID']) !!}
                            {!! Form::hidden('userID',null,['id' => 'userID']) !!}
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  {!! Form::label('Case Number', 'Case Number', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('id',$case->id,['class' => 'form-control input-sm','id' => 'id','disabled' => 'disabled']) !!}
                                  </div>
                                </div>
																<div class="form-group">
                                  {!! Form::label('Status', 'Status', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('status',$case->status,['class' => 'form-control input-sm','id' => 'status','disabled' => 'disabled']) !!}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Date received', 'Date received', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('created_at',$case->created_at,['class' => 'form-control input-sm','id' => 'created_at','disabled' => 'disabled']) !!}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Date booked out', 'Date booked out', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('created_at',$case->created_at,['class' => 'form-control input-sm','id' => 'created_at','disabled' => 'disabled']) !!}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Commencement date', 'Commencement date', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('created_at',$case->created_at,['class' => 'form-control input-sm','id' => 'created_at','disabled' => 'disabled']) !!}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Last Activity Datetime', 'Last Activity Datetime', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('last_at',$case->last_at,['class' => 'form-control input-sm','id' => 'last_at','disabled' => 'disabled']) !!}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Incident DateTime', 'Incident Date & Time', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('occured_at',$case->occured_at,['class' => 'form-control input-sm','id' => 'occured_at','disabled' => 'disabled']) !!}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Description', 'Description', array('class' => 'col-md-6 control-label','disabled' => 'disabled')) !!}
                                  <div class="col-md-6">
                                    {!! Form::textarea('description', $case->description, ['class' => 'form-control input-sm','id' => 'description','size' => '30x5']) !!}
                                  </div>
                                </div>
                                {{--<div class="form-group">
                                    {!! Form::label('Client Name', 'Name', array('class' => 'col-md-6 control-label')) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('household',$case->household,['class' => 'form-control input-sm','id' => 'household','disabled' => 'disabled']) !!}
                                        <div  id="launchUpdateUserModalHouseID" class="hidden">
                                            <a class="btn btn-xs btn-alt" id="launchUpdateUserModalHouse"  data-toggle="modal" data-id onClick="launchUpdateUserModal($(this).data('id'));" data-target=".modalEditUser">View More</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Client Cellphone', 'Cellphone', array('class' => 'col-md-6 control-label')) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('householdCell',$case->householdCell,['class' => 'form-control input-sm','id' => 'householdCell','disabled' => 'disabled']) !!}

                                    </div>
                                </div>--}}
                                
																<div class="form-group">
                                  {!! Form::label('Captured by', 'Captured by', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('reporter',$capturer['name'],['class' => 'form-control input-sm','id' => 'reporter','disabled' => 'disabled']) !!}
                                    {{--<a class="btn btn-xs btn-alt" data-toggle="modal" data-id  id="launchUpdateUserModalField" onClick="launchUpdateUserModal($(this).data('id'));" data-target=".modalEditUser">View More</a>--}}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Cellphone', 'Cellphone', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('reporterCell',$capturer['cellphone'],['class' => 'form-control input-sm','id' => 'reporterCell','disabled' => 'disabled']) !!}
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6"></div>
                              <div class="col-md-6">
																<div class="form-group">
                                  {!! Form::label('Client reference number', 'Reference number', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('client_reference_number',$case->client_reference_number,['class' => 'form-control input-sm','id' => 'client_reference_number']) !!}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Reporter', 'Reporter', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('reporter_name',$reporter['name'],['class' => 'form-control input-sm','id' => 'reporter_name','disabled'=>'']) !!}
                                    <div id = "hse_error_reporter_name"></div>
                                  </div>
                                </div>

                                <div class="form-group">
                                  {!! Form::label('Investigation Cellphone', 'Cellphone', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('reporter_cellphone',$reporter['cellphone'],['class' => 'form-control input-sm','id' => 'reporter_cell']) !!}
                                    <div id = "hse_reporter_cellphone"></div>
                                  </div>
                                </div>

                                <div class="form-group">
                                  {!! Form::label('Investigation Email', 'Email', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::text('reporter_email',$reporter['email'],['class' => 'form-control input-sm','id' => 'reporter_email']) !!}
                                    <div id = "hse_error_reporter_email"></div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Case Type', 'Company', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {{--{!! Form::text('case_company',$case->company,['class' => 'form-control input-sm','id' => 'case_type','disabled' => 'disabled']) !!}--}}
                                    {!! Form::select("company", $optsCompanies, $case->id_company, array('class'=>"form-control input-sm selCompany hasDependents", 'id'=>"selCompany", 'style'=>"display: inline-block")) !!}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Department', 'Department', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {{--{!! Form::text('case_type',$case->department,['class' => 'form-control input-sm','id' => 'department','disabled' => 'disabled']) !!}--}}
                                    {!! Form::select('department',$departments->where("company",$case->id_company)->pluck(array("name"),"id")->all(),$case->id_department,['class' => 'form-control input-sm selDepartment hasDependents' ,'id' => 'department']) !!}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Case Type', 'Case Type', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {{--{!! Form::text('case_type',$case->case_type,['class' => 'form-control input-sm','id' => 'case_type','disabled' => 'disabled']) !!}--}}
                                    {!! Form::select('case_type',$caseTypes->where("department",$case->id_department)->pluck(array("name"),"id")->all(),$case->id_type,['class' => 'form-control input-sm hasDependents' ,'name' => 'case_type[]','id' => 'case_type']) !!}
                                  </div>
                                </div>
                                <div class="form-group">
                                  {!! Form::label('Case Sub Type', 'Case Sub Type', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {{--{!! Form::text('case_sub_type', $case->case_sub_type,['class' => 'form-control input-sm','id' => 'case_sub_type','disabled' => 'disabled']) !!}--}}
                                    {!! Form::select('case_sub_type',$caseSubTypes->where("case_type",$case->id_type)->pluck(array("name"),"id")->all(),$case->id_sub_type,['class' => 'form-control input-sm' ,'name' => 'case_sub_type[]','id' => 'case_sub_type']) !!}
                                  </div>
                                </div>
                                {{--<div class="form-group">
                                    {!! Form::label('Street Number', 'Street Number', array('class' => 'col-md-6 control-label')) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('street_number',$case->street_number,['class' => 'form-control input-sm','id' => 'street_number','disabled' => 'disabled']) !!}

                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Route', 'Route', array('class' => 'col-md-6 control-label')) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('route',$case->route,['class' => 'form-control input-sm','id' => 'route','disabled' => 'disabled']) !!}

                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('Locality', 'Locality', array('class' => 'col-md-6 control-label')) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('locality',$case->locality,['class' => 'form-control input-sm','id' => 'locality','disabled' => 'disabled']) !!}

                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('Area', 'Area', array('class' => 'col-md-6 control-label')) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('administrative_area_level_1',$case->administrative_area_level_1,['class' => 'form-control input-sm','id' => 'administrative_area_level_1','disabled' => 'disabled']) !!}

                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('Postal Code', 'Postal Code', array('class' => 'col-md-6 control-label')) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('postal_code',$case->postal_code,['class' => 'form-control input-sm','id' => 'postal_code','disabled' => 'disabled']) !!}

                                    </div>
                                </div>


                                <div class="form-group">
                                    {!! Form::label('Country', 'Country', array('class' => 'col-md-6 control-label')) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('country',$case->country,['class' => 'form-control input-sm','id' => 'country','disabled' => 'disabled']) !!}

                                    </div>
                                </div>--}}
                                <div class="form-group">
                                  {!! Form::label('Address', 'Address', array('class' => 'col-md-6 control-label')) !!}
                                  <div class="col-md-6">
                                    {!! Form::textarea('address',$case->address,['class' => 'form-control input-sm autoaddress','id' => 'address', 'rows'=>"4"]) !!}
                                  </div>
                                </div>
																<div class="form-group" style="text-align: right">
																<div class="col-md-12"><button type="submit" id='submitCreateCaseAgentForm' class="btn btn-sm">Update Case</button></div>
																</div>
                                
                                
                                @if($case->img_url != '')
                                  <div class="form-group">
                                    {!! Form::label('Report Image', 'Report Image', array('class' => 'col-md-6 control-label')) !!}
                                    <div class="col-md-6">
                                      <a data-rel="gallery" id="CaseImageA" class="pirobox_gall img-popup" title="">
                                        <img src="{{ asset($case->img_url != '' ? $case->img_url : '/images/no_image.png') }}" alt="" class="superbox-img" id="CaseImage" height="75" style="width: 50px; height: 50px; border: none">
                                      </a>
                                    </div>
                                  </div>
                                @endif
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane" id="0a">
                            <div class="block-area" id="responsiveTable">
                              @if(Session::has('successReferral1'))
                                <div class="alert alert-info alert-dismissable fade in">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  {{ Session::get('successReferral1') }}
                                </div>
                              @endif
                              <div class="table-responsive overflow">
                                <table style="width:928px;" class="table tile table-striped" id="caseActivities">
                                  <thead>
                                  <tr>
                                    <th>Allocated</th>
                                    <th>activity</th>
                                  </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          @endforeach

                          {{-- end  cases   from  compact --}}
                          <div class="tab-pane" id="2a">
                            <table style="width:928px;" class="table tile table-striped" id="relatedCasesTable">
                              <thead>
                              <tr>
                                <th>Case</th>
                                <th>Created at</th>
                                <th>Description</th>
                                <th>Relation</th>
                              </tr>
                              </thead>
                            </table>
                          </div>
                          <div class="tab-pane" id="3a">
                            <div class="block-area" id="responsiveTable">
                              @if(Session::has('successReferral2'))
                                <div class="alert alert-info alert-dismissable fade in">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  {{ Session::get('successReferral2') }}
                                </div>
                              @endif
                              <div class="table-responsive">
                                <table style="width:928px;" class="table tile table-striped dataTable no-footer" id="caseResponders1">
                                  <thead>
                                  <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Accepted</th>
                                    <th>Actions</th>
                                  </tr>
                                  </thead>
                                </table>
                                <br/>
                                <br/>
                                <table style="width:928px;" class="table tile table-striped dataTable no-footer" id="allCaseResponders">
                                  <thead>
                                  <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Accepted</th>
                                    <th>Actions</th>
                                  </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane" id="4a">
                            @if(isset($userAddPoiPermission) && $userAddPoiPermission->permission_id =='30')


                            @endif
                            <div class="rows">
                              <div class="col-md-2"><a class="btn btn-default" onClick="launchPersonOfInterestModal();">Add
                                  Person</a></div>
                            </div>
                            <!-- Responsive Table -->
                            <div class="block-area" id="responsiveTable">
                              <div class="table-responsive">
                                <table style="width:928px;" class="table tile table-striped dataTable no-footer" id="pointListTable">
                                  <thead>
                                  <tr>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Cellphone</th>
                                    <th>Actions</th>
                                  </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane" id="5a">
                            <div class="block-area" id="responsiveTable">
                              <div class="table-responsive overflow">
                                <table style="width:928px;" class="table tile table-striped" id="caseActivitiesTable">
                                  <thead>
                                  <tr>
                                    <th>Created At</th>
                                    <th>activity</th>
                                  </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane" id="6a">
                            <div class="block-area" id="responsiveTable">
                              <div class="table-responsive overflow">
                                <table style="width:728px;" class="table tile table-striped" id="caseNotesTable">
                                  <thead>
                                  <tr>
                                    <th>Created at</th>
                                    <th>Author</th>
                                    <th>Note</th>
                                  </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane" id="7a">
                            <div class="form-group">
                              {!! Form::label('Attach File', 'Case Attachments', array('class' => 'col-md-3 control-label')) !!}
                            </div>
                            <div id="fileManager"></div>
                            {!! Form::close() !!}
                          </div>
                          <div class="tab-pane" id="8a">
                            <table style="width:100%" class="table tile table-striped" id="CaseTasksTable">
                              <thead>
                              <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                              </tr>
                              </thead>
                            </table>
                          </div>

                          <div class="tab-pane" id="9a">
                            <table style="width:100%" class="table tile table-striped" id="caseDronesTable">
                              <thead>
                              <tr>
                                <th>Id</th>
                                <th>Drone Type</th>
                                <th>Drone Sub Type</th>
                                <th>Requested By</th>
                                <th>Status</th>
                                <th>Department Requested a drone</th>
                                <th>Description</th>
                                <th>Action</th>
                              </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                    </div>
                  </center>
                </div>
                <!-- hotel search -->
                <div class="bhoechie-tab-content ">
                  <div id="side_contents1">
                    @include('cases.refer')
                  </div>
                </div>
                <div class="bhoechie-tab-content">
                  <div id="side_contents2">
                    @include('cases.allocate')
                  </div>
                </div>
                <div class="bhoechie-tab-content">
                  <div id="side_contents3">
                    @include('casenotes.add')
                  </div>
                </div>
                <div class="bhoechie-tab-content">
                  <div id="side_contents4">
                    @include('messages.addEmail')
                  </div>
                </div>
                <div class="bhoechie-tab-content">
                  <div id="side_contents5">
                    @include('casefiles.add')
                  </div>
                </div>
                <div class="bhoechie-tab-content">
                  <div id="side_contents6">
                    {{--@include('cases.droneRequest')--}}
                    @include('tasks.createCaseTask')
                  </div>
                </div>
                <div class="bhoechie-tab-content">
                  <div id="side_contents7"></div>
                </div>
                <div class="bhoechie-tab-content">
                  <div id="side_contents8"></div>
                </div>
                <div class="bhoechie-tab-content">
                  <div id="side_contents9">

                 
                    @if($positionId == 9 || $positionId == 10 || $positionId == 11 || $positionId == 12)
                      @include('cases.droneRequest')
                    @else
                      @include('cases.401')
                    @endif
                  </div>
                </div>
                <div class="bhoechie-tab-content">
                  <div id="side_contents10">
                  </div>
                  </div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <!-- Modal Default -->
  <div class="modal modalPoiCase" id="modalPoiCase" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closePOiCase" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id='modalTitle'></h4>
        </div>
        <div class="row">
          <div class="col-md-6"></div>
        </div>
        @if (Session::has('message'))
          <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <div class="modal-body">
          {!! Form::open(['url' => 'addCasePoi', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"poi_CaseForm" ]) !!}
          @if($case)
            <input type="hidden" name="caseID" id="caseID" value="{{ $case->id }}">
          @endif
          <div class="form-group">
            {!! Form::label('Search Box', 'Search Box', array('class' => 'col-md-2 control-label')) !!}
            <div class="col-md-6">
              {!! Form::text('POISearch',null,['class' => 'form-control input-sm','id' => 'POISearch']) !!}
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
              <a type="#" id='submitPoiForm' class="btn btn-sm">Add</a>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-offset-2 col-md-10"></div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  <script>
              $(document).ready(function () {
			$("#task_user_id").tokenInput("{!! url('/getUsers')!!}", {tokenLimit: 1});
			$("#addresses").tokenInput("{!! url('/getUsers')!!}", {tokenLimit: 1});
			$("#addresses1").tokenInput("{!! url('/getUsers')!!}", {tokenLimit: 1});
			$("#Recepient").tokenInput("{!! url('/getAddressBookUsers')!!}", {tokenLimit: 1});
            $("#dronesDepartment").tokenInput("{!! url('/api/v1/userDepartment')!!}",{tokenLimit:1});
			$("#Cc").tokenInput("{!! url('/getAddressBookUsers')!!}", {tokenLimit: 50});
			$("#POISearch").tokenInput("{{ url ('/getPoisContacts')   }}",
				{
					tokenLimit: 1,
					onResult: function (results) {
						if (results.length == 0) {
							var r = confirm("Do want to Capture POI ?");
							var newWindow = window.open();
							if (r == true) {
								var doc_ref = document.location.href;
								var doc_url = doc_ref.substring(0, doc_ref.indexOf("home"));
								doc_url += "add-poi-user";
								//$("#anchorID").attr("href",doc_url);
								//document.getElementById("anchorID").click();
								newWindow.location = doc_url
							}
						}
						return results;
					}
				});
			var id = $("#id").val();
			launchCaseModal(id);
			var case_id ={{$case->id}};
			if ($.fn.dataTable.isDataTable('#relatedCasesTable')) {
				oTableRelatedCases.destroy();
			}
			oTableRelatedCases = $('#relatedCasesTable').DataTable({
				"processing": true,
				"autoWidth": false,
				"pageLength": 5,
				"bLengthChange": false,
				"order": [[0, "desc"]],
				"ajax": "{!! url('/relatedCases-list/')!!}" + '/' + case_id,
				"columns": [
					{
						data: function (d) {
							return "<a href='#' class='btn' onclick=launchRelatedCaseModal(" + d.id + ",2)>" + d.id + "</a>";
						}, "name": 'cases.id'
					},
					{data: 'created_at', name: 'related_cases.created_at'},
					{data: 'description', name: 'cases.description'},
					{
						data: function (d) {
							return 'Child';
						}
					}
				],
				"aoColumnDefs": [
					{"bSearchable": false, "aTargets": [1]},
					{"bSortable": false, "aTargets": [1]}
				]
			});
// poi list
			if ($.fn.dataTable.isDataTable('#pointListTable')) {
				oTablePoi.destroy();
			}
			oTablePoi = $('#pointListTable').DataTable({
				"processing": true,
				"serverSide": true,
				"autoWidth": false,
				"pageLength": 5,
				"bLengthChange": false,
				"order": [[0, "desc"]],
				"ajax": "{!! url('/poi-list/')!!}" + '/' + case_id,
				"columns": [
					{data: 'id', name: 'poi.id'},
					{data: 'name', name: 'poi.name'},
					{data: 'surname', name: 'poi.surname'},
					{data: 'actions', name: 'actions'}
				],
				"aoColumnDefs": [
					{"bSearchable": false, "aTargets": [1]},
					{"bSortable": false, "aTargets": [1]}
				]
			});
// case Note
			if ($.fn.dataTable.isDataTable('#caseNotesTable')) {
				oTableCaseNotes.destroy();
			}
			oTableCaseNotes = $('#caseNotesTable').DataTable({
				"processing": true,
				"serverSide": true,
				"autoWidth": false,
				"pageLength": 5,
				"bLengthChange": false,
				"order": [[0, "desc"]],
				"ajax": "{!! url('/caseNotes-list/')!!}" + '/' + case_id,
				"columns": [
					{data: 'created_at', name: 'created_at'},
					{data: 'user', name: 'user'},
					{data: 'note', name: 'note'}
				],
				"aoColumnDefs": [
					{"bSearchable": false, "aTargets": [1]},
					{"bSortable": false, "aTargets": [1]}
				]
			});
			if ($.fn.dataTable.isDataTable('#caseActivities')) {
				oTableCaseActivities.destroy();
			}
			oTableCaseActivities = $('#caseActivitiesTable').DataTable({
				"processing": true,
				"serverSide": true,
				"autoWidth": false,
				"pageLength": 8,
				"dom": 'T<"clear">lfrtip',
				"order": [[0, "desc"]],
				"ajax": "{!! url('/caseActivities-list/')!!}" + '/' + case_id,
				"columns": [
					{data: 'created_at', name: 'created_at'},
					{data: 'note', name: 'note'}
				],
				"aoColumnDefs": [
					{"bSearchable": false, "aTargets": [1]},
					{"bSortable": false, "aTargets": [1]}
				]
			});
			if ($.fn.dataTable.isDataTable('#CaseTasksTable')) {
                      oTableTasksTable.destroy();
                  }
                  oTableTasksTable = $('#CaseTasksTable').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "autoWidth": false,
                      "pageLength": 5,
                      "bLengthChange": false,
                      "order": [[0, "desc"]],
                      "ajax": "{!! url('/getCaseTasks/')!!}" + '/' + case_id,
                      "columns": [
                          {data: 'tasks.id', name: 'tasks.id'},
                          {data: 'tasks.title', name: 'tasks.title'},
                          {data: 'tasks.description', name: 'tasks.description'},
                          {data: 'tasks.commencement_date', name: 'tasks.commencement_date'},
                          {data: 'tasks.due_date', name: 'tasks.due_date'},
                          {data: 'actions', name: 'actions'},
                      ],
                      "aoColumnDefs": [
                          {"bSearchable": false, "aTargets": [1]},
                          {"bSortable": false, "aTargets": [1]}
                      ]
                  });

// Case DroneRequests
                  if ($.fn.dataTable.isDataTable('#caseDronesTable')) {
                      oTableTasksTable.destroy();
                  }
                  oTableTasksTable = $('#caseDronesTable').DataTable({
                      "processing": true,
                      "serverSide": true,
                      "autoWidth": false,
                      "pageLength": 5,
                      "bLengthChange": false,
                      "order": [[0, "desc"]],
                      "ajax": "{!! url('/getCaseDrones/')!!}" + '/' + case_id,
                      "columns": [
                          {data: 'id', name: 'id'},
                          {data: 'DroneType', name: 'DroneType'},
                          {data: 'DroneSubType', name: 'DroneSubType'},
                          {data: 'CreatedBy', name: 'CreatedBy'},
                          {data: 'CaseStatus', name: 'CaseStatus'},
                          {data: 'Department', name: 'Department'},
                          {data: 'notes', name: 'notes'},
                          {data: 'actions', name: 'actions'}
                      ],
                      "aoColumnDefs": [
                          {"bSearchable": false, "aTargets": [1]},
                          {"bSortable": false, "aTargets": [1]}
                      ]
                  });
// case  note
			if ($.fn.dataTable.isDataTable('#caseResponders1'))
			{
				oTableCaseResponders1.destroy();
			}
			oTableCaseResponders1 = $('#caseResponders1').DataTable({
				"processing": true,
				"serverSide": true,
				"autoWidth": false,
				"pageLength": 8,
				"bInfo": false,
				"paging": false,
				"searching": false,
				"dom": 'T<"clear">lfrtip',
				"order": [[0, "asc"]],
				"ajax": "{!! url('/caseResponders-list/')!!}" + '/' + case_id,
				"columns": [
					{
						data: function (d) {
							if (d.type == 1) {
								return "First Responder";
							}
							if (d.type == 0) {
								return "Reporter";
							}
							if (d.type == 2) {
								return "Second Responder";
							}
							if (d.type == 3) {
								return "Third Responder";
							}
							if (d.type == 4) {
								return "Escalation";
							}
							if (d.type == 5) {
								return "Critical Team";
							}
						}, "name": 'type'
					},
					{
						data: function (d) {
							return d.name + ' ' + d.surname;
						}, "name": 'name'
					},
					{
						data: function (d) {
							if (d.accept == 1) {
								return "yes";
							}
							else {
								return "no";
							}
						}, "name": 'accept'
					},
					{data: 'actions', name: 'actions'},
				],
				"aoColumnDefs": [
					{"bSortable": false, "aTargets": [1]}
				]
			});
			if ($.fn.dataTable.isDataTable('#allCaseResponders')) {
				oTableAllCaseResponders.destroy();
			}
			oTableAllCaseResponders = $('#allCaseResponders').DataTable({
				"processing": true,
				"serverSide": true,
				"autoWidth": false,
				"pageLength": 8,
				"bInfo": false,
				"paging": false,
				"searching": false,
				"dom": 'T<"clear">lfrtip',
				"order": [[0, "asc"]],
				"ajax": "{!! url('/allCaseResponders-list/')!!}" + '/' + case_id,
				"columns": [
					{
						data: function (d) {
							if (d.type == 1) {
								return "First Responder";
							}
							if (d.type == 0) {
								return "Reporter";
							}
							if (d.type == 2) {
								return "Second Responder";
							}
							if (d.type == 3) {
								return "Third Responder";
							}
							if (d.type == 4) {
								return "Escalation";
							}
							if (d.type == 5) {
								return "Critical Team";
							}
						}, "name": 'type'
					},
					{
						data: function (d) {
							return d.name + ' ' + d.surname;
						}, "name": 'name'
					},
					{
						data: function (d) {
							if (d.accept == 1) {
								return "yes";
							}
							else {
								return "no";
							}
						}, "name": 'accept'
					},
					{data: 'actions', name: 'actions'},
				],
				"aoColumnDefs": [
					{"bSortable": false, "aTargets": [1]}
				]
			});
			$("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
				console.log("bhoechie-tab-menu.click(e) e - ", e);
				e.preventDefault();
				$(this).siblings('a.active').removeClass("active");
				$(this).addClass("active");
				var index = $(this).index();
				$("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
				$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
			});

			hides();
		});

              function shows(ev, index) {
                  console.log("shows(ev) index - ", index, ", ev - ", ev);
                  var index2 = index;
                  var elShow = document.getElementById('side_contents' + (index2));
                  var elTab = $(elShow).parents(".bhoechie-tab-content");
                  console.log("elShow - ",elShow);
                  console.log("elTab", elTab);
                  hides(ev);

                  $(elShow).show();
                  $(elTab[0]).show();
                  return;
              }

//              function shows(ev, index) {
//			console.log("shows(ev) index - ", index, ", ev - ", ev);
//			var index2 = index - 2;
////                        document.getElementById("side_navs").style.display="block";
////                        document.getElementById("top_navs_action").className="bhoechie-tab-content";
////                        document.getElementById('side_contents1').style.display="block";
////                        document.getElementById('side_contents2').style.display="block";
////                        document.getElementById('side_contents3').style.display="block";
////                        document.getElementById('side_contents4').style.display="block";
////                        document.getElementById('side_contents5').style.display="block";
//			document.getElementById('side_contents' + (index2)).style.display = "block";
//			document.getElementById('side_contents' + (index2)).style.display = "block";
//			document.getElementById('side_contents' + (index2)).style.display = "block";
//			document.getElementById('side_contents' + (index2)).style.display = "block";
//			document.getElementById('side_contents' + (index2)).style.display = "block";
//			document.getElementById('side_contents' + (index2)).style.display = "block";
//			document.getElementById('side_contents' + (index2)).style.display = "block";
//			document.getElementById('side_contents' + (index2)).style.display = "block";
//            document.getElementById('side_contents' + (index2)).style.display = "block";
//            document.getElementById('side_contents' + (index2)).style.display = "block";
//            document.getElementById('side_contents' + (index2)).style.display = "block";
//			document.getElementById("top_navs_action").className = "bhoechie-tab-content active";
//			//location.reload()
//			  //document.getElementById("side_navs").style.display="block";
//			//document.getElementById('case').className="list-group-item text-center active";
//			//  document.getElementById("top_navs_action").className="bhoechie-tab-content ";
//			//  document.getElementById('side_contents').style.display="block";
//			//  document.getElementById('side_contents2').style.display="block";
//			//   document.getElementById('side_contents3').style.display="block";
//		}
		function launchPersonOfInterestModal(id) {
			var sub_category = 1
			var formData = {sub_category: sub_category};
			$.ajax({
				type: "GET",
				data: formData,
				url: "{!! url('/getPois')!!}",
				success: function (data) {
					if (data.length > 0) {
						$("#submitAllocateCaseForm").removeClass("hidden");
					}
					else {
						$("#submitAllocateCaseForm").addClass("hidden");
					}
					var content = "";
					$.each(data, function (key, element) {
						content += "<tr><td><a class='remove fa fa-trash-o'></a><div class='checkbox m-b-5'><label><input type='checkbox'";
						content += "name='responders' id='responders' value=" + element.id + " class='pull-left list-check'>";
						content += "</label></div></td><td>" + element.name + "</td><td>" + element.surname + "</td><td>" + element.email;
					});
					$("#POITableBody").html(content);
					if (data == 'ok') {
					}
				}
			});
			// $('#modalCase').modal('hide');
			$('#modalPoiCase').modal('toggle');
		}


//              $('#drone_type_id').on('change',function()
//              {
//                  var id = this.value;
//                  $('#sub_drone_type_id').empty();
//                  // var DroneServices = [];
//                  $.get('droneSubType/'+ id,function(response){
//                      $('#sub_drone_type_id').append("<option  selected disabled>Select Drone service</option>");
//                      $.each(response,function(key,value)
//                      {
//                          $('#sub_drone_type_id').append("<option  value="+value.id+">"+value.name+"</option>");
//                      });
//
//
////                    document.getElementById("sub_drone_type_id").innerHTML="<option selected disabled>Select Drone Service</option>";
////                    for(var i= 0; i < DroneServices.length;i++)
////                    {
////                        document.getElementById("sub_drone_type_id").innerHTML+="<option  id='options' onchange='getId();' value = "+DroneServices[i].id+">"+DroneServices[i].name+"</option>";
////                    }
////                    function getId() {
////                     var selectedval  = document.getElementById("options").value();
////                     console.log(selectedval);
////                    }
////
////                }
//                  });
//              });


              $('#drone_type_id').on('change', function () {
                  var id = this.value;
                  $('#sub_drone_type_id').empty();
                  $.get('droneSubType/' + id, function (response) {
                      $('#sub_drone_type_id').append("<option  selected disabled>Select Drone Type</option>");
                      $.each(response, function (key, value) {
                          $('#sub_drone_type_id').append("<option  value=" + value.id + ">" + value.name + "</option>");
                      });
                  });
              });
              $('#sub_drone_type_id').on('change', function () {
                  var id = this.value;
                  $('#drone_service_type_id').empty();
                  $.get('droneServiceType/' + id, function (response) {
                      $('#drone_service_type_id').append("<option  selected disabled>Select Drone service</option>");
                      $.each(response, function (key, value) {
                          $('#drone_service_type_id').append("<option  value=" + value.id + ">" + value.name + "</option>");
                      });
                  });
                  var selectText = $(this).find("option:selected").text();
                  if (selectText == 'Real Time') {
                      $('.realTime').removeClass('hidden');
                      $('.scopeOfWOrk').removeClass('hidden');
                      $('.Notes').removeClass('hidden');
                      $("#service").removeAttr('disabled');
                      $("#scope_of_work").removeAttr('disabled');
                      $("#notes").removeAttr('disabled');
                      $('.droneService').addClass('hidden');
                      $("#drone_service_type_id").attr('disabled', 'disabled');
                  } else {
                      $('.realTime').addClass('hidden');
                      $('.scopeOfWOrk').addClass('hidden');
                      $('.Notes').addClass('hidden');
                      $("#service").attr('disabled', 'disabled');
                      $("#scope_of_work").attr('disabled', 'disabled');
                      $("#notes").attr('disabled', 'disabled');
                      $('.droneService').removeClass('hidden');
                      $("#drone_service_type_id").removeAttr('disabled');
                  }
              });
              $('#drone_service_type_id').on('change', function () {
                  var id = this.value;
                  $('#drone_sub_service_type_id').empty();
                  $.get('droneSubServiceType/' + id, function (response) {
                      $('#drone_sub_service_type_id').append("<option  selected disabled>Select Drone Sub Service</option>");
                      $.each(response, function (key, value) {
                          $('#drone_sub_service_type_id').append("<option  value=" + value.id + ">" + value.name + "</option>");
                      });
                  });
                  var selectId   =$(this).find("option:selected").val();
                  var selectText = $(this).find("option:selected").text();
                  //Aquatic -> ad Hoc
                  if (selectText == 'Auxiliary Services') {
                      $('.droneSubService').removeClass('hidden');
                      $('.auxiliaryServices').removeClass('hidden');
                      $('.scopeOfWOrk').removeClass('hidden');
                      $('.Notes').removeClass('hidden');
                      $("#drone_sub_service_type_id").removeAttr('disabled');
                      $("#interest").removeAttr('disabled');
                      $("#scope_of_work").removeAttr('disabled');
                      $("#notes").removeAttr('disabled');
                  }
                  // Aerial ->ad Hoc
                  else if(selectId == 6 && selectText == 'Inspection'){
                      $('.droneSubService').removeClass('hidden');
                      $('.auxiliaryServices').removeClass('hidden');
                      $('.scopeOfWOrk').removeClass('hidden');
                      $('.Notes').removeClass('hidden');
                      $("#drone_service_type_id").removeAttr('disabled', 'disabled');
                      $("#interest").removeAttr('disabled', 'disabled');
                      $("#scope_of_work").removeAttr('disabled', 'disabled');
                      $("#notes").removeAttr('disabled', 'disabled');
                      $('.purposeOfSurvey').addClass('hidden');
                      $('.verticalAccuracy').addClass('hidden');
                      $('.numberOfStockPile').addClass('hidden');
                      $('.surveys').removeClass('hidden');
                  }
                  else if(selectText =='Surveys'){
                      $('.droneSubService').removeClass('hidden');
                      $('.scopeOfWOrk').addClass('hidden');
                      $('.Notes').addClass('hidden');
                      $('.auxiliaryServices').addClass('hidden');

                }
                  //Aquatic -> ad Hoc
                  else if(selectText =='Hydrographic Survey' || selectText=='Hydrographic Solar Scanning'){
                      //initMap().load();
                      $('.scopeOfWOrk').removeClass('hidden');
                      $('.surveys').removeClass('hidden');
                      $('.Notes').removeClass('hidden');
                      $('.purposeOfSurvey').addClass('hidden');
                      $('#scope_of_work').removeAttr('disabled','disabled');
                      $("#notes").removeAttr('disabled','disabled');}
                  else if(selectId == 4 && selectText=='Inspection'){
                      $('.auxiliaryServices').removeClass('hidden');
                      $('.scopeOfWOrk').removeClass('hidden');
                      $('.Notes').removeClass('hidden');
                      $('.purposeOfSurvey').addClass('hidden');
                   $('.surveys').removeClass('hidden');
                      $("#interest").removeAttr('disabled', 'disabled');
                      $("#scope_of_work").removeAttr('disabled');
                      $("#notes").removeAttr('disabled');
                  }
                  else if(selectText == 'Film and Photography' || selectText == 'Infrastructure Assessment')
                  {
                      $('.auxiliaryServices').removeClass('hidden');
                      $('.scopeOfWOrk').removeClass('hidden');
                      $('.Notes').removeClass('hidden');
                      $("#interest").removeAttr('disabled', 'disabled');
                      $("#scope_of_work").removeAttr('disabled', 'disabled');
                      $("#notes").removeAttr('disabled', 'disabled');
                      $('.purposeOfSurvey').addClass('hidden');
                      $('.surveys').removeClass('hidden');
                      $('.verticalAccuracy').addClass('hidden');
                      $('.droneSubService').addClass('hidden');
                  }
                  else{
                      $('.surveys').removeClass('hidden');
                      $('.purposeOfSurvey').removeClass('hidden');
                      $('.Notes').removeClass('hidden');
                      $("#notes").removeAttr('disabled', 'disabled');
                      $("#purpose_of_survey").removeAttr('disabled', 'disabled');
                      $('.auxiliaryServices').addClass('hidden');
                      $('.scopeOfWOrk').addClass('hidden');
                      $('.droneSubService').addClass('hidden');
                  }
              });
              $('#drone_sub_service_type_id').on('change', function () {
                  var selectText = $(this).find("option:selected").text();
                  //Aerial ->ad Hoc ->Surveys
                  if(selectText == 'Stockpile Surveys'){
                      $('.surveys').removeClass('hidden');
                      $('.purposeOfSurvey').removeClass('hidden');
                      $('.verticalAccuracy').addClass('hidden');
                      $('.scopeOfWOrk').addClass('hidden');
                      $('.auxiliaryServices').addClass('hidden');
                      $('.numberOfStockPile').removeClass('hidden');
                      $('.Notes').removeClass('hidden');
                      $("#purpose_of_survey").removeAttr('disabled', 'disabled');
                      $("#number_of_stockpiles").removeAttr('disabled', 'disabled');
                      $("#notes").removeAttr('disabled', 'disabled');
                  }else if(selectText =='Water Sampler' ||selectText =='Sediment Sampler' ||selectText =='Net Repairer' ||selectText =='Cut Attachment'||selectText =='Thermal Inspection'||selectText =='Industrial Inspection')
                  {
                      $('.verticalAccuracy').addClass('hidden');
                  }
                  else{
                      $('.surveys').removeClass('hidden');
                      $('.purposeOfSurvey').removeClass('hidden');
                      $('.Notes').removeClass('hidden');
                      $('.numberOfStockPile').addClass('hidden');
                      $('.verticalAccuracy').removeClass('hidden');
                      $("#vertical_accuracy").removeAttr('disabled', 'disabled');
                      $("#purpose_of_survey").removeAttr('disabled', 'disabled');
                      $("#number_of_stockpiles").removeAttr('disabled', 'disabled');
                      $("#notes").removeAttr('disabled', 'disabled');
                  }
              });
              var  count =0;
              function showMap()
              {
                  count+=1;
                  if(count==1)
                  {
                      initMap().load();
                  }
              }


                function initMap() {
            map = new google.maps.Map(document.getElementById('map'),
                {

                    center: {lat: -29.8579 , lng:31.0292},
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.RoadMap
                });
            var p = document.getElementById('geoFenceCoords').value.replace(/%20/g, ',');
            var point = p.substr(10, p.length - 1);
            var gFance = point.substr(0, point.indexOf('),'));
            var points = gFance.split(", ");
            var CoordsPath = points.map(function (points) {
                var latlon = points.split(' ');

                return new google.maps.LatLng(latlon[0], latlon[1]);
            });


            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });


            if (CoordsPath != "(0, NaN)") {
                drawingManager = new google.maps.drawing.DrawingManager({
                    drawingControl: true,
                    drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: [
                             'polygon'

                        ]
                    },
                    polygonOptions: doPolygon(map)
                });
            } else {
                drawingManager = new google.maps.drawing.DrawingManager({

                    drawingControl: true,
                    drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: [
                             'polygon'
                        ]
                    },
                    polygonOptions: {
                        geodesic: true,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 2,
                        clickable: true,
                        editable: true,
                        zIndex: 1
                    }
                });

                drawingManager.setMap(map);
                google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
                    openInfoWindowPolygon(polygon);
                });

                var  count =0;
                google.maps.event.addListener(map, 'click', function(event) {
                    count+=1;
                    if(count==1)
                    {
                        placeMarker(map, event.latLng);
                    }
                });

            }
        }

        function placeMarker(map, location) {

            var marker = new google.maps.Marker({
                position: location,
                map: map
            });

            var infowindow = new google.maps.InfoWindow({
                content: '<span style="color:black;">'+ 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()+'</span>'

            });
            var markerCoordinates  = (location.lat()+","+location.lng());

            infowindow.open(map,marker);
            document.getElementById('markerCoordinates').value = markerCoordinates;

        }
        function openInfoWindowPolygon(polygon){
            poly1 = polygon;

            var vertices = polygon.getPath();
            //textbox receive coordinates
            document.getElementById('geoFenceCoords').value = polygon.getPath();

            var bounds = new google.maps.LatLngBounds();
            vertices.forEach(function (xy, i) {
                bounds.extend(xy);
                document.getElementById('geoFenceCoords').value += xy+"_";
            });
            vertices.forEach(function (xy, i)
            {
                bounds.extend(xy);
            });
            drawingManager.setDrawingMode(null);
            infoWindow.open(map);
        }
        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map,marker2);
        }

             

		$("#submitPoiForm").on("click", function () {
			var pois = $("#poi_CaseForm #POISearch").val();
			var token = $('input[name="_token"]').val();
			var caseID = $("#poi_CaseForm #caseID").val();
			var formData = {
				pois: pois,
				caseID: caseID
			};
			$('#modalPoiCase').modal('toggle');
			$.ajax({
				type: "POST",
				data: formData,
				headers: {'X-CSRF-Token': token},
				url: "{!! url('/addCasePoi')!!}",
				beforeSend: function () {
					HoldOn.open({
						theme: "sk-rect",//If not given or inexistent theme throws default theme sk-rect
						message: "<h4> loading please wait... ! </h4>",
						content: "Your HTML Content", // If theme is set to "custom", this property is available
																					// this will replace the theme by something customized.
						backgroundColor: "none repeat scroll 0 0 rgba(0, 0, 0, 0.8)",//Change the background color of holdon with javascript
						// Keep in mind is necessary the .css file too.
						textColor: "white" // Change the font color of the message
					});
				},
				success: function (data) {
					if (data.status == 'ok') {
						$(".token-input-token").remove();
						$('#poi_CaseForm')[0].reset();
						$("#caseNotesNotification").html('<div class="alert alert-success alert-icon">Well done! POI has been successfully added <i class="icon">&#61845;</i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>');
						launchCaseModal(caseID);
						//$('#modalCase').modal('toggle');
						// window.location.replace(+caseID);
						HoldOn.close();
					}
				}
			})
		});
		function hides(ev) {
			console.log("hides(ev) ev - ", ev);
			//document.getElementById("side_navs").style.display="none";
            // document.getElementById('side_contents1').style.display = "none";
			document.getElementById('side_contents1').style.display = "none";
			document.getElementById('side_contents2').style.display = "none";
			document.getElementById('side_contents3').style.display = "none";
			document.getElementById('side_contents4').style.display = "none";
			document.getElementById('side_contents5').style.display = "none";
			document.getElementById('side_contents6').style.display = "none";
			document.getElementById('side_contents7').style.display = "none";
			document.getElementById('side_contents8').style.display = "none";
            document.getElementById('side_contents9').style.display = "none";
           // document.getElementById('side_contents10').style.display ="none";
			document.getElementById("top_navs_action").className = "bhoechie-tab-content active";
		}
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwXS96_uM6y-6ZJZhSJGE87pO-qxpDp-Q&libraries=drawing&callback=initMap" async defer></script>
@endsection


