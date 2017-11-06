<!-- Modal Default -->
<div class="modal fade modalAddEvent" id="modalAddEvent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id='depTitle'>Create New Event</h4>
            </div>
            <div class="modal-body">
                 <div class="list-group">
                    @foreach($eventTypes as $eventType)
                        <li onclick="getEventTypes({{ $eventType->id }})" class="list-group-item"><i class="glyphicon glyphicon-calendar" style="margin-right: 30px;"></i>New {{ $eventType->name }} <span class="badge">12</span></li>
                    @endforeach
                </div> 
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    

    function getEventTypes(id){

        this.eventType = id;

        var thatThing = "modalAdd"+ this.eventType + "CaseEvent";

        $('#modalAdd' +this.eventType + 'Event').modal('toggle');
    }

</script>
