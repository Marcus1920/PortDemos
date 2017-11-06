<div class="listview narrow">

    @foreach($taskReminders as $taskReminder)
        <div class="media p-l-5">
            <div class="pull-left">

                <a href="#">

                    <i class="fa fa-trash-o fa-2x"></i>

                </a>

            </div>
            <div class="media-body">

                <small class="text-muted">{{ $taskReminder->duration }} </small>

            </div>
        </div>
    @endforeach

</div>

