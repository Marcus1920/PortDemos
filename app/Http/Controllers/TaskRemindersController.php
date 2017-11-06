<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\TaskReminderService;
use Redirect;
use Session;

class TaskRemindersController extends Controller

{
    protected $reminder;

    public function __construct(TaskReminderService $service)
    {
        $this->reminder=$service;
    }

    public function index()
    {
        $data =$this->reminder->getReminders();
        return response()->json($data);
    }

    public function create()
    {


    }

    public function store(Request $request)
    {

        switch ($request['type']){


            case 'minutes' :

                $duration = $request['typeNumber'] * 1;

                break;

            case 'hours' :

                $duration = $request['typeNumber'] * 60;

                break;

            case 'days' :

                $duration = $request['typeNumber'] * 1440;

                break;
            case 'weeks' :

                $duration = $request['typeNumber'] * 10080;

                break;

            case 'months':

                $duration = $request['typeNumber'] * 43800;

                break;


        }

        $request['duration'] = $duration;

        $reminderObj    =$this->reminder->createReminders($request);
        \Session::flash('success', 'well done! reminder for Task '.$reminderObj['task_id'].' has been added!');
        return Redirect::to('tasks/'.$reminderObj['task_id']);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        $reminderObj    =$this->reminder->deleteReminders($id);
        return Redirect::to('tasks/'.$reminderObj['task_id']);


    }
}
