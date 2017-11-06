<!-- Tasks to do -->

    <div class="tile">
        <h2 class="tile-title">Sub Tasks to do</h2>
        <div class="tile-config dropdown">
            <a data-toggle="dropdown" href="" class="tile-menu"></a>
            <ul class="dropdown-menu pull-right text-right">
                <li id="todo-add"><a href="{{ url('sub-tasks',$task->id) }}">Add New Sub Task</a></li>
                <li id="todo-refresh"><a href="">Refresh</a></li>
                <li id="todo-clear"><a href="">Clear All</a></li>
            </ul>
        </div>

        <div class="listview todo-list sortable">
            <div class="media">
                <div class="checkbox m-0">
                    <label class="t-overflow">
                        <input type="checkbox">
                        Curabitur quis nisi ut nunc gravida suscipis
                    </label>
                </div>
            </div>

            <div class="media">
                <div class="checkbox m-0">
                    <label class="t-overflow">
                        <input type="checkbox">
                        Fedrix quis nisi ut nunc gravida suscipit at feugiat purus
                    </label>
                </div>

            </div>
        </div>

        <h2 class="tile-title">Completed Sub Tasks</h2>
        <div class="listview todo-list sortable">
            <div class="media">
                <div class="checkbox m-0">
                    <label class="t-overflow">
                        <input type="checkbox" checked="checked">
                        Motor susbect win latictals bin the woodat cool
                    </label>
                </div>

            </div>

        </div>
    </div>

<!-- END Tasks to do -->

