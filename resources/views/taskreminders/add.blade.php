<!-- Inline -->
<div class="row">

    <div class="block-area" id="inline">

        <p>Send an email before the event start in</p>


            <div class="col-md-2 m-b-15">

                {!! Form::open(['url' => 'task-reminders', 'method' => 'post', 'class' => 'form-horizontal' ]) !!}
                {!! Form::hidden('user_id',Auth::user()->id) !!}
                {!! Form::hidden('task_id',$task->id) !!}

                {!! Form::input('number','typeNumber',null,['class' => 'form-control input-sm','id' => 'typeNumber']) !!}


            </div>

            <div class="col-md-2 m-b-15">

                {!! Form::select('type',['minutes' => 'minute(s)','hours' => 'hour(s)','days' => 'day(s)','week' => 'week(s)', 'month' => 'month(s)' ],1,['class' => 'form-control input-sm' ,'id' => 'type']) !!}

            </div>

            <div class="col-md-2 m-b-15">
                <button type="submit" class="btn btn-info btn-sm m-t-">ADD REMINDER</button>
            </div>


    </div>


</div>

<hr class="whiter m-t-20" />

<br/>
<br/>


<div class="row">
    <div class="col-md-12">
        <div>
            <h2 class="tile-title">REMINDERS</h2>

            @include('taskreminders.list')

        </div>
    </div>

</div>




