<!-- Modal Default -->
<div class="modal fade modalAddRolePermissions" id="modalAddRolePermissions" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeGroupPermissions" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Group Permissions</h4>
            </div>
          <div class="toolbarGroupPermissions tile-config" id="toolbarGroupPermissions" style="position: inherit">
            <div class="icon tile-menu" style="display: inline-block" data-thing="" title="All">&nbsp;</div>
            <div class="icon sa-side-homepage" style="display: inline-block" data-thing="home" title="Home">&nbsp;</div>
            <div class="icon sa-side-folder" style="display: inline-block" data-thing="case" title="Cases">&nbsp;</div>
            <div class="icon sa-side-list" style="display: inline-block" data-thing="task" title="Tasks">&nbsp;</div>
            <div class="icon sa-side-calendar" style="display: inline-block" data-thing="calendar" title="Calendar">&nbsp;</div>
            <div class="icon sa-side-widget" style="display: inline-block" data-thing="meeting" title="Meetings">&nbsp;</div>
            <div class="icon sa-side-poi" style="display: inline-block; background-size: 100%;" data-thing="poi" title="PoI">&nbsp;</div>
            <div class="icon sa-side-home" style="display: inline-block" data-thing="map" title="Map">&nbsp;</div>
            <div class="icon sa-side-chart" style="display: inline-block" data-thing="report" title="Reports">&nbsp;</div>
            <div class="icon sa-side-ui" style="display: inline-block" data-thing="admin" title="Admin">&nbsp;</div>
            <div class="icon sa-side-folder" style="display: inline-block" data-thing="docrepo" title="Document Repository">&nbsp;</div>
          </div>
            <div class="modal-body">
{!! Form::open( ['url'=>url("updateGroupPermissions")] ) !!}
    {!! Form::hidden("gid", null, array( 'class'=>"form-control input-sm", 'id'=>"inGID" )) !!}
    <h3>Assigned</h3>
            <!-- Responsive Table -->
            <div class="block-area" id="responsiveTable">
                <div id="MeetingAttendeeNotification"></div>
                <div class="table-responsive overflow">
                    <table class="table tile table-striped" id="groupPermissionsTable">
                        <thead>
                          <tr>
                                <th><a id='selecctall' data-value='0'>select/All</a></th>
                                <th>Permission</th>

                          </tr>
                        </thead>
                    </table>
                </div>
            </div>
                <h3>Un-assigned</h3>
            <!-- Responsive Table -->
            <div class="block-area" id="responsiveTable">
                <div id="MeetingAttendeeNotification"></div>
                <div class="table-responsive overflow">
                    <table class="table tile table-striped" id="allPermissionsTable">
                        <thead>
                        <tr>
                            <th><a id='selecctallpermissions' data-value='0'>select/All</a></th>
                            <th>name</th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
{{--{!! Form::button( "Update" , array( 'class'=>"btn btn-sm", 'id'=>"btnUpdatePerms" )) !!}--}}
{!! Form::submit( "Update" , array( 'class'=>"btn btn-sm", 'id'=>"btnUpdatePerms" )) !!}
{{--{!! Form::button( "Update & Close" , array( 'class'=>"btn btn-sm", 'id'=>"btnUpdate2Perms" )) !!}--}}
{!! Form::close() !!}
            </div>
            <div class="modal-footer">


            </div>


        </div>
    </div>
</div>

<script>
  //$(document).ready(function() {
    $("#toolbarGroupPermissions .icon").on("click", function() {
      console.log("icon clicked: this - ",this);
      var thing = $(this).attr("data-thing");
      var oTable = $('#groupPermissionsTable').DataTable({ 'retrieve': true });
      var oPoiTable = $('#allPermissionsTable').DataTable({ 'retrieve': true });
      console.log("  thing - ",thing);
      console.log("  oTable - ",oTable);
      console.log("  oPoiTable - ",oPoiTable);
      if (oTable) oTable.columns( 1 ).search( thing ).draw();
      if (oPoiTable) oPoiTable.columns( 1 ).search( thing ).draw();
    });
  //});
</script>