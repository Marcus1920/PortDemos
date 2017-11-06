<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MeetingRequest;
use App\Http\Requests\MeetingAttendeeRequest;
use App\Http\Requests\AddressBookRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Meeting;
use App\MeetingFacilitator;
use App\MeetingAttendee;
use App\MeetingVenue;
use App\MeetingFile;
use App\User;
use App\addressbook;
use App\CalendarEvent;
use App\services\CalendarEventService;
use App\services\CalendarService;
use App\services\CalendarEventTypeService;
use App\CalendarEventType;
use App\Calendar;

class MeetingsController extends Controller {
	
	protected $calendar_events;
	protected $calendar;
	protected $eventType;

    public function __construct(CalendarEventService $calendar_event_service, CalendarService $calendar, CalendarEventTypeService $eventType)
    {
        $this->calendar_events   = $calendar_event_service;
        $this->calendar          = $calendar;
        $this->eventType         = $eventType;

    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$meetings = \DB::table('meetings')
			->join('meetings_venues', 'meetings.venue', '=', 'meetings_venues.id')
			->select(
				\DB::raw("
                                        meetings.`id`,
                                        meetings.`title`,
                                        meetings.`description`,
                                        meetings.`date`,
                                        meetings.`venue`,
                                        meetings.`start_time`,
                                        meetings.`end_time`,
                                        meetings.`file_url`,
                                        meetings_venues.`name`"
				)
			)
			->groupBy('meetings.id');

		return \Datatables::of($meetings)
			->addColumn('actions', '

                                                    <div class="col-md-2 m-b-15">
                                                        <select onchange="getval(this,{{$id}});" class="form-control input-sm selMeetingOptions">
                                                            <option value="0">Select</option>
                                                            <option value="a_att">View/Add Attendees</option>
                                                            <option value="u_file">View/Upload Files</option>
                                                        </select>
                                                    </div>

                                                  '
			)
			->make(true);
	}

	function indexAttendee($id) {
		$meetingAttendees = \DB::table('meetings_attendees')
			->where('meeting', '=', $id)
			->select(
				\DB::raw("
                                        meetings_attendees.id,
                                        IF(`meetings_attendees`.`phonebook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `meetings_attendees`.`attendee`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `meetings_attendees`.`attendee`)) as name,
                                        IF(`meetings_attendees`.`phonebook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `meetings_attendees`.`attendee`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `meetings_attendees`.`attendee`)) as cellphone,
                                        meetings_attendees.meeting,
                                        meetings_attendees.attendee,
                                        meetings_attendees.phonebook,
                                        meetings_attendees.created_by,
                                        meetings_attendees.invited,
                                        meetings_attendees.accepted,
                                        meetings_attendees.updated_by,
                                        meetings_attendees.attended
                                    "
				)
			)
			->groupBy('meetings_attendees.id');

		return \Datatables::of($meetingAttendees)
			->make(true);
	}

	function indexFiles($id) {
		$meetingFiles = \DB::table('meetings_files')
			->where('meeting_id', '=', $id)
			->select(
				\DB::raw("
                                        meetings_files.id,
                                        IF(`meetings_files`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `meetings_files`.`user`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `meetings_files`.`user`)) as name,
                                        IF(`meetings_files`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `meetings_files`.`user`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `meetings_files`.`user`)) as cellphone,
                                        meetings_files.meeting_id,
                                        meetings_files.user,
                                        meetings_files.addressbook,
                                        meetings_files.created_at,
                                        meetings_files.file_note as description,
                                        meetings_files.img_url,
                                        meetings_files.file

                                    "
				)
			)
			->orderBy('meetings_files.created_at', 'desc');

		return \Datatables::of($meetingFiles)
			->make(true);
	}

    public function uploadMeetingMinutes(Request $request)
    {
		$destinationFolder = 'minutes/meeting_' . $request['meetingID'];
		if (!\File::exists($destinationFolder)) {
			$createDir = \File::makeDirectory($destinationFolder, 0777, true);
		}
		$fileName     = $request->file('minuteFile')->getClientOriginalName();
		$fileFullPath = $destinationFolder . '/' . $fileName;
		if (!\File::exists($fileFullPath)) {
			$request->file('minuteFile')->move($destinationFolder, $fileName);
			$meetingAttendees                = MeetingAttendee::where('meeting', '=', $request['meetingID'])->get();
			$meetingMinutesFile              = new MeetingFile();
			$meetingMinutesFile->file        = $fileName;
			$meetingMinutesFile->img_url     = $fileFullPath;
			$meetingMinutesFile->user        = \Auth::user()->id;
			$meetingMinutesFile->addressbook = 0;
			$meetingMinutesFile->meeting_id  = $request['meetingID'];
			$meetingMinutesFile->file_note   = $request['fileNote'];
			$meetingMinutesFile->save();
			foreach ($meetingAttendees as $meetingAttendee) {
				if ($meetingAttendee->addressbook == 1) {
					$addressbook = addressbook::find($meetingAttendee->attendee);
					$data        = array(
						'name'         => $addressbook->name,
						'caseID'       => $request['caseID'],
						'caseNote'     => $fileName,
						'caseFileDesc' => $request['fileNote'],
						'author'       => \Auth::user()->name . ' ' . \Auth::user()->surname
					);
					\Mail::send('meetings.email', $data, function ($message) use ($addressbook) {
						$message->from('info@siyaleader.net', 'Siyaleader');
						$message->to($addressbook->email)->subject("Siyaleader Notification - New Case File Uploaded: ");
					});
				}
				else {
					$user = User::find($meetingAttendee->attendee);
					$data = array(
						'name'         => $user->name,
						'caseID'       => $request['caseID'],
						'caseNote'     => $fileName,
						'caseFileDesc' => $request['fileNote'],
						'author'       => \Auth::user()->name . ' ' . \Auth::user()->surname
					);
					\Mail::send('meetings.email', $data, function ($message) use ($user) {
						$message->from('info@siyaleader.net', 'Siyaleader');
						$message->to($user->email)->subject("Siyaleader Notification - New Case File Uploaded: ");
					});
				}
			}

			return "ok";
		}

		return "ok";
	}

    public function store(MeetingRequest $request) {
		$response             = array();
		$meeting              = new Meeting();
		$meeting->venue       = $request['venue'];
		$meeting->title       = $request['title'];
		$meeting->description = $request['description'];
		$meeting->date        = $request['date'];
		$meeting->start_time  = $request['start_time'];
		$meeting->end_time    = $request['end_time'];
		$meeting->created_by  = \Auth::user()->id;
		$meeting->save();
		
		
		

        $eventType = $this->eventType->getEventType('Meeting');
        $calendar  = $this->calendar->getCalendarPerGroup($eventType->id,6);

        $meetingEventData =
            [
                'event_type_id' => $eventType->id,
                'calendar_id'   => $calendar->id,
                'title'         => $request['title'],
                'description'   =>$request['description'],
                'start_date'    => $request['date'],
                'end_date'      => $request['date'],
                'progress'      => 0,
                'color'         =>$calendar->color,
                'note'          => '',
                //'user_id'       => '1',
                //'role'          => '1',
                'venue' => $request['venue']
            ];

        $this->calendar_events->store($meetingEventData);
		
		
		
		$userObj                     = User::find(\Auth::user()->id);
		$cellphone                   = '27' . (ltrim($userObj->cellphone, '0'));
		$meetingAttendee             = new MeetingAttendee();
		$meetingAttendee->meeting    = $meeting->id;
		$meetingAttendee->attendee   = \Auth::user()->id;
		$meetingAttendee->phonebook  = 0;
		$meetingAttendee->mobile     = $cellphone;
		$meetingAttendee->created_by = \Auth::user()->id;
		$meetingAttendee->save();
		$calendarEvent                = new CalendarEvent();
		$calendarEvent->name          = $request['title'];
		$calendarEvent->start_date    = $request['date'];
		$calendarEvent->end_date      = $request['date'];
		$calendarEvent->start_time    = $request['start_time'];
		$calendarEvent->end_time      = $request['end_time'];
		$calendarEvent->event_type_id = 1;
		$calendarEvent->meeting_id    = $meeting->id;
		$calendarEvent->locked        = 1;
		$calendarEvent->created_by    = \Auth::user()->id;
		$calendarEvent->save();
		$facilitators = explode(',', $request['facilitators']);
		foreach ($facilitators as $facilitator) {
			$userObj     = User::where('email', '=', $facilitator)->first();
			$userId      = 0;
			$addressbook = 0;
			if (count($userObj) > 0) {
				$userId = $userObj->id;
			}
			else {
				$userObj     = addressbook::where('email', '=', $facilitator)->first();
				$userId      = $userObj->id;
				$addressbook = 1;
			}
			$meetingFacilitator              = new MeetingFacilitator();
			$meetingFacilitator->meeting     = $meeting->id;
			$meetingFacilitator->facilitator = $userId;
			$meetingFacilitator->addressbook = $addressbook;
			$meetingFacilitator->created_by  = \Auth::user()->id;
			$meetingFacilitator->save();
		}

		return \Response::make('Meeting Created!');
	}

	public function storeAttendee(MeetingAttendeeRequest $request) {
		$response = array();
		if (!$request['attendees']) {
			$addressbook             = new addressbook();
			$addressbook->first_name = $request['first_name'];
			$addressbook->surname    = $request['surname'];
			$addressbook->email      = $request['email'];
			$addressbook->cellphone  = $request['cellphone'];
			$addressbook->user       = \Auth::user()->id;
			$addressbook->active     = 1;
			$addressbook->save();
			$meetingAttendee             = new MeetingAttendee();
			$meetingAttendee->meeting    = $request['meetingID'];
			$meetingAttendee->attendee   = $addressbook->id;
			$meetingAttendee->phonebook  = 1;
			$meetingAttendee->created_by = \Auth::user()->id;
			$meetingAttendee->save();
		}
		else {
			$attendees = explode(',', $request['attendees']);
			foreach ($attendees as $attendee) {
				$userObj     = User::where('email', '=', $attendee)->first();
				$userId      = 0;
				$addressbook = 0;
				if (count($userObj) > 0) {
					$userId    = $userObj->id;
					$cellphone = '27' . (ltrim($userObj->cellphone, '0'));
				}
				else {
					$userObj     = addressbook::where('email', '=', $attendee)->first();
					$userId      = $userObj->id;
					$cellphone   = '27' . (ltrim($userObj->cellphone, '0'));
					$addressbook = 1;
				}
				$meetingAttendee             = new MeetingAttendee();
				$meetingAttendee->meeting    = $request['meetingID'];
				$meetingAttendee->attendee   = $userId;
				$meetingAttendee->phonebook  = $addressbook;
				$meetingAttendee->mobile     = $cellphone;
				$meetingAttendee->created_by = \Auth::user()->id;
				$meetingAttendee->save();
			}
		}
		$response["message"]   = "Meeting Attendees Added!";
		$response["error"]     = false;
		$response["meetingID"] = $request['meetingID'];

		return \Response::json($response, 201);
	}


	public function show($id) {
		//
	}

	public function removeAttendee(Request $request) {
		$response = array();
		foreach ($request['arr'] as $value) {
			$meetingAttendee = MeetingAttendee::find($value);
			$meetingAttendee->delete();
		}
		$response["message"]   = "Meeting Attendees Deleted!";
		$response["error"]     = false;
		$response["meetingID"] = $request['id'];

		return \Response::json($response, 201);
	}


	public function inviteAttendee(Request $request) {
		$txtDebug = __CLASS__."::".__FUNCTION__."(\$request)";
		$txtDebug .= PHP_EOL."  \$request - ".print_r($request->all(),1);
		$response = array();
		foreach ($request['arr'] as $value) {
			$userAddressbook = null;
			$user = null;
			$meetingAttendee          = MeetingAttendee::find($value);
			$meetingAttendee->invited = 1;
			$meetingAttendee->save();
			$txtDebug .= PHP_EOL."  \$meetingAttendee - ".print_r($meetingAttendee,1);
			if ($meetingAttendee->phonebook == 1) {
				$userAddressbook = addressbook::find($meetingAttendee->attendee);
			}
			else {
				$user = User::find($meetingAttendee->attendee);
			}
			$txtDebug .= PHP_EOL."  \$userAddressbook - ".print_r($userAddressbook,1);
			$txtDebug .= PHP_EOL."  \$user - ".print_r($user,1);
			//die("<pre>{$txtDebug}</pre>");
			$email = ($meetingAttendee->phonebook == 1) ? $userAddressbook->email : $user->email;
			$cellphone = ($meetingAttendee->phonebook == 1) ? $userAddressbook->cellphone : $user->cellphone;
			$details = array('cellphone'=>$cellphone,'email'=>$email);
			$txtDebug .= PHP_EOL."  \$details - ".print_r($details,1);
			if (sizeof($user) <= 0) {
				$userAddressbook = addressbook::where('email', '=', $address)->first();
			}
			$meeting      = Meeting::find($meetingAttendee->meeting);
			///$txtDebug .= PHP_EOL."  \$meeting - ".print_r($meeting,1);
			$meetingVenue = MeetingVenue::find($meeting->venue);
			$data         = array(
				'meetingID'    => $meetingAttendee->meeting,
				'meetingName'  => $meeting->title,
				'meetingDate'  => $meeting->date,
				'meetingTime'  => $meeting->start_time,
				'meetingVenue' => $meetingVenue->name
			);
			\Mail::send('emails.meetingInviteEmail', $data, function ($message) use ($details) {
				$message->from('info@siyaleader.net', 'Siyaleader');
				$message->to($details['email'])->subject("Meeting Invitation");
			});
		}
		$response["message"]   = "Meeting Attendees Invited!";
		$response["error"]     = false;
		$response["meetingID"] = $request['id'];
		//die("<pre>{$txtDebug}</pre>");
		return \Response::json($response, 201);
	}


	public function markAttendee(Request $request) {
		$response = array();
		foreach ($request['arr'] as $value) {
			$meetingAttendee           = MeetingAttendee::find($value);
			$meetingAttendee->attended = 1;
			$meetingAttendee->save();
		}
		$response["message"]   = "Meeting Attendees Attended!";
		$response["error"]     = false;
		$response["meetingID"] = $request['id'];

		return \Response::json($response, 201);
	}
}
