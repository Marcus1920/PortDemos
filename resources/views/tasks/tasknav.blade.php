@if(Auth::user()->id == $taskAssignee->user_id && $taskAssignee->accept == 0 )
    <a class="btn btn-sm" href="{{ url('tasks/acceptTask/'.$task->id) }}"><i  id="acceptTaskBtn"  class="fa fa-check fa-4x" aria-hidden="true"></i> Accept  </a>
    <a class="btn btn-sm" href="{{ url('tasks/rejectTask/'.$task->id) }}"><i  id="declineTaskBtn" class="fa fa-times fa-4x" aria-hidden="true"></i> Decline </a>
    <a class="btn btn-sm" href="{{ url('dateChangeRequest/'.$task->id) }}"><i  id="requestDateChangeTaskBtn" class="fa fa-calendar fa-4x" aria-hidden="true"></i> Request Date Change </a>

@endif
