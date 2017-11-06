<?php

namespace App\services;
use App\CalendarEvent;
use App\CalendarEventType;

class CalendarEventService
{
        protected $event;

        public function __construct(CalendarEvent $event){
                $this->event = $event;
        }

	public function getEvents(){
		return CalendarEvent::all();
	}

        public function getEvent($id){
                return CalendarEvent::find($id);
        }

        public function getEventPerType($eventType){

                $eventTypeObj = CalendarEventType::where('slug',$eventType)
                                ->first();

                return CalendarEvent::where('event_type_id',$eventTypeObj->id)
                                    ->get();
        }

        public function getCalendarsPerGroup($id){
            return CalendarEvent::where('calendar_id',$id)->get();
        } 
	
	public function store(Array $formData)
    {
                $newEvent                       = new CalendarEvent();
		        $newEvent->event_type_id 	= $formData['event_type_id'];
                $newEvent->calendar_id 	        = $formData['calendar_id'];
                $newEvent->title 		= $formData['title'];
                $newEvent->description 	        = $formData['description'];
                $newEvent->start 		= $formData['start_date'];
                $newEvent->end 		        = $formData['end_date'];
                $newEvent->progress	        = $formData['progress'];
                $newEvent->note 		= $formData['note'];
                $newEvent->color 		= $formData['color'];
                $newEvent->evenue 		= $formData['venue'];
                //$newEvent->user_id 		= $formData['user_id'];
                //$newEvent->role 		= $formData['role'];
                $newEvent->save();
	}

        public function update(Array $formData,$id){
                $updateEvent                    = CalendarEvent::find($id);
                $updateEvent->event_type_id     = $formData['event_type_id'];
                $updateEvent->calendar_id       = $formData['calendar_id'];
                $updateEvent->title             = $formData['title'];
                $updateEvent->description       = $formData['description'];
                $updateEvent->start             = $formData['start_date'];
                $updateEvent->end               = $formData['end_date'];
                $updateEvent->progress          = $formData['progress'];
                $updateEvent->note              = $formData['note'];
                $updateEvent->evenue            = $formData['venue'];
                $updateEvent->save();
        }

        public function destroy($id){
                CalendarEvent::where('id',$id)->delete();
        }




}