@extends('master')

@section('content')
    <!-- Breadcrumb -->
    <ol class="breadcrumb hidden-xs">
        <li><a href="{{ url('calendar/events') }}">Calendar Events</a></li>
        <li class="active">Calendar Group Listing</li>
    </ol>

    <h4 class="page-title">CALENDAR GROUPS</h4>
    <!-- Alternative -->
    <div class="block-area" id="alternative-buttons">
        <h3 class="block-title">CALENDAR GROUPS LISTING</h3>
        <a href="{{ url('calendar-group/create') }}" class="btn btn-sm" style="margin-bottom: 10px">
            <i class="fa fa-plus" aria-hidden="true" title="Add Your New Task Here" data-toggle="tooltip">Add Calendar Group</i>
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
            <table class="table tile table-striped" id="calendarGroupsTables">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('footer')

    <script>

        $(document).ready(function() {

            var oTable     = $('#calendarGroupsTables').DataTable({
                "autoWidth": false,
                "processing": true,
                "serverSide": false,
                "dom": 'T<"clear">lfrtip',
                "order": [[0, "desc"]],
                "ajax": "{!! url('/getCalendarGroup')!!}",
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'actions',  name: 'actions'},
                ],

                "aoColumnDefs": [
                    { "bSearchable": false, "aTargets": [ 1] },
                    { "bSortable": false, "aTargets": [ 1 ] }
                ]

            });

        });
    </script>
@endsection
