@extends('master')

@section('content')
    <!-- Breadcrumb -->
    <ol class="breadcrumb hidden-xs">
        <li><a href="{{ url('calendar/events') }}">Calendar Events</a></li>
        <li><a href="{{ url('calendar-group') }}">Calendar Group List</a></li>
        <li class="active">Calendar User Groups</li>
    </ol>

    <h4 class="page-title">Calendar User Groups</h4>
    <!-- Alternative -->
    <div class="block-area" id="alternative-buttons">
        <h3 class="block-title">Calendar User Groups Listing</h3>
        <a href="{{ url('calendar-group-user-add',$calendar_group_id) }}" class="btn btn-sm" style="margin-bottom: 5px">
            Add User Group
        </a>
    </div>

    <!-- Responsive Table -->
    <div class="block-area" id="responsiveTable">
        @if(Session::has('success'))
            <div class="alert alert-success alert-icon">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('success') }}
                <i class="icon">&#61845;</i>
            </div>
        @endif
        <div class="table-responsive overflow">
            <table class="table tile table-striped" id="calendarGroupUsersTable">
                <thead>
                <tr>
                    <th>NAME</th>
                    <th>ACTIONS</th>

                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
@section('footer')

    <script>
        $(document).ready(function() {

            var group = {!! $calendar_group_id !!}

            //associatesTable
            var oPoiTable     = $('#calendarGroupUsersTable').DataTable({
                "processing": true,
                "serverSide": true,
                "dom": 'Bfrtip',
                "order" :[[0,"desc"]],
                "ajax": "{!! url('/calendar_group-users-list/')!!}" + '/'+group,
                "buttons": [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',{

                        extend : 'pdfHtml5',
                        title  : 'Siyaleader',
                        header : 'I am text in',
                    },
                ],
                "columns": [
                    {data: function(d)
                    {
                        return "<a href='{!! url('list-permissions-per-group/" + d.user_group_id + "') !!}' class='btn btn-sm'>" + d.user.name + "</a>";

                    },"name" : 'user.name'},
                    {data: 'actions', name: 'actions'},

                ],

                "aoColumnDefs": [
                    { "bSearchable": false, "aTargets": [ 1] },
                    { "bSortable": false, "aTargets": [ 1] }
                ]

            });

        });

        $("#calendar_group_user_id").tokenInput("{!! url('/getUsers')!!}",{tokenLimit:100});

    </script>
@endsection
