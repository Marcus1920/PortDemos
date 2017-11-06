@extends('master')

@section('content')
    <!--Nav Tabs-->



    <div id="tabs">
        <ul class="nav nav-pills navbar-right" role="tablist">
            <li class="active"><a href="#global"  data-toggle="tab">Global Address Book</a></li>
            <li><a href="#private"  data-toggle="tab">Private Address Book</a></li>

        </ul>
        <h4 class="page-title">ADDRESS BOOK</h4>

        <div class="block-area" id="alternative-buttons">
            <h3 class="block-title">Add your Favorate Contacts from here!</h3>
            <a href="{{ url('tasks/create') }}" class="btn btn-sm">
                <i class="fa fa-plus" aria-hidden="true" title="Add Your New Task Here" data-toggle="tooltip"></i>
            </a>
        </div>

        <div class="tab-content">
            <div class="tab-pane" id="global">
                <!-- Responsive Table -->
                <div class="block-area" id="responsiveTable">
                    <div id="MeetingNotification"></div>
                    <div class="table-responsive overflow">


                        <div style="width:100%;" class="col-md-12">
                            <!--LEFT SIDE DIV-->
                            <div style="float:left; display:inline-block;" class="col-md-4">
                                <div class="listview narrow">
                                    <div class="form-group pull-right">
                                        <input type="text" id="myGlobalInput" class="search form-control" onkeyup="myFunction()" placeholder="Search for names..">
                                    </div>
                                        <span class="counter pull-right"></span>
                                        <table class="table table-hover table-bordered results" id="myGlobalTable">
                                            <thead>
                                            <tr>
                                                <th class="col-md-5 col-xs-5">User Full Name</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $user)

                                            <tr>
                                                <td><a class="t-overflow" href="">{{$user->name . " " . $user->surname}}</a><br/>
                                                    <small class="text-muted">{{$user->email}}</small></td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </div>

                            <!--RIGHT SIDE DIV-->

                            <div style="float:right; display:inline-block;" class="col-md-8">
                                <div class="block-area" id="basic">

                            </div>
                            </div>
                            </div>

                        </div> ​

                    </div>
                </div>
            </div>

        <div class="tab-content">
            <div class="tab-pane" id="private">
                <!-- Responsive Table -->
                <div class="block-area" id="responsiveTable">
                    <div id="MeetingNotification"></div>
                    <div class="table-responsive overflow">

                        <div style="width:100%;">
                            <!--LEFT SIDE DIV-->
                            <div style="float:left; display:inline-block;" class="div1">
                                <div class="listview narrow">
                                    <div class="form-group pull-right">
                                        <input type="text" id="myPrivateInput" class="search form-control" onkeyup="myFunction()" placeholder="Search for names..">
                                    </div>
                                    <span class="counter pull-right"></span>
                                    <table class="table table-hover table-bordered results" id="myPrivateTable">
                                        <thead>
                                        <tr>
                                            <th class="col-md-5 col-xs-5">User Full Name</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)

                                            <tr>
                                                <td><a class="t-overflow" href="">{{$user->name . " " . $user->surname}}</a><br/>
                                                    <small class="text-muted">{{$user->email}}</small></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--RIGHT SIDE DIV-->

                            <div style="float:right; display:inline-block;" class="div2">

                                <p> PUT THE PROFILE HERE</p>
                                <div class="listview narrow">
                                    <span class="counter pull-right"></span>

                                </div>

                            </div>

                        </div> ​



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

    <!--My Global Search Js-->
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("myGlobalInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myGlobalTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

    <!--Private Search Js-->
        <script>
            function myFunction() {
                var input, filter, table, tr, td, i;
                input = document.getElementById("myPrivateInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myPrivateTable");
                tr = table.getElementsByTagName("tr");

                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>

    <script>
        $(document).ready(function() {

            $("#submitUpdateUserForm").on('click',function(){

                $("#modalEditUser #ward").removeAttr("disabled");
                $("#modalEditUser #municipality").removeAttr("disabled");
                $("#modalEditUser #district").removeAttr("disabled");



            })



            var oUsersTable     = $('#globalTable').DataTable({
                "processing": true,
                "serverSide": false,
                "dom": 'Bfrtip',
                "order" :[[0,"desc"]],
                "ajax": "{!! url('/addressbook-list')!!}",
                "buttons": [
                    'copyHtml5',
                    'excelHtml5',
                    {

                        extend : 'pdfHtml5',
                        title  : 'Siyaleader',
                        header : 'I am text in',
                    },
                ],
                "columns": [

                    {data: 'id', name: 'users.id'},
                    {data: 'name', name: 'users.name'},
                    {data: 'surname', name: 'users.surname'},
                    {data: 'cellphone', name: 'users.cellphone'},
                    {data: 'position', name: 'positions.name'},
                    {data: 'actions',  name: 'actions'},

                ],

                "aoColumnDefs": [
                    { "bSearchable": false, "aTargets": [ 1,8] },
                    { "bSortable": false, "aTargets": [ 1,8 ] }
                ]

            });


            var defaultDate = $.datepicker.formatDate('yy-mm-dd', new Date());
            $("#fromDate").val(defaultDate);
            $("#toDate").val(defaultDate);

            $("#updateUserForm #province").change(function(){

                $.get("{{ url('/api/dropdown/districts/province')}}",
                    { option: $(this).val()},
                    function(data) {

                        $('#updateUserForm #municipality').attr('disabled','disabled');
                        $('#updateUserForm #ward').attr('disabled','disabled');
                        $('#updateUserForm #district').empty();
                        $('#updateUserForm #municipality').empty();
                        $('#updateUserForm #ward').empty();
                        $('#updateUserForm #district').removeAttr('disabled');
                        $('#updateUserForm #district').append("<option value='0'>Select one</option>");
                        $('#updateUserForm #municipality').append("<option value='0'>Select one</option>");
                        $('#updateUserForm #ward').append("<option value='0'>Select one</option>");
                        $.each(data, function(key, element) {
                            $('#updateUserForm #district').append("<option value="+ key +">" + element + "</option>");
                        });
                    });

            });

            $("#updateUserForm #district").change(function(){
                $.get("{{ url('/api/dropdown/municipalities/district')}}",
                    { option: $(this).val() },
                    function(data) {

                        $('#updateUserForm #ward').attr('disabled','disabled');
                        $('#updateUserForm #municipality').empty();
                        $('#updateUserForm #ward').empty();
                        $('#updateUserForm #municipality').removeAttr('disabled');
                        $('#updateUserForm #municipality').append("<option value='0'>Select one</option>");
                        $.each(data, function(key, element) {
                            $('#updateUserForm #municipality').append("<option value="+ key +">" + element + "</option>");
                        });
                    });
            });

            $("#updateUserForm #municipality").change(function(){
                $.get("{{ url('/api/dropdown/wards/municipality')}}",
                    { option: $(this).val() },
                    function(data) {
                        $('#updateUserForm #ward').empty();
                        $('#updateUserForm #ward').removeAttr('disabled');
                        $('#updateUserForm #ward').append("<option value='0'>Select one</option>");
                        $.each(data, function(key, element) {
                            $('#updateUserForm #ward').append("<option value="+ key +">" + element + "</option>");
                        });
                    });
            });





            $("#filterUsersForm #province").change(function(){

                $.get("{{ url('/api/dropdown/districts/province')}}",
                    { option: $(this).val()},
                    function(data) {

                        $('#filterUsersForm #district').empty();
                        $('#filterUsersForm #municipality').empty();
                        $('#filterUsersForm #ward').empty();
                        $('#filterUsersForm #district').removeAttr('disabled');
                        $('#filterUsersForm #district').append("<option value='0'>Select one</option>");
                        $('#filterUsersForm #municipality').append("<option value='0'>Select one</option>");
                        $('#filterUsersForm #ward').append("<option value='0'>Select one</option>");
                        $.each(data, function(key, element) {
                            $('#filterUsersForm #district').append("<option value="+ key +">" + element + "</option>");
                        });
                    });

            });

            $("#filterUsersForm #district").change(function(){
                $.get("{{ url('/api/dropdown/municipalities/district')}}",
                    { option: $(this).val() },
                    function(data) {
                        $('#filterUsersForm #municipality').empty();
                        $('#filterUsersForm #municipality').removeAttr('disabled');
                        $('#filterUsersForm #municipality').append("<option value='0'>Select one</option>");
                        $.each(data, function(key, element) {
                            $('#filterUsersForm #municipality').append("<option value="+ key +">" + element + "</option>");
                        });
                    });
            });

            $("#filterUsersForm #municipality").change(function(){
                $.get("{{ url('/api/dropdown/wards/municipality')}}",
                    { option: $(this).val() },
                    function(data) {
                        $('#filterUsersForm #ward').empty();
                        $('#filterUsersForm #ward').removeAttr('disabled');
                        $('#filterUsersForm #ward').append("<option value='0'>Select one</option>");
                        $.each(data, function(key, element) {
                            $('#filterUsersForm #ward').append("<option value="+ key +">" + element + "</option>");
                        });
                    });
            });


            $("#submitUsersFilters").on("click",function(){

                var fromDate   = $("#fromDate").val();
                var toDate     = $("#toDate").val();
                var status     = $("#status").val();
                var role       = $("#role").val();
                var gender     = $("#gender").val();
                var province   = $("#province").val();
                var district   = $("#district").val();
                var status     = $("#status").val();
                var gender     = $("#gender").val();
                var createdBy  = $("#created_by").val();
                var department = $("#department").val();
                var position   = $("#position").val();
                var token      = $('input[name="_token"]').val();
                var formData   = { position:position,createdBy:createdBy,department:department,district:district,province:province,fromDate:fromDate,toDate:toDate,status:status,role:role,gender:gender};

                $.ajax({
                    type    :"POST",
                    data    : formData,
                    headers : { 'X-CSRF-Token': token },
                    url     :"{!! url('/filterUsersReports')!!}",
                    beforeSend : function() {
                        HoldOn.open({
                            theme:"sk-rect",
                            message: "<h4> generating report please wait... ! </h4>",
                            content:"Your HTML Content",
                            backgroundColor:"none repeat scroll 0 0 rgba(0, 0, 0, 0.8)",
                            textColor:"white"
                        });

                    },
                    success : function(dataSet){


                        if ( $.fn.dataTable.isDataTable( '#usersTable' ) ) {
                            oUsersTable.destroy();
                        }


                        oUsersTable     = $('#usersTable').DataTable({
                            "data": dataSet.data,
                            "dom": 'Bfrtip',
                            "buttons": [
                                'copyHtml5',
                                'excelHtml5',
                                'csvHtml5',{

                                    extend : 'pdfHtml5',
                                    title  : 'Siyaleader',
                                    header : 'I am text in',
                                },

                            ],
                            "order" :[[0,"asc"]],
                            "columns": [

                                {data: 'id', name: 'users.id'},
                                {data: 'created_at', name: 'users.created_at'},
                                {data: 'name', name: 'users.name'},
                                {data: 'surname', name: 'users.surname'},
                                {data: 'cellphone', name: 'users.cellphone'},
                                {data: 'email', name: 'users.email'},
                                {data: 'active', name: 'users_statuses.name'},
                                {data: 'position', name: 'positions.name'},
                                {data: 'actions',  name: 'actions'},

                            ],

                        });

                        $('a.toggle-vis').on( 'click', function (e) {
                            e.preventDefault();

                            // Get the column API object
                            var column = oUsersTable.column( $(this).attr('data-column') );

                            // Toggle the visibility
                            column.visible( ! column.visible() );
                        });


                        HoldOn.close();

                    }
                })

            });





        });



        @if (count($errors) > 0)


        $('#updateUserForm #district').attr('disabled','disabled');
        $('#updateUserForm #municipality').attr('disabled','disabled');
        $('#updateUserForm #ward').attr('disabled','disabled');
        $('#modalEditUser').modal('show');

        @endif
    </script>
@endsection


