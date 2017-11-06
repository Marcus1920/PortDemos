<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\services\CalendarService;
use App\services\CalendarGroupService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;



class CalendarController extends Controller
{
    protected $calendars;
    protected $calendarGroup;

    public function __construct(CalendarService $service, CalendarGroupService $calendarGroupService)
    {
        $this->calendars = $service;
        $this->calendarGroup = $calendarGroupService;
    }

    public function index()
    {
        $calendar= $this->calendars->getCalendars();
        return response()->json($calendar);
    }

    public function getCalendarsPerGroup($id){
        $calendar= $this->calendars->getCalendarsPerGroup($id);
        return response()->json($calendar);
    }


    public function create($id)
    {
        $calendarGroup = $this->calendarGroup->getCalendarGroup($id);

        return view('calendar.create',compact('calendarGroup'));
    }


//    public function create()
//    {
//        return view('calendar.create');
//    }


    public function store(Request $request)
    {

        $this->calendars->storeCalendar($request);
        \Session::flash('success', 'A calendar  has been successfully added!');
        return Redirect::to('calendar/events');
    }

//    public function store(Request $request)
//    {
//            $this->calendars->storeCalendar($request);
//    }

    public function show($id)
    {
        return response()->json($this->calendars->getCalendar($id));
    }

    public function update(Request $request)
    {
        $form       = Input::all();
        $calendar   = $this->calendars->getCalendar($form['calendar_id']);
        $this->calendars->updateCalendar($form);
        return Redirect::to('calendar/'.$form['calendar_id']);
    }

    public function destroy($id)
    {

    }

    public function getCalendars()
    {
        return $this->calendars->getCalendars();
    }
}
