@extends('master')

@section('content')



    <!-- Breadcrumb -->
    <ol class="breadcrumb hidden-xs">
        <li><a href="{{ url('tasks') }}">TASK LIST</a></li>
        <li><a href="{{ url('CaseProfile',$task->id) }}">CASE PROFILE</a></li>
        <li class="active">TASK DETAILS</li>
    </ol>

    <h4 class="page-title">TASK {{ $task->id }} : {{ strtoupper($task->title) }}</h4>

    <br>

    <div class="block-area container">
        <div class="row">
            <div class="col-md-9">

                    <!-- Tab -->
                    <div class="block-area" id="tabs">
                        <div class="tab-container">
                            <ul class="nav tab nav-tabs">

                                @include('tasks.tabs')

                            </ul>
                            <div class="m-b-15 text-center profile-summary">

                                @include('tasks.tasknav')

                            </div>

                            @if(Auth::user()->id == $task->created_by)
                            <a class="btn btn-sm" href="{{ url('ChangeRequest/'.$task->id) }}" aria-hidden="true">View Date Change Request</a>
                            @endif

                            <div class="tab-content">
                                <div class="tab-pane active" id="taskprofile">

                                    <div class="block-area" id="horizontal">

                                        @if(Session::has('success'))
                                            <div class="alert alert-success alert-icon">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                {{ Session::get('success') }}
                                                <i class="icon">&#61845;</i>
                                            </div>
                                        @endif
                                        <h3 class="block-title">TASK DETAILS</h3>

                                        @include('tasks.edit')


                                    </div>

                                    <hr class="whiter m-t-20" />

                                </div>

                                <div class="tab-pane" id="tasknotes">

                                    <h3 class="block-title">TASK NOTES</h3>


                                    @include('tasknotes.add')

                                </div>


                                <div class="tab-pane" id="taskfiles">

                                    <h3 class="block-title">TASK FILES</h3>

                                    @include('taskfile.add')


                                </div>

                                <div class="tab-pane" id="taskreminders">

                                    <h3 class="block-title">TASK REMINDERS</h3>

                                    @include('taskreminders.add')

                                </div>

                                <div class="tab-pane" id="taskrelations">

                                    <h3 class="block-title">RELATED TASKS</h3>

                                </div>

                            </div>
                        </div>


                    </div>


                <div class="m-b-15 text-center profile-summary">



                </div>

                <div class="row">
                    <!-- Works -->
                    <div class="col-md-7">
                        <div class="tile">
                            <h2 class="tile-title">Tasks in progress</h2>
                            <div class="p-10">
                                <div class="m-b-10">
                                    {{ $task->title }} - {{$task->complete}}%
                                    <div class="progress progress-striped progress-alt">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{$task->complete}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$task->complete}}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Completed Projects -->
                        <div class="tile">
                            <h2 class="tile-title m-b-5">Completed Tasks</h2>
                            <div class="tile-config dropdown">
                                <a data-toggle="dropdown" href="" class="tooltips tile-menu" title="" data-original-title="Options"></a>
                                <ul class="dropdown-menu pull-right text-right">
                                    <li><a href="">Edit</a></li>
                                    <li><a href="">Delete</a></li>
                                </ul>
                            </div>

                            <div class="p-10 news">
                                <div class="col-xs-4">
                                   {{-- <div class="tile p-5 m-b-10">
                                        <a target="_blank" title="Medical-Pro Bootstrap Responsive Template" href="https://wrapbootstrap.com/theme/medical-pro-responsive-template-WB06421XL">
                                            <img class="w-100" src="img/projects/1.png" alt="">
                                            <small class="t-overflow m-t-10">Medical-Pro Bootstrap Responsive</small>
                                        </a>
                                        <div class="clearfix"></div>
                                    </div>--}}
                                </div>
                                <div class="col-xs-4">
                                    {{--<div class="tile p-5 m-b-10">
                                        <a target="_blank" title="Black Pearl Responsive Admin Template" href="https://wrapbootstrap.com/theme/black-pearl-responsive-admin-template-WB040H333">
                                            <img class="w-100" src="img/projects/2.png" alt="">
                                            <small class="t-overflow m-t-10">Black Pearl Responsive Admin Template</small>
                                        </a>
                                        <div class="clearfix"></div>
                                    </div>--}}
                                </div>
                                <div class="col-xs-4">
                                    {{--<div class="tile p-5 m-b-10">
                                        <a target="_blank" title="UNEKUE Single Page Portfolio Template" href="https://wrapbootstrap.com/theme/unekue-single-page-portfolio-template-WB04R2B18">
                                            <img class="w-100" src="img/projects/3.png" alt="">
                                            <small class="t-overflow m-t-10">UNEKUE Single Page Portfolio Template</small>
                                        </a>
                                        <div class="clearfix"></div>
                                    </div>--}}
                                </div>


                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-5">
                        <div class="tile">
                            <h2 class="tile-title">Recent Notes</h2>

                            <div class="listview narrow">

                                @include('tasknotes.list')

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-3">



                @include('tasks.relatedtasks')


                <div class="tile">
                    <h2 class="tile-title">RECENT ACTIVITIES</h2>

                    @include('taskActivity.list')
                </div>

            </div>

        </div>

    </div>


@endsection
@section('footer')

    <script>


        $(document).ready(function(){

            prepopulateFirst = [];
            var id     = "{!! $taskAssignee->user->id !!}";
            var name   = "{!! $taskAssignee->user->name !!} {!! $taskAssignee->user->surname !!}";
            prepopulateFirst.push({ id: id, name: name });

            $("#task_assignee_id").val(id);

            $("#task_assignee").tokenInput("{!! url('/getTaskAssignee')!!}", {
                onAdd: function (item) {

                    $("#task_assignee_id").val(item.userId);
                },
                onDelete: function (item) {

                },
                tokenLimit:1,
                prePopulate:prepopulateFirst
            });

            var completeValue     = "{!! $task->complete !!}";

            $('.spinner-2').spinedit('setValue',completeValue);

        });

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });

        $("#notesNav").on('click',function () {

            $('#tabs a[href="#tasknotes"]').tab('show')

        })

        $("#filesNav").on('click',function () {

            $('#tabs a[href="#taskfiles"]').tab('show')

        })

        $("#relatedNav").on('click',function () {

            $('#tabs a[href="#taskrelations"]').tab('show')

        })

    </script>

@endsection

