@extends('master')
@section('content')
    <div class="block-area" id="alternative-buttons">
        <h3 class="block-title">Manage Drones</h3>
        <a href="{{ url('requestForm') }}" class="btn btn-sm">
            <i class="fa fa-plus" aria-hidden="true" title="Add Your New Task Here" data-toggle="tooltip"></i>
        </a>
    </div>

<!-- Responsive Table -->
<div class="block-area" id="responsiveTable">
    <div class="table-responsive overflow">
        @if(Session::has('success'))
            <div class="alert alert-success alert-icon">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('success') }}
                <i class="icon">&#61845;</i>
            </div>
        @endif
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

            var userId = {{Auth::user()->id}};

var oTable     = $('#DroneRequestTable').DataTable({
                "autoWidth":false,
                "processing": true,
                "serverSide": true,
                "dom": 'T<"clear">lfrtip',
                "order" :[[0,"desc"]],
                "ajax": "{!! url('/getDroneRequests/"+ userId +"')!!}",
                "columns": [
                {data: 'id', name: 'id'},
                {data: 'DroneType', name: 'DroneType'},
                {data: 'DroneSubType', name: 'DroneSubType'},
                {data: 'CreatedBy', name: 'CreatedBy'},
                {data: 'CaseStatus', name: 'CaseStatus'},
                {data: 'Department', name: 'Department'},
                {data: 'notes', name: 'notes'},
                    {data: 'actions', name: 'actions'}
                     {{--{data: function(b)--}}
                     {{--{--}}
                         {{--return "<a href='{!! url('api/v1/showDroneRequest/" + b.id + "') !!}' class='btn btn-sm'>" + 'View' + "</a>";--}}
                     {{--},"names" : 'names'},--}}
               ],

            "aoColumnDefs": [
                { "bSearchable": false, "aTargets": [ 1] },
                { "bSortable": false, "aTargets": [ 1 ] }
            ]
              });

          });
      </script>
@endsection