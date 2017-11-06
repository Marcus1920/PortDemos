@extends('master')

@section('content')

<!-- Responsive Table -->
<div class="block-area" id="responsiveTable">
    <div class="table-responsive overflow">
        <table class="table tile table-striped" id="DroneRequestTable">
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
		

@endsection
@section('footer')
<script>

        $(document).ready(function() {

var oTable     = $('#DroneRequestTable').DataTable({
                "autoWidth":false,
                "processing": true,
                "serverSide": true,
                "dom": 'T<"clear">lfrtip',
                "order" :[[0,"desc"]],
                "ajax": "{!! url('/api/v1/drone/')!!}",
                 "columns": [
                {data: 'id', name: 'id'},
                {data: 'DroneType', name: 'DroneType'},
                {data: 'DroneSubType', name: 'DroneSubType'},
                {data: 'CreatedBy', name: 'CreatedBy'},
                {data: 'CaseStatus', name: 'CaseStatus'},
                {data: 'Department', name: 'Department'},
                {data: 'comments', name: 'comments'},
                     {data: function(d)
                     {
                         return "<a href='{!! url('api/v1/drone/" + d.id + "') !!}' class='btn btn-sm'>" + 'View' + "</a>";
                     },"name" : 'name'},
               ],

            "aoColumnDefs": [
                { "bSearchable": false, "aTargets": [ 1] },
                { "bSortable": false, "aTargets": [ 1 ] }
            ]

  });

          });
      </script>
@endsection