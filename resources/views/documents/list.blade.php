@extends('master')

@section('content')
<!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="#">Administration</a></li>
    <li><a href="{{ url('list-departments') }}">Documents</a></li>
    <li class="active">Documents Listing</li>
</ol>

<h4 class="page-title"> DOCUMENTS   </h4>
<!-- Alternative -->
<div class="block-area" id="alternative-buttons">
    <h3 class="block-title">Documents Repository Listing</h3>
    <a class="btn btn-sm" data-toggle="modal"  data-target=".modalAddDocument">
     Add Documents 
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

    <div></div>
        <table class="table tile table-striped" id="documentsTable">
            <thead>
              <tr>
                    <th>Id</th>                   
                    <th>Name</th>
                    <th>Created by</th>
                    <th>Description</th>
                     <th>Created At</th>
                    <th>Actions</th>
              </tr>
            </thead>
        </table>
    </div>
</div>




@include('documents.edit')
@include('documents.add')
@endsection

@section('footer')

 <script>
  $(document).ready(function() {

  var oTable     = $('#documentsTable').DataTable({
                "processing": true,
                "serverSide": true,
                "dom": 'T<"clear">lfrtip',
                "order" :[[0,"desc"]],
                "ajax": "{!! url('/documents-list/')!!}",
                 "columns": [
                {data: 'id', name: 'id'},
               
                {data: function(d)
                {
                 return "<a href='{!! url('list-folder/" + d.id + "') !!}' class='btn btn-sm'>" + d.name + "</a>";

                },"name" : 'name'},
                 {data:'username', username:'username'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at'},
                {data: 'actions',  name: 'actions'},
                
               ],

            "aoColumnDefs": [
                { "bSearchable": false, "aTargets": [ 1] },
                { "bSortable": false, "aTargets": [ 1 ] }
            ]

         });

  });

   function launchUpdateDepartmentModal(id)
    {
        $(".modal-body #docID").val(id);
         $.ajax({
          type    :"GET",
          dataType:"json",
          url     :"{!! url('/documents/"+ id + "')!!}",
          success :function(data) {

              if(data[0] !== null)
              {
                 $("#modalEditdocuments #name").val(data[0].name);
                 $("#modalEditdocuments #description").val(data[0].description);
              }
              else {

                 $("#modalEditdocuments #name").val('');
                 $("#modalEditdocuments #description").val('');
              }

          }
      });

    }


    @if (count($errors) > 0)
          @if(Input::get ('docID'))
            $('#modalEditdocuments').modal('show');
          @else
            $('#modalAddDocument').modal('show');
          @endif      
    @endif


</script>
@endsection
