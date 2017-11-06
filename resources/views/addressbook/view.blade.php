@extends('master')
@section('content')
    <div id="tabs">
    <ul class="nav nav-pills  navbar-right responsive" role="tablist">


        <li class="active"><a href="#private"  data-toggle="tab">Private Address Book</a></li>
        <li><a href="#global"  data-toggle="tab">Global Address Book</a></li>

    </ul>
    <h4 class="page-title">ADDRESS BOOK</h4>

    <div class="container-fluid" style="margin-top: 2%; border-color: white; align-content: center">

        <div class="tab-content responsive">

            <!--Global Content Tab-->
            @include('addressbook.globalTab')
            <!--Private Content Tab-->
            @include('addressbook.privateTab')

        </div>

    </div>
    </div>
@endsection
@section('footer')
    <script>
        $( function() {
            $( "#tabs" ).tabs();
        } );
    </script>
    <!--sending Emails from Profiles-->
    <script>
        $(document).ready(function () {
        });
        function getUserEmail() {
            var UserId = document.getElementById("user_id").value;
            var token = $('input[name="_token"]').val();
            $.ajax({
                type: "GET",
                headers: {'X-CSRF-Token': token},
                dataType: "json",
                url: "{!! url('/getEmail/"+ UserId +"')!!}",
                success: function (data) {
                    var UserEmailId = data.email;
                    console.log(UserEmailId);
                    window.location.href = '/sendEmail/' + UserEmailId;
                },
                error: function (xhr, status) {
                    console.log("Sorry, there was a problem!");
                },
                complete: function (xhr, status) {
                }
            });
        }

        function sendGlobalEmail() {
            var UserId = document.getElementById("user").value;
            var token            = $('input[name="_token"]').val();
            $.ajax({
                type: "GET",
                headers : { 'X-CSRF-Token': token },
                dataType: "json",
                url: "{!! url('/getEmail/"+ UserId +"')!!}",
                success: function (data) {
                    var UserEmailId = data.email;
                    window.location.href = '/sendEmail/' + UserEmailId;
                },
                error: function (xhr, status) {
                    console.log("Sorry, there was a problem!");
                },
                complete: function (xhr, status) {
                }
            });
        }

    </script>
    <!--Add Multiple Contacts to Private-->
    <script>
        $('#add_button').click(function() {
            var token            = $('input[name="_token"]').val();
            var checkboxValues   = $('input.names:checked','#myGlobalTable').map(function() {
                return $(this).val();
            }).get();

            $.ajax({
                type    :"GET",
                data    : {'data':checkboxValues},
                headers : { 'X-CSRF-Token': token },
                url     :"{!! url('/addToPrivate')!!}",
                success: function (data) {
                    location.reload();
                    if (data[0] !== null)
                    {
                        console.log('okay');
                    }
                    else {
                        console.log('no data');
                    }
                }
            });

        });
    </script>
    <!--Remove multiple Contacts From Private-->
    <script>
        $('#remove_button').click(function() {
            var token            = $('input[name="_token"]').val();
            var checkboxValues   = $('input.removeContacts:checked','#myPrivateTable').map(function() {
                return $(this).val();
            }).get();
            $.ajax({
                type    :"GET",
                data    : {'data':checkboxValues},
                headers : { 'X-CSRF-Token': token },
                url     :"{!! url('/removeFromPrivate')!!}",
                success: function (data) {
                    location.reload();
                    if (data[0] !== null)
                    {
                        console.log('okay');
                    }else{
                        alert('Please select at least One Field');
                    }
                },
                error: function (data) {

                    if (data[0] === null) {


                    }
                }
            });

        });
    </script>
    <!--Showing user Profile-->
    <script>
        $(document).ready(function () {
        });

        function profileGlobal(id) {
            $.ajax({
                url:"{!! url('/userprofileGlobal/"+ id + "')!!}",
                type: "GET",
                dataType: "json",
                success: function(data) {

                    $('#first_name').val(data.name);
                    $('#user').val(data.id);
                    $('#email').val(data.email);
                    $('#Surname').val(data.surname);
                    $('#cellphone').val(data.cellphone);
                },
                error: function (xhr, status) {
                    alert("Sorry, there was a problem!");
                },
                complete: function (xhr, status) {
                }
            });
        }

        function profilePrivate(id) {
					console.log("profilePrivate(id) id - ",id);
            $.ajax({
                url:"{!! url('/userprofilePrivate/"+ id + "')!!}",
                type: "GET",
                dataType: "json",
                success: function(data) {
									console.log("success(data) data - ",data);
										$('#profileForm #id').val(data.id);
                    $('#profileForm #name').val(data.first_name);
                    $('#profileForm #surname').val(data.surname);
                    $('#profileForm #email_address').val(data.email);
                    $('#profileForm #user_id').val(data.user);
                    $('#profileForm #cellphone').val(data.cellphone);
                    $('#profileForm #txtNotes').val(data.notes);

                },
                error: function (xhr, status) {
                    alert("Sorry, there was a problem!");
                },
                complete: function (xhr, status) {
									console.log("complete(xhr, status) xhr - ",xhr,", status - ",status);
                }
            });
        }




        function deleteuser() {

            var deleteUserId = document.getElementById("user_id").value;

            $.ajax({
                url: "{!! url('/deleteuserprofilePrivate/"+deleteUserId+"')!!}",
                type: "GET",
                dataType: "json",
                success: function (data) {


                    location.reload();

                },
                error: function (xhr, status) {
                    alert("Sorry, there was a problem!");
                },
                complete: function (xhr, status) {
                }
            });
        }
    </script>
    <!--Sending Emails to Multiple Contacts-->
    <script>
        $(document).ready(function () {
        });
        $('#emailsFromPrivate').click(function() {
            var token            = $('input[name="_token"]').val();
            var checkboxValues   = $('input.removeContacts:checked','#myPrivateTable').map(function() {
                return $(this).val();
            }).get();
            $.ajax({
                type    :"GET",
                data    : {'data':checkboxValues},
                headers : { 'X-CSRF-Token': token },
                url     :"{!! url('/getEmailsFromPrivate')!!}",
                success: function (data) {
                    if (data[0] !== null)
                    {
                        var  emails = [];
                        for(var i=0;i<data.length;i++)
                        {
                            emails.push(data[i].email);
                        }
                        window.location = '/sendMultipleEmail/'+ emails;
                    }
                    else {
                        console.log('no data');
                    }
                }
            });

        });

        $('#emailsFromGlobal').click(function() {
            var token            = $('input[name="_token"]').val();
            var checkboxValues   = $('input.names:checked','#myGlobalTable').map(function() {
                return $(this).val();
            }).get();
            $.ajax({
                type    :"GET",
                data    : {'data':checkboxValues},
                headers : { 'X-CSRF-Token': token },
                url     :"{!! url('/getEmailsFromPrivate')!!}",
                success: function (data) {
                    if (data[0] !== null)
                    {
                        var  emails = [];
                        for(var i=0;i<data.length;i++)
                        {
                            emails.push(data[i].email);
                        }
                        window.location = '/sendMultipleEmail/'+ emails;
                    }
                    else {
                        console.log('no data');
                    }
                }
            });

        });
    </script>
    <!--Show active global-->
    <script>
        $(document).ready(function(){
            $("#myGlobalTable").on('click','.clickable-row',function(event){
                if($(this).hasClass('active'))
                {
                    $(this).removeClass('active');

                } else{
                    $(this).addClass('active').siblings().removeClass('active');
                }
            });

            $("#myPrivateTable").on('click','.clickable-private',function(event){
                if($(this).hasClass('active'))
                {
                    $(this).removeClass('active');

                } else{
                    $(this).addClass('active').siblings().removeClass('active');
                }
            });
        });

    </script>

    <script>
        function globalFunction() {
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
    <!--PRIVATE SEARCH JS-->
    <script>
        function privateFunction() {
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
    @endsection