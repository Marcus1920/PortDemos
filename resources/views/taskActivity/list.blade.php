<div class="listview narrow">

    @foreach($taskActivities as $taskActivity)
        <div class="media p-l-5">
            <div class="pull-left">

            </div>
            <div class="media-body">
                <a class="t-overflow" href="">{{ $taskActivity->user->name }} {{ $taskActivity->user->surname }} {{ $taskActivity->note }}</a><br/>
                <small class="text-muted">{{ $taskActivity->created_at->diffForHumans() }} </small>

            </div>
        </div>
    @endforeach

</div>