<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RolesRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\UserRole;
use App\CalendarGroup;
use App\services\CalendarGroupService;
use App\services\CalendarGroupUserService;
use App\services\CalendarService;
use App\services\CalendarEventTypeService;


class RolesController extends Controller
{
	
	protected $calendarGroup;
    protected $calendarGroupUser;
    protected $calendar;
    protected $eventType;

    public function __construct(CalendarGroupService $calendarGroupService,CalendarGroupUserService $calendarGroupUserService ,CalendarService $calendarService, CalendarEventTypeService $eventType)
    {
        $this->calendarGroup=$calendarGroupService;
        $this->calendarGroupUser=$calendarGroupUserService;
        $this->calendar=$calendarService;
        $this->eventType = $eventType;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = UserRole::select(array('id','name','created_at'));
        return \Datatables::of($roles)
                            ->addColumn('actions','<a class="btn btn-xs btn-alt" data-toggle="modal" onClick="launchUpdateRoleModal({{$id}});" data-target=".modalEditRole">Edit</a>
                                                    <a class="btn btn-xs btn-alt" data-toggle="modal" onClick="launchPermissions({{$id}});" data-target=".modalAddRolePermissions">Permissions</a>

                                ')
                            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolesRequest $request)
    {
        $roles = UserRole::orderBy('name')->get();
        $userGroups = CalendarGroup::orderBy('name')->get();

        

        foreach ($roles as $role) {
            foreach ($userGroups as &$userGroup) {
                if($role->name != $userGroup->name){
                    //$next = current($roles);
                   // echo $role->name ." " . $userGroup->name ."<br/>";

                   // $names[] = $role->name;
                    $tempcalendarGroup = $this->calendarGroup->createCalendarGroup($role->name,$role->name);
                    $this->calendarGroupUser->createCalendarGroupUser($tempcalendarGroup->id,$role->id);

                    $eventTypes = $this->eventType->getEventTypes();
                    
                    foreach ($eventTypes as $eventType) {

                        $data = [
                            // 'name'              => $eventType->name,
                            'event_type_id'        => $eventType->id,
                            'description'          => $eventType->name,
                            'color'                => $eventType->color,
                            'calendar_group_id'    => $tempcalendarGroup->id,
                        ];

                        $this->calendar->storeCalendar($data);
                    }
                }
                break;
            }
            
             # code...
        }

        //dd($names);
        $role             = new UserRole();
		//$role->id         = 27;
        $role->name       = $request['name'];
        $slug             = preg_replace('/\s+/','-',$request['name']);
        $role->slug       = $slug;
        $role->created_by = \Auth::user()->id;
        $role->save();
		
		$calendarGroup=$this->calendarGroup->createCalendarGroup($request['name'],$request['name']);
        $this->calendarGroupUser->createCalendarGroupUser($calendarGroup->id,$role->id);
        $request['calendar_group_id']= $calendarGroup->id;

        $eventTypes = $this->eventType->getEventTypes();

        foreach ($eventTypes as $eventType) {

            $data = [
                        // 'name'              => $eventType->name,
                        'event_type_id'        => $eventType->id,
                        'description'          => $eventType->name,
                        'color'                => $eventType->color,
                        'calendar_group_id'    => $calendarGroup->id,
                    ];

                    $this->calendar->storeCalendar($data);
        }
        
		
        \Session::flash('success', 'well done! User Group '.$request['name'].' has been successfully added!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role    = UserRole::where('id',$id)->first();
        return [$role];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolesRequest $request)
    {
        $role             = UserRole::where('id',$request['roleID'])->first();
        $role->name       = $request['name'];
        $role->updated_by = \Auth::user()->id;
        $role->save();
        \Session::flash('success', 'well done! User Group '.$request['name'].' has been successfully updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
