@extends('master')

@section('content')
<!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="#">Administration</a></li>
    <li><a href="{{ url('list-companies') }}">Companies</a></li>
    <li class="active">Company Listing</li>
</ol>

<h4 class="page-title">COMPANIES</h4>
<!-- Alternative -->
<div class="block-area" id="alternative-buttons">
    <h3 class="block-title">Company Listing</h3>
    <a class="btn btn-sm" data-toggle="modal" data-target=".modalEditCompany">
     Add Company
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
        <table class="table tile table-striped" id="provincesTable">
            <thead>
              <tr>
                    <th>Id</th>
                    <th>Created At</th>
                    <th>Name</th>
                    <th>Actions</th>
              </tr>
            </thead>
        </table>
    </div>
</div>
@include('companies.edit')
@include('companies.add')
@endsection

@section('footer')

 <script>
  $(document).ready(function() {

  var oTable     = $('#provincesTable').DataTable({
                "processing": true,
                "serverSide": true,
                "dom": 'T<"clear">lfrtip',
                "order" :[[0,"desc"]],
                "ajax": "{!! url('/companies-list/')!!}",
                 "columns": [
                {data: 'id', name: 'id'},
                {data: 'created_at', name: 'created_at'},
                {data: function(d)
                {
                    var sTip = "";
                    sTip += "Departments - "+d.cntDepartments;
                 return "<a href='{!! url('list-departments/" + d.id + "') !!}' class='btn btn-sm' title='"+sTip+"'>" + d.name + " ("+d.cntDepartments+")" + "</a>";

                },"name" : 'name'},

              {data: 'actions',  name: 'actions'},
               ],

            "aoColumnDefs": [
                { "bSearchable": false, "aTargets": [ 1] },
                { "bSortable": false, "aTargets": [ 1 ] }
            ]

         });

  });

   function launchCompanyModal(id)
    {

       $(".modal-body #provinceID").val(id);
       $.ajax({
        type    :"GET",
        dataType:"json",
        url     :"{!! url('/companies/"+ id + "')!!}",
        success :function(data) {

            if(data[0] !== null)
            {

               $("#modalEditCompany #id").val(data[0].id);
               $("#modalEditCompany #name").val(data[0].name);
               $("#modalEditCompany #address").val(data[0].address);
               $("#modalEditCompany #company_number").val(data[0].company_number);
               $("#modalEditCompany #company_email").val(data[0].company_email);
               $("#modalEditCompany #contact_number").val(data[0].contact_number);
               $("#modalEditCompany #contact_email").val(data[0].contact_email);

            }
            else {
               $("#modalEditCompany #name").val('');
            }

        }
    });

    }

    @if (count($errors) > 0)

      $('#modalDepartment').modal('show');

    @endif


</script>
@endsection
