<div class="listview narrow">

    @foreach($taskNotes as $taskNote)
        <div class="media p-l-5">
            <div class="pull-left">

            </div>
            <div class="media-body">
                <small class="text-muted">{{ $taskNote->created_at->diffForHumans() }} by  {{ $taskNote->user->name }} {{ $taskNote->user->surname }}</small><br/>
                <a class="t-overflow" href="">{{ $taskNote->note }}</a>

            </div>
        </div>
    @endforeach

</div>