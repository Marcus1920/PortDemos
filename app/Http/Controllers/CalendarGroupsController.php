<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\services\CalendarGroupService;
use App\services\CalendarGroupUserService;
use App\User;
use Auth;
use Session;
use Redirect;
use Input;

class CalendarGroupsController extends Controller
{
    protected $calendarGroups;
    protected $calendarGroupUsers;

    public function __construct(CalendarGroupService $service,CalendarGroupUserService $calendarGroupUserService)
    {
        $this->calendarGroups=$service;
        $this->calendarGroupUsers=$calendarGroupUserService;
    }

    public function index()
    {
        return view('calendar_group.index');
    }

    public function getCalendarGroups()
    {

        $calendarGroups = $this->calendarGroups->getCalendarGroups();
        return \Datatables::of($calendarGroups)
            ->addColumn('actions','
            
                <div class="col-md-2 m-b-15">
                
                   <a class="btn btn-xs btn-alt" data-toggle="modal" href="calendar-group/{{ $id }}/edit" target="">Edit</a>
                   
                </div>
                                  '
            )
            ->addColumn('actions','<a class="btn btn-xs btn-alt" data-toggle="modal" href="calendar-group/{{ $id }}/edit" target="">Edit</a>
                                   <a class="btn btn-xs btn-alt" data-toggle="modal" href="calendar-group-user/{{$id}}" target="">View User Groups</a>

                                ')
            ->make(true);
    }

    public function create()
    {
        return view('calendar_group.create');
    }

    public function store(Request $request)
    {
        $user_ids=explode(",",$request->calendar_group_user_id);

        $calendarGroup=$this->calendarGroups->createCalendarGroup($request['name'],$request['description']);

        for($i=0 ; $i < count($user_ids) ; $i++)
        {
            $this->calendarGroupUsers->createCalendarGroupUser($calendarGroup->id,$user_ids[$i]);
        };


        return Redirect::to('calendar/events');

    }

    public function show($id)
    {
        return response()->json($this->calendarGroups->getCalendarGroups($id));
    }

    public function edit($id)
    {
        $calendarGroup=$this->calendarGroups->getCalendarGroup($id);
        return view('calendar_group/edit',compact('calendarGroup'));
    }

    public function update(Request $request)
    {
        $form       = Input::all();
        $calendarGroup   = $this->calendarGroups->getCalendarGroup($form['calendar_group_id']);
        $this->calendarGroups->updateCalendarGroup($form);
        return Redirect::to('calendar-group');
    }

    public function destroy($id)
    {
        //
    }
}
