@extends('master')

@section('content')
    <!--Nav Tabs-->



    <div id="tabs">
    <ul class="nav nav-pills navbar-right" role="tablist">
        <li class="active"><a href="#all"  data-toggle="tab">My Tasks</a></li>
        <li><a href="#assigned"  data-toggle="tab">Assigned by Me</a></li>

    </ul>

        <h4 class="page-title">TASKS</h4>
    <!-- Alternative -->


            <div class="block-area" id="alternative-buttons">
        <h3 class="block-title">Manage Tasks</h3>
                <a href="{{ url('tasks/create') }}" class="btn btn-sm">
                    <i class="fa fa-plus" aria-hidden="true" title="Add Your New Task Here" data-toggle="tooltip"></i>
                </a>
            </div>

        <div class="tab-content">
            <div class="tab-pane" id="all">
                <!-- Responsive Table -->
                <div class="block-area" id="responsiveTable">
                    <div id="MeetingNotification"></div>
                    <div class="table-responsive overflow">
                        <table class="table tile table-striped" id="tasksTable">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>Due Date</th>
                                <th>Assigned To</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>


                        <p>
                        </p>

                    </div>
                </div>

            </div>

        </div>


        <div class="tab-content">
        <div class="tab-pane" id="assigned">


            <!-- Responsive Table -->
            <div class="block-area" id="responsiveTable">
                <div id="MeetingNotification"></div>
                <div class="table-responsive overflow">
                    <table class="table tile table-striped" id="assignedByMeTasksTable">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>

        </div>


    </div>

@endsection
@section('footer')

    <!-- tabs Script-->
    <script>
        $( function() {
            $( "#tabs" ).tabs();
        } );
    </script>


    <!-- tooltip Script-->
    <script>

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>


    <!-- tab columns Script-->

    <script>

        $(document).ready(function() {

            var oTableAll;
            var oTable = $('#tasksTable').DataTable({
                "autoWidth": false,
                "processing": true,
                "serverSide": false,
                "dom": 'T<"clear">lfrtip',
                "order": [[0, "desc"]],
                "ajax": "{!! url('/getTasks')!!}",


                "columns": [
                    {data: 'task.id', name: 'tasks.id'},
                    {data: 'task.title', name: 'tasks.title'},
                    {
                        data: function (d) {

                            return d.task.description;

                        }, "name": 'tasks.description', "width": "25%"
                    },
                    {data: 'task.status.name', name: 'tasks.status_id'},
                    {data: 'task.commencement_date', name: 'tasks.commencement_date'},
                    {
                        data: function (d) {

                            var year = d.task.due_date.substring(0, 4);
                            var month = d.task.due_date.substring(5, 7);
                            var day = d.task.due_date.substring(8, 10);
                            var oneDay = 24 * 60 * 60 * 1000;
                            var now = new Date();
                            var dateEnd = new Date(year, month - 1, day);
                            var days = (dateEnd - now) / oneDay;
                            var daysToGo = Math.round(days);
                            var realDaysGo = Math.abs(daysToGo);

                            var returnString = " ";

                            if (daysToGo < 0) {
                                returnString = "<div data-togle='tooltip' title='Was due " + realDaysGo + now + " day(s) ago'  style='background-color:#b71c1c; padding-top: 1px; padding-bottom: 1px; cursor: pointer;'> <p style='color: #fff; margin-left: 30px; margin-top: 1px; font-size: 13px; font-family: Tahoma;'>" + d.task.due_date + "</p> </div>";
                            } else if (daysToGo == 0) {
                                returnString = "<div data-togle='tooltip' title='Due Today' style='background-color:#ef6c00; padding-top: 1px; padding-bottom: 1px; cursor: pointer;'> <p style='color: #fff; margin-left: 30px; margin-top: 1px; font-size: 13px; font-family: Tahoma;'>" + d.due_date + "</p> </div>";
                            } else if (daysToGo > 0) {
                                returnString = "<div data-togle='tooltip' title='Due in " + realDaysGo + " day(s).' style='background-color:#4caf50; padding-top: 1px; padding-bottom: 1px; cursor: pointer;'> <p style='color: #fff; margin-left: 30px; margin-top: 1px; font-size: 13px; font-family: Tahoma;'>" + d.task.due_date + "</p> </div>";
                            } else {
                                returnString = "<div data-togle='tooltip' title='Due in " + realDaysGo + " day(s)' style='background-color:#4caf50; padding-top: 1px; padding-bottom: 1px; cursor: pointer;'> <p style='color: #fff; margin-left: 30px; margin-top: 1px; font-size: 13px; font-family: Tahoma;'>" + d.task.due_date + "</p> </div>";
                            }

                            return returnString;

                        }, "name": 'cases.due_date'
                    },
                    {
                        data: function (d) {

                            var names = d.user.name + " " + d.user.surname;
                            return names;

                        }, "name": 'tasks.user_id'
                    },
                    {data: 'actions', name: 'actions'},
                ],


                "aoColumnDefs": [
                    {"bSearchable": false, "aTargets": [4]},
                    {"bSortable": false, "aTargets": [4]}
                ]

            });


            var oTableAssigend = $('#assignedByMeTasksTable').DataTable({
                "autoWidth": false,
                "processing": true,
                "serverSide": false,
                "dom": 'T<"clear">lfrtip',
                "order": [[0, "desc"]],
                "ajax": "{!! url('/getAssignedByMeTasks')!!}",


                "columns": [
                    {data: 'task.id', name: 'tasks.id'},
                    {data: 'task.title', name: 'tasks.title'},
                    {
                        data: function (d) {

                            return d.task.description;

                        }, "name": 'tasks.description', "width": "25%"
                    },
                    {data: 'task.status.name', name: 'tasks.status_id'},
                    {data: 'task.commencement_date', name: 'tasks.commencement_date'},
                    {
                        data: function (d) {

                            var year = d.task.due_date.substring(0, 4);
                            var month = d.task.due_date.substring(5, 7);
                            var day = d.task.due_date.substring(8, 10);
                            var oneDay = 24 * 60 * 60 * 1000;
                            var now = new Date();
                            var dateEnd = new Date(year, month - 1, day);
                            var days = (dateEnd - now) / oneDay;
                            var daysToGo = Math.round(days);
                            var realDaysGo = Math.abs(daysToGo);

                            var returnString = " ";

                            if (daysToGo < 0) {
                                returnString = "<div data-togle='tooltip' title='Was due " + realDaysGo + now + " day(s) ago'  style='background-color:#b71c1c; padding-top: 1px; padding-bottom: 1px; cursor: pointer;'> <p style='color: #fff; margin-left: 30px; margin-top: 1px; font-size: 13px; font-family: Tahoma;'>" + d.task.due_date + "</p> </div>";
                            } else if (daysToGo == 0) {
                                returnString = "<div data-togle='tooltip' title='Due Today' style='background-color:#ef6c00; padding-top: 1px; padding-bottom: 1px; cursor: pointer;'> <p style='color: #fff; margin-left: 30px; margin-top: 1px; font-size: 13px; font-family: Tahoma;'>" + d.due_date + "</p> </div>";
                            } else if (daysToGo > 0) {
                                returnString = "<div data-togle='tooltip' title='Due in " + realDaysGo + " day(s).' style='background-color:#4caf50; padding-top: 1px; padding-bottom: 1px; cursor: pointer;'> <p style='color: #fff; margin-left: 30px; margin-top: 1px; font-size: 13px; font-family: Tahoma;'>" + d.task.due_date + "</p> </div>";
                            } else {
                                returnString = "<div data-togle='tooltip' title='Due in " + realDaysGo + " day(s)' style='background-color:#4caf50; padding-top: 1px; padding-bottom: 1px; cursor: pointer;'> <p style='color: #fff; margin-left: 30px; margin-top: 1px; font-size: 13px; font-family: Tahoma;'>" + d.task.due_date + "</p> </div>";
                            }

                            return returnString;

                        }, "name": 'cases.due_date'
                    },
                    {
                        data: function (d) {

                            var names = d.user.name + " " + d.user.surname;
                            return names;

                        }, "name": 'tasks.user_id'
                    },
                    {data: 'actions', name: 'actions'},
                ],


                "aoColumnDefs": [
                    {"bSearchable": false, "aTargets": [4]},
                    {"bSortable": false, "aTargets": [4]}
                ]

            });

        });






    </script>
@endsection


