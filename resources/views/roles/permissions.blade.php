<!-- Modal Default -->
<div class="modal fade modalAddRolePermissions" id="modalAddRolePermissions" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeGroupPermissions" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Group Permissions</h4>
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
