<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\services\CalendarEventService;
use App\CalendarEventType;
use App\services\CalendarGroupService;
use App\services\CalendarService;
use App\services\CalendarEventTypeService;


class CalendarEventsController extends Controller
{
    protected $calendarService;
    protected $calendarGroupService;
    protected $calendarEventService;
    protected $calendarEventTypes;

    public function __construct(CalendarEventService $calendarEventService, CalendarGroupService $calendarGroupService, CalendarService $calendarService, CalendarEventTypeService $calendarEventTypes){
        $this->calendarService = $calendarService;
        $this->calendarGroupService= $calendarGroupService;
        $this->calendarEventService = $calendarEventService;
        $this->calendarEventTypes = $calendarEventTypes;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendarGroups=$this->calendarGroupService->getCalendarGroups();
        $calendars=$this->calendarService->getCalendars();
        $eventTypes = $this->calendarEventTypes->getEventTypes();
        return view('calendarEvents.view',compact('calendars','calendarGroups','eventTypes'));
    }

    public function getEvents(){
        return $this->calendarEventService->getEvents();
    }

    public function openCreateEventView(){
        return view('calendarEvents.create');
    }

    public function getEventPerType($event_type_id){
        return $this->calendarService->getEventPerType($event_type_id);
    }

    public function getCalendarsPerGroup($id){
        return $this->calendarEventService->getCalendarsPerGroup($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $eventType = CalendarEventType::where('slug',$request['eventType'])->first();

        $data = [
                     'event_type_id'    => $eventType->id,
                     'calendar_id'      => 1,
                     'progress'         => 30,
                ];

        $formData = $request->all();

        $allData = $data + $formData;

        $this->calendarService->store($allData);

        return redirect('calendar/events');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->calendarService->getEvent($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->calendarService->destroy($id);
    }
}
