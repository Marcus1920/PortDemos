
@extends('master')

@section('content')


    <script>

        $(document).ready(function() {
           // jQuery.migrateMute = true;
            $.fn.dataTableExt.sErrMode = 'throw';
        })
    </script>


    <div class="tab-pane" id="closure">
        <!-- Responsive Table -->
        <div class="block-area" id="responsiveTable">
            <div class="table-responsive overflow">
                <h3 class="block-title">All Cases</h3>

                <a href="{{ url('creatCase') }}" class="btn btn-info" role="button">Create Case</a>

                @if(Session::has('success'))
                    <div class="alert alert-success alert-icon">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('success') }}
                        <i class="icon">&#61845;</i>
                    </div>
                @endif
				@if(1==2)
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2">

                                <div >
                                    <div class="input-icon datetime-pick date-only">
                                        <input data-format="yyyy-MM-dd" type="text" id='commencement_date' placeholder="Filter From" name ='commencement_date' class="form-control input-focused"  style="color:#FFFFFF"/>
                                        <span class="add-on">
                      <i class="sa-plus"></i>
                            </span>
                                    </div>
                                </div>

                        </div>
                        <div class="col-md-2">
                            <div >

                                <div class="input-icon datetime-pick date-only">
                                    <input data-format="yyyy-MM-dd" type="text" id='commencement_date' placeholder="To" name ='commencement_date' class="form-control input-focused"  style="color:#FFFFFF"/>
                                    <span class="add-on">
                      <i class="sa-plus"></i>
                            </span>
                                </div>



                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">

                                <div >
                                    <select class="form-control input-focused">
                                        <option> Select Busines unit </option>
                                        <option> Marine Craft  </option>
                                        <option> Port Volumes </option>
                                        <option> Port Facilities </option>
                                        <option> Passenger Termina </option>
                                    </select>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div >
                                <select class="form-control input-focused">
                                    <option> Select Category  </option>

                                    <option>  Speed   </option>
                                    <option>  Overstay </option>
                                    <option> Overstay   </option>

                                </select>


                            </div>
                        </div>
                        <div class="col-md-2">
                            <div >
                                <select class="form-control input-focused">
                                    <option> Select Ports  </option>
                                    <option>  Durban  </option>
                                    <option> Richards Bay </option>
                                    <option> Cape Town </option>
                                    <option> Port Elizabeth </option>
                                    <option> East London </option>
                                    <option> Port Elizabeth </option>
                                    <option> East London </option>
                                    <option> Mossel Bay</option>
                                    <option> Saldanha Bay</option>
                                    <option> Port Nolloth </option>
                                    <option> Coega </option>
                                </select>


                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="">
                                <div class="input-group">
                                    <input type="text" class="form-control input-focused" placeholder="Search for...">
                                    <span class="input-group-btn">
        <button class="btn btn-default" type="button">Search</button>
      </span>
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                        </div>
                    </div>
                </div>
                @endif
				<table class="table tile table-striped" id="allCasesTable">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Created At</th>
                        <th>Description</th>
                        <th>Source</th>
                        <th>Status</th>
                        {{--<th>Seen</th>--}}
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>



    </script>





    <script>

        $(document).ready(function () {
console.log("Im getting called at line 153 in resources/views/cases/pendingCases.blade.php");

            var pendingreferralCasesTable     = $('#allCasesTable').DataTable({
                "autoWidth": false,

                "processing": true,
                speed: 500,
                "dom": 'T<"clear">lfrtip',
                "order" :[[0,"desc"]],
                "ajax": "{!! url('/all-cases-list/')!!}","processing": true,
                "serverSide": true,
                "dom": 'T<"clear">lfrtip',
                "order" :[[0,"desc"]],



                "columns": [
                    {data: 'id', name: 'cases.id'},
                    {data: 'created_at', name: 'cases.created_at'},
                    {data: function(d){

                        return d.description;

                    },"name" : 'cases.description'},
                    {data: 'source', name: 'cases_sources.name'},
                    {data: 'CaseStatus', name: 'cases_statuses.name'},
                    {data: 'actions',  name: 'actions'},
                ],

                "aoColumnDefs": [
                    { "bSearchable": true, "aTargets": [ 2] },
                    { "bSortable": false, "aTargets": [ 1 ] }
                ]

            });


        });

    </script>

@endsection