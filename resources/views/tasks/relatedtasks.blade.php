<div class="tile">
    <h2 class="tile-title">RELATED TASKS</h2>

    <div class="tile-config dropdown">
        <a data-toggle="dropdown" href="" class="tile-menu"></a>
        <ul class="dropdown-menu pull-right text-right">
            <li><a href="{{ url('linkNewTask',$task->id) }}">Add new task</a></li>
            <li><a href="{{ url('linkExistingTask',$task->id) }}">Add existing task</a></li>
        </ul>
    </div>
    <div class="listview icon-list">
        @foreach($parentTasks as $parentTask)
            <div class="media">
                <i class="icon pull-left">&#61744</i>
                <div class="media-body"><a href="{{ url('tasks',$parentTask->id) }}">Parent - Task {{$parentTask->id}} : {{$parentTask->title}}</a></div>
            </div>
        @endforeach
    </div>
    <hr class="whiter m-t-5" />
    <div class="listview icon-list">
        @foreach($subTasks as $subTask)
            <div class="media">
                <i class="icon pull-left">&#61744</i>
                <div class="media-body"><a href="{{ url('tasks',$subTask->id) }}">Child - Task {{$subTask->id}} : {{$subTask->title}}</a></div>
            </div>
        @endforeach
    </div>
</div>