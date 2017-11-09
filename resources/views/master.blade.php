<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler");
else ob_start(); ?>
<?php
$title = env("SITE_NAME", "Test");
$title .= " (" . $_SERVER['HTTP_HOST'] . ")";
$title .= " - " . Route::getCurrentRoute()->getUri();
?>
  <!DOCTYPE html><!--[if IE 9 ]>
<html class="ie9"><![endif]-->
<head>
  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
  <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
  <meta name="format-detection" content="telephone=no">
  <meta charset="UTF-8">
  <meta name="description" content="Aims Safis Case Console Management">
  <meta name="keywords" content="Aims Safis Case Console System,Incidents Management System">
  <link rel="icon" type="image/x-icon" sizes="16x16" href="{{ asset('/img/SiteBadge3.png') }}">
  <title>{{ $title }}</title>
  <!-- CSS -->
  <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/form.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/generics.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/token-input.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/icons.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/lightbox.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('/css/media-player.css') }}" rel="stylesheet"> -->
  <link href="{{ asset('/css/file-manager.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/buttons.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/HoldOn.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/bootstrap-switch.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/incl/animate.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/Treant.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/collapsable.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('/css/perfect-scrollbar.css') }}" rel="stylesheet"> -->
  <link href="{{ asset('/css/form-builder.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/awesome.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/table.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/toggles.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/toggle-themes/toggles-all.css') }}" rel="stylesheet">
  <!-- DataTables CSS -->
  <link href="{{ asset('/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">
  <!-- DataTables Responsive CSS -->
{{--<link href="{{ asset('/bower_components/datatables-responsive/css/responsive.dataTables.scss') }}" rel="stylesheet">--}}
<!-- jQuery Library -->
  <script src="{{ asset('/js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwXS96_uM6y-6ZJZhSJGE87pO-qxpDp-Q&libraries=geometry,places"></script>
  {{--<script>--}}

  {{--$(document).ready(function() {--}}
  {{--jQuery.migrateMute = true;--}}
  {{--});--}}


  {{--$(document).ready(function() {--}}
  {{--jQuery.migrateMute = true;--}}
  {{--$.fn.dataTable.ext.errMode = 'none';--}}
  {{--});--}}

  {{--</script>--}}
  <script>
    var placeSearch, autocomplete;
    var componentForm = {
      street_number: 'short_name',
      route: 'long_name',
      locality: 'long_name',
      administrative_area_level_1: 'short_name',
      country: 'long_name',
      postal_code: 'short_name'
    };
  </script>
   
  <style>
    body {
        background-color: #5c788f;
    }
      .eerross {
          background-image: url("{{ asset('public/img/01_fix_background.png') }}");
      width: 100%;
      height: 100%;
    }
    .has-error .help-block, .has-error .control-label, .has-error .radio, .has-error .checkbox, .has-error .radio-inline, .has-error .checkbox-inline {
          color:#FE1B1B;
      }
      [ v-cloak]{
          display:none;
      }
  </style>

  <!-- report css -->
  <style>
         .date-div
         {
            width: 50% ; float: left;
         }
         .date-txt
         {
            width: 40% ; float: right;
         }
         #datepicker-8 , #datepicker-9
         {
            color: blue;    
         }
         .sizing-row
         {
            width: 180px;
         }
         #label-f
         {
             width: 80% ;
             height: 30px;
             margin-bottom: 3px;
             background-color: white;
             color :black;
             text-align: center;
             float: left;
         }
         #check-box
         {
            width: 18% ;
            height: 20px;
            margin-bottom: 3px;
            float: right;"
         }
        
         #check-box ,#check_box
         {
            width: 18% ;
            height: 20px;
            margin-bottom: 3px;
            float: right;"
         }

         .dept-selection , .predict-selection
         {
            width: 100%;
            height: 200px;
         }
         #departments , #department-selected ,#predict , #predict-selected
         {
            width: 40%;
            display: block;
            margin: 0;
            height: 100%;
            overflow-x: hidden;
            overflow-y: scroll;
            
         }
         #department-btns ,#predict-btns
         {
            width: 20%;
            display: block;
            height: 80%;
            float: right;
         }
         #departments , #predict 
         {
            float: left;
         }
         #department-selected , #predict-selected
         {
            float: right;
             padding-top:0px;
             background-color: gray;
         }

         #departments::-webkit-scrollbar ,#department-selected::-webkit-scrollbar ,#predict::-webkit-scrollbar ,#predict-selected::-webkit-scrollbar
         {
             width:5px;
         }
         #departments::-webkit-scrollbar-thumb, #department-selected::-webkit-scrollbar-thumb,#predict::-webkit-scrollbar-thumb , #predict-selected::-webkit-scrollbar-thumb
         {
             border-radius: 1px;
             background: rgba(0,0,0,0);
             background-color: grey;
         }
        #department-selected::-webkit-scrollbar-thumb, #predict-selected::-webkit-scrollbar-thumb
         {
             background-color:white;
         }
         #department-list , #predict-list
         {
             width:100%;
             height:40px;
             padding-left: 0px;
             margin-top: 0px;
             padding-top: 0px;
             margin-bottom: 0px;
         }
         
         
        .municipality , .btAdds
         {
            width:100%;
            height:100%;
            margin: 0px;
         }
         .crud
         {
            width:90%;
            height:24%;
            margin-left:5%; 
            margin-top: 5px;
            color:default;
         }
         .btnAdded
         {
            text-align: center;
         }
        </style>
  <!-- end -->
</head>
<body>
  @if(!\Auth::check())
    @yield('content')
  @else
    <header id="header" class="media">
      <a href="" id="menu-toggle"></a>
      <div class="logo pull-left" href="#"></div>
      <div class="media-body">
        <div class="media" id="top-menu">
          <div class="pull-left tm-icon">
            <a data-drawer="messages" class="drawer-toggle">
              <i class="fa fa-envelope-o fa-2x"></i>
              <i class="n-count animated" id='countPrivateMessages'>{{ count($noPrivateMessages,0) }}</i>
            </a>
          </div>
          <div class="pull-left tm-icon">
            <a href="{{ url('addressbookList/'. Auth::user()->id) }}">
              <i class="fa fa-book fa-2x"></i>
              <i class="n-count animated">{{ count($addressBookNumber,0) }}</i>
            </a>
          </div>
          <div id="time" class="pull-right">
            <span id="hours"></span>
            :
            <span id="min"></span>
            :
            <span id="sec"></span>
          </div>
        </div>
      </div>
    </header>

    <div class="clearfix"></div>

    <section id="main" class="p-relative" role="main">
      <!-- Sidebar -->
      <aside id="sidebar">
        <!-- Sidbar Widgets -->
        <div class="side-widgets overflow">
          <!-- Profile Menu -->
          <div class="text-center s-widget m-b-25 dropdown" id="profile-menu">
            <a href="#" data-toggle="dropdown">
              <img class="profile-pic animated" src="{{ asset('public/img/sites_badge.png') }}" alt="Transet Ports">
            </a>
            <ul class="dropdown-menu profile-menu">
              {{--<li><a href="{{ url('all-messages') }}">Messages</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>--}}
              <li><a href="{{ url('user-profile') }}">Profile</a> <i class="icon left">
                  &#61903;</i><i class="icon right">&#61815;</i></li>
              <li><a href="{{ url('/auth/logout') }}">Sign Out</a> <i class="icon left">
                  &#61903;</i><i class="icon right">&#61815;</i></li>
            </ul>
            @if (Auth::user())
              <h4 class="m-0">
                {{ Auth::user()->name }}  {{ Auth::user()->surname }}
              </h4>
              {{ $systemRole ? $systemRole->name : 'Unknown Role' }}<br>
              {{ Auth::user()->email }}
            @endif
          </div>
        @if (Request::is('message-detail/*') || Request::is('all-messages'))
          @include('messages.message-widget')
        @endif

        <!-- Calendar -->
          <div class="s-widget m-b-25">
            <div id="sidebar-calendar"></div>
          </div>
          <div class="tile">
            <h2 class="tile-title"><i class="glyphicon glyphicon-credit-card"></i> TASKS
              <div class="pull-right">
                <a href="{{ url('tasks') }}">
                  Total.....<i class="n-count animated">{{ count($allTasks,0) }}</i>
                </a>
              </div>
            </h2>
            <div class="listview narrow">
              @foreach($tasks as $task)
                <div class="media p-l-5">
                  <div class="pull-left">
                    <span class='label label-danger'>{{$task->task->status->name}}</span>
                  </div>
                  <div class="media-body">
                    <a class="t-overflow" href="{{ url('tasks/'.$task->task->id) }}">{{ $task->task->title }} </a><br/>
                    <small class="text-muted">{{ $task->created_at->diffForHumans() }} </small>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="media text-center whiter l-100">
              <a href="{{ url('/tasks') }}">
                <small>VIEW ALL</small>
              </a>
            </div>
          </div>
        </div>
        <!-- Side Menu -->
        <ul class="list-unstyled side-menu">
          @if(isset($userViewCasesPermission) && $userViewCasesPermission->permission_id =='15')
            <li {{ (Request::is('home') ? "class=active" : '') }}>
              <a class="sa-side-homepage" href="{{ url('home') }}">
                <span class="menu-item">Home</span>
              </a>
            </li>
          @endif

          @if(isset($userViewCasesPermission) && $userViewCasesPermission->permission_id =='15')
            {{--<li {{ (Request::is('home') ? "class=active" : '') }}>--}}
            {{--<a class="sa-side-folder" href="{{ url('home') }}">--}}
            {{--<span class="menu-item">My Cases</span>--}}
            {{--</a>--}}
            {{--</li>--}}



            <li class="dropdown">
              <a class="sa-side-folder" href="">
                <span class="menu-item">My Cases </span>
              </a>
              <ul class="list-unstyled menu-item">
                @if(isset($userViewDepartmentsPermission) && $userViewDepartmentsPermission->permission_id =='4')





                  <li><a href="{{ url('creatCase') }}"><span class="badge badge-r"></span>Create</a></li>
                  <li><a href="{{ url('allCases') }}"><span class="badge badge-r"></span>All</a></li>
                  <li><a href="{{ url('allocatedCases') }}"><span class="badge badge-r"></span>Allocated/Referred</a>
                  </li>
                  <li><a href="{{ url('pendingCases') }}"><span class="badge badge-r"></span>Pending Allocation</a></li>
                  <li><a href="{{ url('pendingClosureCases') }}"><span class="badge badge-r"></span>Pending Closure</a>
                  </li>
                  <li><a href="{{ url('closedCases') }}"><span class="badge badge-r"></span>Resolved</a></li>

                @endif
              </ul>
            </li>
          @endif

          @if(isset($userViewReportsPermission) && $userViewReportsPermission->permission_id =='16')
            <li {{ (Request::is('Meetings') ? "class=active" : '') }}>
              <a class="sa-side-list" href="{{ url('tasks') }}">
                <span class="menu-item">My Tasks</span>
              </a>
            </li>
          @endif

          @if(isset($userViewCalendarPermission) && $userViewCalendarPermission->permission_id =='13')
            <li {{ (Request::is('calendar') ? "class=active" : '') }}>
              <a class="sa-side-calendar" href="{{ url('calendar/events') }}">
                <span class="menu-item">Calendar</span>
              </a>
            </li>
          @endif

          @if(isset($userViewReportsPermission) && $userViewReportsPermission->permission_id =='16')
            <li {{ (Request::is('list-meetings') ? "class=active" : '') }}>
              <a class="sa-side-widget" href="{{ url('list-meetings') }}">
                <span class="menu-item">Meetings</span>
              </a>
            </li>
          @endif

          @if(isset($userViewReportsPermission) && $userViewReportsPermission->permission_id =='16')
            <li {{ (Request::is('list-poi-users') ? "class=active" : '') }}>
              <a class="sa-side-photos" style="background-image: url({{ asset('images/icon_poi.png') }}); background-size: 80%" href="{{ url('list-poi-users') }}">
                <span class="menu-item">Poi</span>
              </a>
            </li>
          @endif

          @if(isset($userViewCalendarPermission) && $userViewCalendarPermission->permission_id =='13')
            <li {{ (Request::is('map') ? "class=active" : '') }}>
              <a class="sa-side-home" href="{{ url('maps') }}">
                <span class="menu-item">map</span>
              </a>
            </li>
          @endif

          @if(isset($userViewReportsPermission) && $userViewReportsPermission->permission_id =='16')
            <li {{ (Request::is('reports') ? "class=active" : '') }}>
              <a class="sa-side-chart" href="{{ url('report') }}">
                <span class="menu-item">Reports</span>
              </a>
            </li>
          @endif

          @if(isset($userViewAdministrationPermission) && $userViewAdministrationPermission->permission_id =='14')
            <li class="dropdown">
              <a class="sa-side-ui" href="">
                <span class="menu-item">Settings </span>
              </a>
              <ul class="list-unstyled menu-item">
                <li><a href="{{ url('list-companies') }}"><span class="badge badge-r"></span>Companies</a></li>
                <!--<li><a href="#"><span class="badge badge-r"></span>Clients</a></li>-->
                @if(isset($userViewDepartmentsPermission) && $userViewDepartmentsPermission->permission_id =='4')


                  <li><a href="{{ url('list-departments') }}"><span class="badge badge-r"></span>Departments</a></li>

                @endif

                @if(isset($userViewPositionsPermission) && $userViewPositionsPermission->permission_id =='6')

                  <li><a href="{{ url('list-positions') }}"><span class="badge badge-r"></span>Positions</a></li>

                @endif


                @if(isset($userViewAffiliationPermission) && $userViewAffiliationPermission->permission_id =='1')
                  <li><a href="{{ url('list-affiliations') }}"><span class="badge badge-r"></span>Affiliation</a></li>
                @endif

                {{--@if(isset($userViewCasePriorityPermission) && $userViewCasePriorityPermission->permission_id =='2')--}}
                {{--<li><a href="{{ url('list-priorities') }}"><span class="badge badge-r"></span>Cases Priorities</a></li>--}}
                {{--@endif--}}

                {{--@if(isset($userViewCaseStatusPermission) && $userViewCaseStatusPermission->permission_id =='3')--}}

                {{--<li><a href="{{ url('list-statuses') }}"><span class="badge badge-r"></span>Cases Statuses</a></li>--}}

                {{--@endif--}}



                {{--@if(isset($userViewMeetingsPermission) && $userViewMeetingsPermission->permission_id =='5')--}}

                {{--<li><a href="{{ url('list-meetings') }}"><span class="badge badge-r"></span>Meetings</a></li>--}}

                {{--@endif--}}


                {{--@if(isset($userViewProvincesPermission) && $userViewProvincesPermission->permission_id =='7')--}}

                {{--<li><a href="{{ url('list-provinces') }}"><span class="badge badge-r"></span>Provinces</a></li>--}}
                {{--@endif--}}
                {{--@if(isset($userViewRelationshipsPermission) && $userViewRelationshipsPermission->permission_id =='8')--}}
                {{--<li><a href="{{ url('list-relationships') }}"><span class="badge badge-r"></span>Relationships</a></li>--}}
                {{--@endif--}}

                @if(isset($userViewUsersPermission) && $userViewUsersPermission->permission_id =='10')

                  <li><a href="{{ url('list-users') }}"><span class="badge badge-r"></span>Users</a></li>
                @endif

                @if(isset($userViewUserGroupsPermission) && $userViewUserGroupsPermission->permission_id =='9')

                  <li><a href="{{ url('list-roles') }}"><span class="badge badge-r"></span>User Groups</a></li>
                @endif

                {{--@if(isset($userViewPOIPermission) && $userViewPOIPermission->permission_id =='11')--}}

                {{--<li><a href="{{ url('list-poi-users') }}"><span class="badge badge-r"></span>POI</a></li>--}}
                {{--@endif--}}


                {{--@if(isset($userViewPermissionsPermission) && $userViewPermissionsPermission->permission_id =='12')--}}
                {{--<li><a href="{{ url('list-permissions') }}"><span class="badge badge-r"></span>Permissions</a></li>--}}
                {{--@endif--}}

                {{--<li><a href="{{ url('list-forms') }}"><span class="badge badge-r"></span>Forms</a></li>--}}
                {{--<li><a href="{{ url('list-formsdata') }}"><span class="badge badge-r"></span>Forms Data</a></li>--}}
              </ul>
            </li>
          @endif
          <li class="dropdown">
            <a class="sa-side-folder" href="{{ url('show_repository') }}">
              <span class="menu-item">REPOSITORY </span>
            </a>
            <ul class="list-unstyled menu-item">
              <li>
                <a class="" href="{{ url('show_repository') }}">
                  <span class=""> REPOSITORY </span>
                </a>
              </li>
              <li>
                <a class="" href="{{ url('list-documentLog') }}">
                  <span class=""> Documents Log </span>
                </a>
              </li>
            </ul>
          </li>
          @if(isset($userViewReportsPermission) && $userViewReportsPermission->permission_id =='16')

            <li class="dropdown">
              <a class="sa-side-page" href="">
                <span class="menu-item">Form wizard </span>
              </a>
              <ul class="list-unstyled menu-item">
                @if(isset($userViewDepartmentsPermission) && $userViewDepartmentsPermission->permission_id =='4')



                  <li><a href="{{ url('list-forms') }}"><span class="badge badge-r"></span>Forms</a></li>
                  <li><a href="{{ url('list-formsdata') }}"><span class="badge badge-r"></span>Forms Data</a></li>

                @endif
              </ul>
            </li>
          @endif

          @if(isset($userViewReportsPermission) && $userViewReportsPermission->permission_id =='16')
                  @if (Auth::user())
                      <li {{ (Request::is('reports') ? "class=active" : '') }}>
                          <a class="sa-side-drone" href="{{ url('api/v1/requestDrones')}}">
                              <span class="menu-item">drone Request</span>
                          </a>
                      </li>

                  @endif

          @endif


          @if(isset($userViewReportsPermission) && $userViewReportsPermission->permission_id =='16')

            @if (Auth::user())
              <li {{ (Request::is('reports') ? "class=active" : '') }}>
                <a class="sa-side-agenda" href="{{ url('addressbookList/'.Auth::user()->id )}}">
                  <span class="menu-item">Address Book</span>
                </a>
              </li>

            @endif
                

          @endif
        </ul>
      </aside>
      <!-- Content -->
      <section id="content" class="container">
        @include('messages.list')
        @include('messages.add')

        @yield('content')
        @include('addressbook.list')
        @include('addressbook.global')
        @include('addressbook.globalAdd')
        @include('chat.list')
      </section>
    </section>

    <!-- Javascript Libraries -->
    <!-- jQuery -->

    <!--Toggles-->
    <script src="{{ asset('/js/toggles.js') }}"></script>

    <script src="{{ asset('/js/jquery-ui.min.js') }}"></script> <!-- jQuery UI -->
    <script src="{{ asset('/js/jquery.easing.1.3.js') }}"></script>
    <!-- jQuery Easing - Requirred for Lightbox + Pie Charts-->

    <!-- Bootstrap -->
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>




    <!--  Form Related -->
    <script src="{{ asset('/js/icheck.js') }}"></script> <!-- Custom Checkbox + Radio -->

    <!-- UX -->
    <script src="{{ asset('/js/scroll.min.js') }}"></script> <!-- Custom Scrollbar -->

    <!-- Other -->
    <script src="{{ asset('/js/calendar.min.js') }}"></script> <!-- Calendar -->
    <script src="{{ asset('/js/feeds.min.js') }}"></script> <!-- News Feeds -->


    <!--  Form Related -->
    <script src="{{ asset('/js/validation/validate.min.js') }}"></script> <!-- jQuery Form Validation Library -->
    <script src="{{ asset('/js/validation/validationEngine.min.js') }}"></script>
    <!-- jQuery Form Validation Library - requirred with above js -->


    <!-- All JS functions -->
    <script src="{{ asset('/js/functions.js') }}"></script>


    <!-- Token Input -->
    <script src="{{ asset('/js/jquery.tokeninput.js') }}"></script> <!-- Token Input -->


    <!-- Noty JavaScript -->
    <script src="{{ asset('/bower_components/noty/js/noty/packaged/jquery.noty.packaged.js') }}"></script>

    <!-- DataTables JavaScript -->


    <script src="{{ asset('/bower_components/datatables/media/js/datatables-plugins/pagination/scrolling.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>



    <!-- Jquery Bootstrap Maxlength -->
    <script src="{{ asset('/bower_components/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>


    <!-- Media -->
    <script src="{{ asset('/js/media-player.min.js') }}"></script> <!-- Video Player -->
    <script src="{{ asset('/js/pirobox.min.js') }}"></script> <!-- Lightbox -->
    <script src="{{ asset('/js/file-manager/elfinder.js') }}"></script> <!-- File Manager -->


    <script type="text/javascript" src="{{ asset('/incl/oms.min.js') }}"></script>



    <!-- File Upload -->
    <script src="{{ asset('/js/fileupload.min.js') }}"></script> <!-- File Upload -->

    <!-- Spinner -->
    <script src="{{ asset('/js/HoldOn.min.js') }}"></script> <!-- Spinner -->

    <!-- bootstrap-switch. -->
    <script src="{{ asset('/js/bootstrap-switch.js') }}"></script> <!-- bootstrap-switch. -->

    <!-- Date & Time Picker -->
    <script src="{{ asset('/js/datetimepicker.min.js') }}"></script> <!-- Date & Time Picker -->

    <!-- Buttons HTML5 -->
    <script src="{{ asset('/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/js/jszip.min.js') }}"></script>
    <script src="{{ asset('/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/js/vfs_fonts.js') }}"></script>
    <!--  Buttons HTML5 -->

  
  


<!-- END  -->

    <script src="{{ asset('/js/socket.io.js') }}"></script>

    <script src="{{ asset('/js/calendar.min.js') }}"></script> <!-- Calendar -->

    <script src="{{ asset('/js/raphael.js') }}"></script>
  <!-- D3.js
        <script src="{{ asset('js/d3/plugins.js') }}"></script>
        <script src="{{ asset('js/d3/script.js') }}"></script>
        <script src="{{ asset('js/d3/libs/coffee-script.js') }}"></script>
        <script src="{{ asset('js/d3/libs/d3.v2.js') }}"></script>
        <script src="{{ asset('js/d3/Tooltip.js') }}"></script>
        <script src="{{ asset('js/d3/Tooltip.js') }}"></script>
    -->

    {{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwXS96_uM6y-6ZJZhSJGE87pO-qxpDp-Q&libraries=places"></script>--}}

    <script type="text/javascript">
      var ZoomChartsLicense = "ZCS-bc96u7g34: ZoomCharts 30 day free trial development licence eli..@..l.com (valid for evaluation only); upgrades until: 2016-11-18";
      var ZoomChartsLicenseKey = "bb73530f3272579c914f3828e818a7956bc9a2361fe31fd609" +
        "bda486c2f2b069e414aef7f6bf51355f82b43ace777b9621e7858acaebc7f3c6fb70c5722ed38" +
        "82153935b365406d020ba9a80e45cff204ca43ce64f67c983827de0a7f0752a40401ad318c1bf" +
        "354009e851044a21bc2b73503448e9648ae4aeac2ad277d9f0972c6f2063b49fc7a19c7e4fcd3" +
        "8edb07040e7c65a0df13554a276cd9c576f3f515b252185483e79efff5ed71201d6cbef58a127" +
        "4ddb695c8c89887c9a9322ac8514fe87ccc88da0ed42aabb64b569389ad79f7eeb0f0be40d780" +
        "b487a324116c7da20f45f1e2f90ee01b277a2c56b52e04b13e6e567ae4c5c42cffb71a0ec7b58";
    </script>

    <!-- zoomchart -->
    <script src="{{ asset('/js/zoomcharts.js') }}"></script>

    <script>
      $(document).ready(function () {
        if (typeof google !== "undefined") google.maps.event.addDomListener(window, 'load', initAutocomplete);
      });
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
            autocomplete_work.setBounds(circle.getBounds());
          });
        }
      }
      function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
          (document.getElementById('autocomplete')),
          {types: ['geocode']});
        autocomplete.addListener('place_changed', fillInAddress);
        autocomplete_work = new google.maps.places.Autocomplete(
          (document.getElementById('autocomplete_work')),
          {types: ['geocode']});
        autocomplete_work.addListener('place_changed', fillInWorkAddress);
        autocomplete_res = new google.maps.places.Autocomplete(
          (document.getElementById('autocomplete_res')),
          {types: ['geocode']});
        autocomplete_res.addListener('place_changed', fillInResAddress);
      }
      function fillInWorkAddress() {
        var place_work = autocomplete_work.getPlace();
        if ($('.latitude_work').length != 0) {
          document.getElementsByClassName("latitude_work")[0].value = place_work.geometry.location.lat();
          document.getElementsByClassName("longitude_work")[0].value = place_work.geometry.location.lng();
        }
      }
      function fillInResAddress() {
        var place_res = autocomplete_res.getPlace();
        if ($('.latitude_res').length != 0) {
          document.getElementsByClassName("latitude_res")[0].value = place_res.geometry.location.lat();
          document.getElementsByClassName("longitude_res")[0].value = place_res.geometry.location.lng();
        }
      }
      function isValidSAID(id) {
        var i, c,
          even = '',
          sum = 0,
          check = id.slice(-1);
        if (id.length != 13 || id.match(/\D/)) {
          return false;
        }
        id = id.substr(0, id.length - 1);
        for (i = 0; c = id.charAt(i); i += 2) {
          sum += +c;
          even += id.charAt(i + 1);
        }
        even = '' + even * 2;
        for (i = 0; c = even.charAt(i); i++) {
          sum += +c;
        }
        sum = 10 - ('' + sum).charAt(1);
        return ('' + sum).slice(-1) == check;
      }
      function fillInAddress(type) {
        var place = autocomplete.getPlace();
        if ($('.latitude').length != 0) {
          document.getElementsByClassName("latitude")[0].value = place.geometry.location.lat();
          document.getElementsByClassName("longitude")[0].value = place.geometry.location.lng();
        }
        for (var component in componentForm) {
          if ($('#' + component).length != 0) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
          }
        }
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            if ($('.' + addressType).length != 0) {
              var val = place.address_components[i][componentForm[addressType]];
              document.getElementsByClassName(addressType)[0].value = val;
            }
          }
        }
      }
    </script>
    @include('functions.caseModal')
    @yield('footer')
    @include('partials.forms')
    @include('forms.data.form')
    @include('forms.data.view')
    @include('version')
    @if(env('APP_ENV','Production')!='local')
      @include('partials.refresh')
      @include('partials.timeout')
    @endif

  @endif
  <script>
    var APP_DEBUG = {{ env("APP_DEBUG", 0) }};
    console.log("APP_DEBUG: ", APP_DEBUG, " > 2 - ", (APP_DEBUG > 2));
  </script>
  <script>
    $(document).ready(function () {
      $("select[name*='_countrycode']").on("change", function (ev) {
        console.log("  Country code change: ev - ", ev)
        var prefix = ev.currentTarget.options[ev.currentTarget.selectedIndex].value;
        if (prefix == "") prefix = "??";
        var elName = ev.currentTarget.name.replace("_countrycode", "");
        //var el = $("input[name='"+elName+"']");
        var el = $(ev.currentTarget).parent().find("input[name='" + elName + "']").first()[0];
        console.log("  prefix - ", prefix);
        console.log("  elName - ", elName, ", el - ", el);
        if (el) {
          //String().
          var valCurrent = String($(el).val()).trim();
          var valNew = "+" + prefix + " ";
          //if (String(valCurrent).trim())
          if (String(valCurrent).charAt(0) == "+" && valCurrent.indexOf(" ") != -1) valCurrent = valCurrent.substring(valCurrent.indexOf(" ") + 1);
          else if (String(valCurrent).charAt(0) == "+") valCurrent = "";
          if (String(valCurrent).charAt(0) == "0") valCurrent = valCurrent.substring(1);
          valNew += valCurrent;
          console.log("  current valuye - ", valCurrent);
          console.log("  new valuye - ", valNew);
          $(el).val(valNew);
        }
      });
      //$.post( '{!!  url("/resetSession") !!}',{ '_token' : '{!! csrf_token() !!}' }, function( data ) { console.log("/resetSession A, data - ",data); });
      //$.post( "/resetSession",{ '_token' : '{!! csrf_token() !!}' }, function( data ) { console.log("/resetSession B, data - ",data); });

      $(".hasDependents").on("change", function (ev) {
        var elName = ev.currentTarget.name ? ev.currentTarget.name : ev.currentTarget.id;
        var thing = {slug:"", name: "", owner: ""};
        if (elName.search("company") != -1) thing = {slug:"departments", name: "Department", owner: "Company"};
        else if (elName.search("department") != -1) thing = {slug:"cases_types", name: "Type", owner: "Department"};
        else if (elName.search("case_type") != -1) thing = {slug:"cases_sub_types", name: "Sub-type", owner: "Type"};
        var id = ev.currentTarget.options[ev.currentTarget.selectedIndex].value;
        console.log("changes.. id - ", id,", ev - ",ev);
        console.log("  thing - ",thing,", things - ",thing);
        var el = $(ev.currentTarget).closest(".form-group").next().find("select").get(0);
        console.log("  el - ",el);
        var val = $(el).val();
        console.log("  el: val - ", val, ", ", el);
        console.log("  el.options - ", el.options);

        var oParams = {};
        oParams['thing'] = id;
        $.get("{{url('api/dropdown/')}}/"+thing['slug'], oParams, function (data) {
          console.log("  got ",thing,": length - ", data.length, ", ", data);
          el.options.length = 0;
          if (data.length == 0) {
            if (id == 0) {
              $(el).append("<option value=0>Select "+thing['owner']+"</option>");
              var elDeps = $(el).closest(".wDependents").next().find("select").get(0);
            }
            else $(el).append("<option value=0>N/A</option>");
          } else {
            /*for (var i = 0; i < data.length; i++) {
             console.log("  Adding ",data[i]);
             var opt = new Option(data[i][1], data[i][0]);
             el.options.add(opt);
             }*/
            //$(el).append("<option value=0>Select "+thing['name']+"</option>");
            $(el).append("<option value=0>Select</option>");
            $.each(data, function (key, element) {
              console.log("   Appending: key - ", key, ", element - ", element);
              $(el).append("<option value=" + key + ">" + element + "</option>");
            });
          }
          $(el).val(0);
        });

        var wMarkers = $("#wMarkers").first();
        console.log("  wMarkers - ", wMarkers);
      });
    });
  </script>
  <script src="js/droneRequest.js"></script>
</body>
</