<?php

namespace App\services;
use App\CalendarEventType;

class CalendarEventTypeService
{
        protected $eventType;

        public function __construct(CalendarEventType $eventType){
                $this->eventType = $eventType;
        }

	public function getEventTypes(){
		return CalendarEventType::all();
	}

        public function getEventType($slug){
                return CalendarEventType::where('slug',$slug)->first();
        }
	
	public function store(Array $formData){
                $this->eventType->name 	= $formData['name'];
                $this->eventType->slug  = $formData['name'];
                //$this->eventType->color = $formData['color'];
                $this->eventType->save();
	}

}