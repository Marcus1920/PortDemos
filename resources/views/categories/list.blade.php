@extends('master')

@section('content')

<!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="#">Administration</a></li>
    <li><a href="{{ url('list-departments') }}">Departments</a></li>
    <li><a href="#">{{ $deptObj->name }}</a></li>
    <li class="active">Categories Listing</li>
</ol>

<h4 class="page-title">{{ $deptObj->name }} CATEGORIES</h4>
<!-- Alternative -->
<div class="block-area" id="alternative-buttons">
    <h3 class="block-title">Categories Listing</h3>
    <a class="btn btn-sm" data-toggle="modal" data-target=".modalAddCategory">
     Add Category
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
        <table class="table tile table-striped" id="categoriesTable">
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
@include('categories.edit')
@include('categories.add')
@include('categories.responder')
@endsection

@section('footer')

 <script>
  $(document).ready(function() {

  var department = {!! $deptObj->id !!};
  var oTable     = $('#categoriesTable').DataTable({
                "processing": true,
                "serverSide": true,
                "dom": 'T<"clear">lfrtip',
                "order" :[[0,"desc"]],
                "ajax": "{!! url('/categories-list/" + department +"')!!}",
                 "columns": [
                {data: 'id', name: 'id'},
                {data: 'created_at', name: 'created_at'},
                {data: function(d)
                {
                 return "<a href='{!! url('list-sub-categories/" + d.id + "') !!}' class='btn btn-sm'>"+d.name+"</a>";

                },"name" : 'name'},

              {data: 'actions',  name: 'actions'},
               ],

            "aoColumnDefs": [
                { "bSearchable": false, "aTargets": [ 1] },
                { "bSortable": false, "aTargets": [ 1 ] }
            ]

         });

  });

   function launchUpdateCategoryModal(id)
    {

      $(".modal-body #categoryID").val(id);

        var cell = $("#case_" + id ).data('mmcell');
        $.ajax({
        type    :"GET",
        dataType:"json",
        url     :"{!! url('/categories/"+ id + "')!!}",
        success :function(data) {

            if(data[0] !== null)
            {

               $("#modalEditCategory #name").val(data[0].name);

            }
            else {
               $("#modalEditCategory #name").val('');
            }

        }
    });

    }

  function launchCatResponders(id)
  {

      $(".modal-body #catID").val(id);


      $(".modal-body #catID").val(id);



      $(".modal-body #subCatID").val(id);

      var prepopulateFirst   = new Array();
      var prepopulateSecond  = new Array();
      var prepopulateThird   = new Array();
      var prepopulateFourth  = new Array();
      var first_responder_interval_time,
          second_responder_interval_time,
          third_responder_interval_time,
          fourth_responder_interval_time;

      $.ajax({
          type    :"GET",
          dataType:"json",
          url     :"{!! url('/getResponders/"+ id + "')!!}",
          success :function(data) {

              console.log(data);

              if(data.length > 0)
              {

                  for (var j = 0; j < data.length; j++) {
                      if (typeof data[j].firstResponder !== 'undefined')
                      {
                          prepopulateFirst.push({ id: data[j].id, name: data[j].firstResponder });
                      }
                      if (typeof data[j].secondResponder !== 'undefined')
                      {
                          prepopulateSecond.push({ id: data[j].id, name: data[j].secondResponder });
                      }

                      if (typeof data[j].thirdResponder !== 'undefined')
                      {
                          prepopulateThird.push({ id: data[j].id, name: data[j].thirdResponder });
                      }


                      if (typeof data[j].fourthResponder !== 'undefined')
                      {
                          prepopulateFourth.push({ id: data[j].id, name: data[j].fourthResponder });
                      }

                  }



                  for (var j = 0; j < data.length; j++) {

                      if(data[j].firstResponder !== null)
                      {

                          $("#firstResponder").prev(".token-input-list").remove();

                          $("#firstResponder").tokenInput("{!! url('/getResponder') !!}",{ prePopulate:prepopulateFirst });

                          if(data[j].first_responder_interval_time){

                              first_responder_interval_time = data[j].first_responder_interval_time;

                          }



                      }
                      else {
                          $("#firstResponder").tokenInput("{!! url('/getResponder') !!}");
                      }

                      if(data[j].secondResponder !== null)
                      {

                          $("#secondResponder").prev(".token-input-list").remove();
                          $("#secondResponder").tokenInput("{!! url('/getResponder') !!}",{ prePopulate: prepopulateSecond });

                          if(data[j].second_responder_interval_time){

                              second_responder_interval_time = data[j].second_responder_interval_time;
                          }

                      }
                      else {


                          $("#secondResponder").tokenInput("{!! url('/getResponder') !!}",{});
                      }


                      if(data[j].thirdResponder !== null)
                      {
                          $("#thirdResponder").prev(".token-input-list").remove();
                          $("#thirdResponder").tokenInput("{!! url('/getResponder') !!}",{ prePopulate:prepopulateThird });


                          if(data[j].third_responder_interval_time !== undefined){

                              third_responder_interval_time = data[j].third_responder_interval_time;

                          }
                      }
                      else {
                          $("#thirdResponder").tokenInput("{!! url('/getResponder') !!}",{});
                      }


                      if(data[j].fourthResponder !== null)
                      {
                          $("#fourthResponder").prev(".token-input-list").remove();
                          $("#fourthResponder").tokenInput("{!! url('/getResponder') !!}",{ prePopulate:prepopulateFourth });

                          if(data[j].fourth_responder_interval_time !== undefined){

                              fourth_responder_interval_time = data[j].fourth_responder_interval_time;

                          }
                      }
                      else {

                          $("#fourthResponder").tokenInput("{!! url('/getResponder') !!}",{});
                      }



                  }


                  $("#first_responder_interval_time").val(first_responder_interval_time);
                  $("#second_responder_interval_time").val(second_responder_interval_time);
                  $("#third_responder_interval_time").val(third_responder_interval_time);
                  $("#fourth_responder_interval_time").val(fourth_responder_interval_time);






              }
              else {


                  if($("#firstResponder").prev(".token-input-list").html())
                  {
                      $("#firstResponder").tokenInput("clear");
                  }
                  else
                  {
                      $("#firstResponder").tokenInput("{!! url('/getResponder') !!}");
                  }

                  if($("#secondResponder").prev(".token-input-list").html())
                  {
                      $("#secondResponder").tokenInput("clear");
                  }
                  else
                  {
                      $("#secondResponder").tokenInput("{!! url('/getResponder') !!}");
                  }

                  if($("#thirdResponder").prev(".token-input-list").html())
                  {
                      $("#thirdResponder").tokenInput("clear");
                  }
                  else
                  {
                      $("#thirdResponder").tokenInput("{!! url('/getResponder') !!}");
                  }


                  if($("#fourthResponder").prev(".token-input-list").html())
                  {
                      $("#fourthResponder").tokenInput("clear");
                  }
                  else
                  {
                      $("#fourthResponder").tokenInput("{!! url('/getResponder') !!}");
                  }


              }

          }
      });

  }

    @if (count($errors) > 0)

      $('#modalAddCategory').modal('show');

    @endif
</script>
@endsection
