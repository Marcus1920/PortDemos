<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\services\CalendarGroupUserService;
use Redirect;

class CalendarGroupUserController extends Controller
{

    protected $calendarGroupUsers;

    public function __construct(CalendarGroupUserService $calendarGroupUserService)
    {
        $this->calendarGroupUsers=$calendarGroupUserService;
    }

    public function index($id)
    {
        $calendar_group_id=$id;
        return view('CalendarGroupUsers.index',compact('calendar_group_id'));
    }

    public function calendar_group_users_list($id)
    {
        $calendarGroupUsers = $this->calendarGroupUsers->getCalendarGroupUsersPerGroup($id);
        return \Datatables::of($calendarGroupUsers)
            ->addColumn('actions','

                <div class="col-md-2 m-b-15">

                   <a class="btn btn-xs btn-alt" data-toggle="modal" href="" target="">Remove</a>

                </div>
                                  '
            )
            ->make(true);
    }

    public function addCalendarUsers($id)
    {
        $calendar_group_id=$id;
        return view('CalendarGroupUsers.addUsers',compact('calendar_group_id'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user_ids=explode(",",$request->calendar_group_user_id);

        $calendarGroup_id=$request->calendar_group_id;

        for($i=0 ; $i < count($user_ids) ; $i++)
        {
            $this->calendarGroupUsers->createCalendarGroupUser($calendarGroup_id,$user_ids[$i]);
        };

        return Redirect::to('calendar-group-user/'.$calendarGroup_id);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {

    }
}
