<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CaseRequest;
use App\Http\Requests\CaseRequestH;
use App\Http\Requests\CreateCaseRequest;
use App\Http\Requests\CreateCaseAgentRequest;
use App\Http\Controllers\Controller;
use App\CaseReport;
use App\CaseStatus;
use App\CaseOwner;
use App\User;
use App\UserRole;
use App\addressbook;
use App\CaseEscalator;
use App\CaseActivity;
use App\Department;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\CaseResponder;
use App\CriticalTeam;
use App\Language;
use App\Province;
use App\District;
use App\Municipality;
use App\Ward;
use App\CasePriority;
use App\Title;
use App\CaseRelated;
use App\CasePoi;
use App\Poi;
use App\PoiAssociate;
use App\CaseNote;
use App\CaseFile;
use App\InvestigationOfficer;
use App\services\CaseOwnerService;
use App\services\CaseResponderService;
use App\services\CaseActivityService;
use Redirect;
use Input;
use File;
use Auth;

class CasesController extends Controller {

	protected $case_responders;
	protected $case_owners;
	protected $case_activities;

	public function __construct(CaseResponderService $responder_service, CaseOwnerService $case_owner_service, CaseActivityService $case_activity_service) {
		$this->case_responders = $responder_service;
		$this->case_owners     = $case_owner_service;
		$this->case_activities = $case_activity_service;
	}

	public function index($id) {
		$myCases = CaseOwner::where('user', '=', Auth::user()->id)
			->get();
		$otherCases = CaseReport::where('user', '=', Auth::user()->id)
			->get();
		$caseIds    = array();
		foreach ($myCases as $case) {
			$caseIds[] = $case->case_id;
		}
		foreach ($otherCases as $caseOld) {
			$caseIds[] = $caseOld->id;
		}
		$caseIds     = array_unique($caseIds);
		$userRoleObj = UserRole::find(Auth::user()->role);
		if ($userRoleObj->id == 1) {
			$cases = \DB::table('cases')
				->leftJoin('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_sources', 'cases.source', '=', 'cases_sources.id')
				->leftJoin('cases_types', 'cases.case_type', '=', 'cases_types.id')
				->where('cases_statuses.name', '=', 'Allocated')
				->orWhere('cases_statuses.name', '=', 'Referred')
				->select(
					/*\DB::raw("
                                        cases.id,
                                        cases.created_at,
                                        cases.description,
                                        cases_statuses.name as status,
                                        cases_owners.accept,
                                        cases.case_type,
                                        cases_sources.name as source,
                                        cases_types.name as case_type,
                                        cases_owners.type"
					)*/
					array(
					"cases.id",
          "cases.created_at",
          "cases.description",
          "cases_sources.name as source",
					"cases_types.name as case_type",
					"cases_owners.accept",
					"cases.case_type",
          "cases_statuses.name as status",
					"cases_owners.type")
				)
				->groupBy('cases.id');
		}
		else {
			if ($userRoleObj->name == 'Call Centre Agent') {
				$cases = \DB::table('cases')
					->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
					->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
					->join('cases_sources', 'cases.source', '=', 'cases_sources.id')
					->where('cases_statuses.name', '=', 'Allocated')
					->orWhere('cases_statuses.name', '=', 'Referred')
					->where('cases.user', '=', \Auth::user()->id)
					->select(
						\DB::raw("
                                        cases.id,
                                        cases.created_at,
                                        cases.description,
                                        cases_statuses.name as CaseStatus,
                                        cases.case_type,
                                        cases_owners.accept,
                                        cases_sources.name as source,
                                        cases_owners.type"
						)
					)
					->groupBy('cases.id');
			}
			else {
				$cases = \DB::table('cases')
					->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
					->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
					->join('cases_sources', 'cases.source', '=', 'cases_sources.id')
					->whereIn('cases.id', $caseIds)
					->where('cases_statuses.name', '<>', 'Pending Closure')
					->where('cases_statuses.name', '<>', 'Resolved')
					->select(\DB::raw(
						"
                                    cases.id,
                                    cases.created_at,
                                    cases.description,
                                    cases.case_type,
                                    cases_statuses.name as CaseStatus,
                                    cases_owners.accept,
                                    cases_sources.name as source,
                                    cases_owners.type"
					)
					)
					->groupBy('cases.id');
			}
		}

		return \Datatables::of($cases)
			->addColumn('actions', '<a class="btn btn-xs btn-alt" data-toggle="modal"   href="casetest/{{$id}}" >View</a>
                                    <a class="btn btn-xs btn-alt" data-toggle="modal" href="view-case-poi-associates/{{ $id }}" target="_blank">View POI</a>
                                    ')
			->make(true);
	}

	public function requestCaseClosureList() {
		$userRoleObj = UserRole::find(Auth::user()->role);
		if ($userRoleObj->id == 1) {
			$cases = \DB::table('cases')
				->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->join('cases_sources', 'cases.source', '=', 'cases_sources.id')
				->where('cases_statuses.name', '=', 'Pending Closure')
				->select(
					\DB::raw("

                                    cases.id,
                                    cases.created_at,
                                    cases.description,
                                    cases_sources.name as source,
                                    cases_statuses.name as status"
					)
				);

			return \Datatables::of($cases)
				->addColumn('actions', '<a class="btn btn-xs btn-alt" data-toggle="modal" href="casetest/{{$id}}" >View</a>
                                                   <a class="btn btn-xs btn-alt" data-toggle="modal" href="view-case-poi-associates/{{ $id }}" target="_blank">View POI</a>
                                                    ')
				->make(true);
		}
		else {
			$cases = \DB::table('cases')
				->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->join('cases_sources', 'cases.source', '=', 'cases_sources.id')
				->where('cases_statuses.name', '=', 'Pending Closure')
				->where('user', '=', \Auth::user()->id)
				->select(
					\DB::raw("

                                    cases.id,
                                    cases.created_at,
                                    cases.description,
                                    cases_sources.name as source,
                                    cases_statuses.name as status"
					)
				);

			return \Datatables::of($cases)
				->addColumn('actions', '<a class="btn btn-xs btn-alt" data-toggle="modal" onClick="launchCaseModal({{$id}},1);" data-target=".modalCase">View</a>
                                                   <a class="btn btn-xs btn-alt" data-toggle="modal" href="view-case-poi-associates/{{ $id }}" target="_blank">View POI</a>
                                                    ')
				->make(true);
		}
	}

	public function resolvedCasesList() {
		$userRoleObj = UserRole::find(Auth::user()->role);
		if ($userRoleObj->id == 1) {
			$cases = \DB::table('cases')
				->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->join('cases_sources', 'cases.source', '=', 'cases_sources.id')
				->where('cases_statuses.name', '=', 'Resolved')
				->select(
					/*\DB::raw("

                                    cases.id,
                                    cases.created_at,
                                    cases.description,
                                    cases_sources.name as source,
                                    cases_statuses.name as status"
					)*/
					array("cases.id",
						"cases.created_at",
						"cases.description",
						"cases_sources.name as source",
                                    "cases_statuses.name as status"
									)
				);

			return \Datatables::of($cases)
				->addColumn('actions', '
		<a class="btn btn-xs btn-alt" data-toggle="modal" href="#"  target="_self">Print</a>
		<a class="btn btn-xs btn-alt" data-toggle="modal"  href="casetest/{{$id}}">View</a>
                                        <a class="btn btn-xs btn-alt" data-toggle="modal" href="view-case-poi-associates/{{ $id }}" target="_blank">POI</a>')
				->make(true);
		}
		else {
			$cases = \DB::table('cases')
				->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->join('cases_sources', 'cases.source', '=', 'cases_sources.id')
				->where('cases_statuses.name', '=', 'Resolved')
				->where('user', '=', \Auth::user()->id)
				->select(
					/*\DB::raw("

                                    cases.id,
                                    cases.created_at,
                                    cases.description,
                                    cases_sources.name as source,
                                    cases_statuses.name as status"
					)*/
					array("cases.id",
						"cases.created_at",
						"cases.description",
						"cases_sources.name as source",
                                    "cases_statuses.name as status"
									)
				);

			return \Datatables::of($cases)
				->addColumn('actions', '<a class="btn btn-xs btn-alt" data-toggle="modal" onClick="launchCaseModal({{$id}},1);" data-target=".modalCase">View</a>

                                                   <a class="btn btn-xs btn-alt" data-toggle="modal" href="view-case-poi-associates/{{ $id }}" target="_blank">POI</a>

                                                    ')
				->make(true);
		}
	}

	public function pendingReferralCasesList() {
		$userRoleObj = UserRole::find(Auth::user()->role);
		if ($userRoleObj->id == 1) {
			$cases = \DB::table('cases')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_sources', 'cases.source', '=', 'cases_sources.id')
				->leftJoin('cases_seen', function ($join) {
					$join->on('cases_seen.cid', '=', 'cases.id');
					if (\Auth::check()) $join->on('cases_seen.uid', '=', \DB::raw(\Auth::id()));
				})
				->where('cases_statuses.name', '=', 'Pending')
				->select(
					/*\DB::raw(
						"

                                    cases.id,
                                    cases.created_at,
                                    cases.description,
                                    cases_sources.name as source,
                                    cases_statuses.name as CaseStatus
									, cases_seen.when AS seen"
					)*/
					array("cases.id",
						"cases.created_at",
						"cases.description",
						"cases_sources.name as source",
                                    "cases_statuses.name as status"
									, "cases_seen.when AS seen")
				);
		}
		else {
			$cases = \DB::table('cases')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_sources', 'cases.source', '=', 'cases_sources.id')
				->leftJoin('cases_seen', function ($join) {
					$join->on('cases_seen.cid', '=', 'cases.id');
					if (\Auth::check()) $join->on('cases_seen.uid', '=', \DB::raw(\Auth::id()));
				})
				->where('cases_statuses.name', '=', 'Pending')
				->where('cases.agent', '=', \Auth::user()->id)
				->select(
					/*\DB::raw(
						"

                                    cases.id,
                                    cases.created_at,
                                    cases.description,
                                    cases_sources.name as source,
                                    cases_statuses.name as CaseStatus
									, cases_seen.when AS seen"
					)*/
					array("cases.id",
						"cases.created_at",
						"cases.description",
						"cases_sources.name as source",
                                    "cases_statuses.name as status"
									, "cases_seen.when AS seen")
				);
		}
		/*
    select 
    cases.id,
    cases.created_at,
    cases.description,
    cases_sources.name as source,
    cases_statuses.name as CaseStatus
    , cases_seen.when AS seen
    from `cases` inner join `cases_statuses` on `cases`.`status` = `cases_statuses`.`id` inner join `cases_sources` on `cases`.`source` = `cases_sources`.`id`
    left join cases_seen on cases.id = cases_seen.cid and cases_seen.uid = 10
    
    */

//die($cases->toSql());
		return \Datatables::of($cases)
			->addColumn('seen', '<img class="btnSeen" id="btnSeen_{{ $id }}" src="{{ asset(\'images/bell_\'.($seen ? \'seen\' : \'unseen\').\'.png\') }}" style="text-align: right">')
			->addColumn('actions', '
	    <a class="btn btn-xs btn-alt" data-toggle="modal" href="#"  target="_self">Print</a>
	    <a class="btn btn-xs btn-alt" data-toggle="modal" href="casetest/{{ $id }}"  target="_self">View</a>

                                                   <a class="btn btn-xs btn-alt" data-toggle="modal" href="view-case-poi-associates/{{ $id }}" target="_blank">POI</a>
                                                    ')
			->make(true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function acceptCase($id) {
	$txtDebug     = __CLASS__ . "" . __FUNCTION__ . "(\$id) \$id - {$id}";
		$caseOwnerObj = CaseOwner::where("case_id", '=', $id)
			->whereAnd("user", '=', Auth::user()->id)
			->first();
		$numberCases = CaseReport::where('user', '=', Auth::user()->id)->get();
		$txtDebug .= "\n  \$caseOwnerObj - " . print_r($caseOwnerObj, 1);
		if (sizeof($caseOwnerObj) > 0) {
			$caseOwnerObj->accept = 1;
			$caseOwnerObj->save();
			$caseActivity              = New CaseActivity();
			$caseActivity->case_id     = $id;
			$caseActivity->user        = \Auth::user()->id;
			$caseActivity->addressbook = 0;
			$caseActivity->note        = "Case Accepted by " . \Auth::user()->name . ' ' . \Auth::user()->surname;
			$caseActivity->save();
			$case = CaseReport::find($id);
			if ($case->status == "Pending") {
				$case->status      = "Actioned";
				$case->accepted_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
				$case->save();
			}
			$caseOwners = CaseOwner::where("case_id", '=', $id)
				->where("user", "<>", \Auth::user()->id)
				->get();
			$txtDebug .= "\n  \$caseOwners - " . print_r($caseOwners->toArray(), 1);
			foreach ($caseOwners as $owner) {
				if ($owner->addressbook == 1) {
					$user = AddressBook::find($owner->user);
				}
				else {
					$user = User::find($owner->user);
				}
				$txtDebug .= "\n  \$user - " . print_r($user->toArray(), 1);
				$data = array(
					'name'       => $user->name,
					'caseID'     => $id,
					'acceptedBy' => \Auth::user()->name . ' ' . \Auth::user()->surname,
				);
				\Mail::send('emails.acceptCase', $data, function ($message) use ($user) {
					$message->from('info@siyaleader.net', 'Siyaleader');
					$message->to($user->email)->subject("Siyaleader Notification - New Case Accepted: ");
				});
			}
		}
		//die("<pre>{$txtDebug}</pre>");
		$data = array(
			'name'       => "AIMS",
			'caseID'     => $id,
			'acceptedBy' => \Auth::user()->name . ' ' . \Auth::user()->surname,
		);
		\Mail::send('emails.acceptCase', $data, function ($message) {
			$message->from('info@siyaleader.net', 'AIMS');
			$message->to("richard@siyaleader.net")->subject("AIMS Notification - New Case Accepted: ");
		});

		return "ok";
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function captureCase(Request $request) {
		$repId       = 0;
		$addressbook = 0;
		if (!$request['repID']) {
			$user               = new User();
			$user->role         = 5;
			$user->title        = 1;
			$user->language     = 1;
			$user->gender       = 1;
			$user->name         = $request['name'];
			$user->surname      = $request['surname'];
			$user->cellphone    = $request['mobile'];
			$user->email        = $request['mobile'] . "siyaleader.net";
			$user->active       = 2;
			$user->province     = $request['province'];
			$user->district     = $request['district'];
			$user->municipality = $request['municipality'];
			$user->ward         = $request['ward'];
			$user->position     = 3;
			$password           = rand(1000, 99999);
			$user->password     = \Hash::make($password);
			$user->area         = $request['area'];
			$user->api_key      = uniqid();
			$user->created_by   = \Auth::user()->id;
			$user->save();
			$repId = $user->id;
		}
		else {
			$repId = $request['repID'];
		}
		$description = preg_replace("/[^ \w]+/", "", $request['description']);
		$gps                               = explode(",", $request['GPS']);
		$case                              = new CaseReport();
		$case->description                 = $description;
		$case->user                        = "";
		$case->status                      = 1;
		$case->gps_lat                     = $gps[0];
		$case->gps_lng                     = $gps[1];
		$case->addressbook                 = 0;
		$case->reporter                    = $repId;
		$case->source                      = 3;
		$case->active                      = 1;
		$case->house_holder_id             = 1;
		$case->case_type                   = $request['case_type'];
		$case->case_sub_type               = $request['case_sub_type'];
		$case->saps_case_number            = "scscs";
		$case->client_reference_number     = "test";
		$case->street_number               = $request['street_number'];
		$case->route                       = $request['route'];
		$case->locality                    = $request['locality'];
		$case->administrative_area_level_1 = $request['administrative_area_level_1'];
		$case->postal_code                 = $request['postal_code'];
		$case->country                     = $request['country'];
		$case->save();

		return redirect()->back();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request $request
	 * @return Response
	 */
	public function escalate(Request $request) {
		if ($request['addresses'] != NULL) {
			$addresses   = explode(',', $request['addresses']);
			$caseOwners  = CaseOwner::where('case_id', '=', $request['caseID'])->get();
			$typeMessage = 'allocated';
			$typeStatus  = 'Allocated';
			foreach ($addresses as $address) {
				$user = User::where('id', '=', $address)->first();
				$data = array(
					'name'     => $user->name,
					'caseID'   => $request['caseID'],
					'content'  => $request['message'],
					'executor' => \Auth::user()->name . ' ' . \Auth::user()->surname,
				);
				\Mail::send('emails.caseAllocated', $data, function ($message) use ($user) {
					$message->from('info@siyaleader.net', 'Siyaleader');
					$message->to($user->email)->subject("Siyaleader Notification - Case Allocated: ");
				});
			}
			foreach ($addresses as $address) {
				$user = User::where('id', '=', $address)->first();
				if (sizeof($user) <= 0) {
					$user = User::where('id', '=', $address)->first();
				}
				$name        = (sizeof($user) <= 0) ? $user->first_name : $user->name;
				$surname     = (sizeof($user) <= 0) ? $user->surname : $user->surname;
				$to          = (sizeof($user) <= 0) ? $user->id : $user->id;
				$type        = (sizeof($user) <= 0) ? 1 : 0;
				$addressbook = (sizeof($user) <= 0) ? 1 : 0;
				$cellphone   = (sizeof($user) <= 0) ? $user->surname : $user->cellphone;
				$data = array(
					'name'       => $name,
					'caseID'     => $request['caseID'],
					'content'    => $request['message'],
					'typeStatus' => $request['typeStatus']
				);
				$details         = CaseReport::where('id', '=', $request['caseID'])->first();
				$details->status = 7;
				$details->save();
				$caseActivity          = New CaseActivity();
				$caseActivity->case_id = $request['caseID'];
				$caseActivity->user    = $to;
				$caseActivity->note = "Case " . $typeMessage . " to " . $name . " " . $surname . " by " . \Auth::user()->name . ' ' . \Auth::user()->surname;
				$caseActivity->save();
				$caseEscalationObj               = New CaseEscalator();
				$caseEscalationObj->case_id      = $request['caseID'];
				$caseEscalationObj->from         = \Auth::user()->id;
				$caseEscalationObj->to           = $to;
				$caseEscalationObj->type         = $type;
				$caseEscalationObj->description  = $details->description;
				$caseEscalationObj->category     = $details->case_type;
				$caseEscalationObj->sub_category = $details->case_sub_type;
				$caseEscalationObj->investigation_officer = $details->investigation_officer;
				$caseEscalationObj->investigation_cell    = $details->investigation_cell;
				$caseEscalationObj->investigation_email   = $details->investigation_email;
				$caseEscalationObj->status                = 7;
				$caseEscalationObj->start    = date("Y-m-d");
				$caseEscalationObj->color    = "#4caf50";
				$caseEscalationObj->end      = $request['due_date'];
				$caseEscalationObj->title    = "Case ID: " . $request['caseID'];
				$caseEscalationObj->due_date = $request['due_date'] . " " . $request['due_time'];
				$caseEscalationObj->message  = $request['message'];
				$caseEscalationObj->save();
				$caseOwnerObj          = New CaseOwner();
				$caseOwnerObj->case_id = $request['caseID'];
//            $caseOwnerObj->user = $to;
				$caseOwnerObj->type = 4;
//            $caseOwnerObj->addressbook = $addressbook;
				$caseOwnerObj->save();
				if ($typeStatus == 'Allocated') {
					$objCase               = CaseReport::find($request['caseID']);
					$objCaseStatus         = CaseStatus::where('name', '=', $typeStatus)->first();
					$objCase->allocated_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
					$objCase->status       = $objCaseStatus->id;
					$objCase->save();
				}
				else {
					$objCase              = CaseReport::find($request['caseID']);
					$objCaseStatus        = CaseStatus::where('name', '=', $typeStatus)->first();
					$objCase->referred_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
					$objCase->status      = $objCaseStatus->id;
					$objCase->save();
				}
//                \Mail::send('emails.caseEscalated', $data, function ($message) use ($typeStatus) {
//                    $message->from('info@siyaleader.net', 'Siyaleader');
//                    $message->to($address)->subject("Siyaleader Notification - Case $typeStatus: ");
//
//                });
//
//                \Mail::send('emails.caseEscalatedSMS', $data, function ($message) use ($cellphone) {
//                    $message->from('info@siyaleader.net', 'Siyaleader');
//                    $message->to('cooluma@siyaleader.net')->subject("REFER: $cellphone");
//
//                });
				$caseObj = \DB::table('cases')
					->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
					->where('cases.id', '=', $request['caseID'])
					->select(\DB::raw("
                                    cases.id,
                                    cases.case_sub_type,
                                    cases.case_type,
                                    cases.house_holder_id,
                                    cases_statuses.name as status
                                   "
					))
					->first();
				if ($caseObj->status == 'Allocated') {
					$case = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->join('cases_types', 'cases.case_type', '=', 'cases_types.id')
						->join('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
						->where('cases.id', '=', $request['caseID'])
						->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                
                                    cases_types.name as  case_type,
                                    cases_sub_types.name  as  case_sub_type ,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.client_reference_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases_statuses.name as status,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell
                                   "
						)
						)
						->get();
				}
			}
		}
		else if ($request['addresses1'] != NULL) {
			$addresses   = explode(',', $request['addresses1']);
			$caseOwners  = CaseOwner::where('case_id', '=', $request['caseID'])->get();
			$typeMessage = 'Referred';
			$typeStatus  = 'Referred';
			foreach ($addresses as $address) {
				$user = User::where('id', '=', $address)->first();
				$data = array(
					'name'     => $user->name,
					'caseID'   => $request['caseID'],
					'content'  => $request['message'],
					'executor' => \Auth::user()->name . ' ' . \Auth::user()->surname,
				);
				\Mail::send('emails.caseEscalation', $data, function ($message) use ($user) {
					$message->from('info@siyaleader.net', 'Siyaleader');
					$message->to($user->email)->subject("Siyaleader Notification - Case Referred: ");
				});
			}
			foreach ($addresses as $address) {
				$user = User::where('id', '=', $address)->first();
				if (sizeof($user) <= 0) {
					$user = User::where('id', '=', $address)->first();
				}
				$name        = (sizeof($user) <= 0) ? $user->first_name : $user->name;
				$surname     = (sizeof($user) <= 0) ? $user->surname : $user->surname;
				$to          = (sizeof($user) <= 0) ? $user->id : $user->id;
				$type        = (sizeof($user) <= 0) ? 1 : 0;
				$addressbook = (sizeof($user) <= 0) ? 1 : 0;
				$cellphone   = (sizeof($user) <= 0) ? $user->surname : $user->cellphone;
				$data = array(
					'name'       => $name,
					'caseID'     => $request['caseID'],
					'content'    => $request['message'],
					'typeStatus' => $request['typeStatus']
				);
				$details         = CaseReport::where('id', '=', $request['caseID'])->first();
				$details->status = 7;
				$details->save();
				$caseActivity          = New CaseActivity();
				$caseActivity->case_id = $request['caseID'];
				$caseActivity->user    = $to;
				$caseActivity->note = "Case " . $typeMessage . " to " . $name . " " . $surname . " by " . \Auth::user()->name . ' ' . \Auth::user()->surname;
				$caseActivity->save();
				$caseEscalationObj               = New CaseEscalator();
				$caseEscalationObj->case_id      = $request['caseID'];
				$caseEscalationObj->from         = \Auth::user()->id;
				$caseEscalationObj->to           = $to;
				$caseEscalationObj->type         = $type;
				$caseEscalationObj->description  = $details->description;
				$caseEscalationObj->category     = $details->case_type;
				$caseEscalationObj->sub_category = $details->case_sub_type;
				$caseEscalationObj->investigation_officer = $details->investigation_officer;
				$caseEscalationObj->investigation_cell    = $details->investigation_cell;
				$caseEscalationObj->investigation_email   = $details->investigation_email;
				$caseEscalationObj->status                = 7;
				$caseEscalationObj->start    = date("Y-m-d");
				$caseEscalationObj->color    = "#4caf50";
				$caseEscalationObj->end      = $request['due_date'];
				$caseEscalationObj->title    = "Case ID: " . $request['caseID'];
				$caseEscalationObj->due_date = $request['due_date'] . " " . $request['due_time'];
				$caseEscalationObj->message  = $request['message'];
				$caseEscalationObj->save();
				$caseOwnerObj          = New CaseOwner();
				$caseOwnerObj->case_id = $request['caseID'];
//              $caseOwnerObj->user = $to;
				$caseOwnerObj->type = 4;
//              $caseOwnerObj->addressbook = $addressbook;
				$caseOwnerObj->save();
				if ($typeStatus == 'Allocated') {
					$objCase               = CaseReport::find($request['caseID']);
					$objCaseStatus         = CaseStatus::where('name', '=', $typeStatus)->first();
					$objCase->allocated_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
					$objCase->status       = $objCaseStatus->id;
					$objCase->save();
				}
				else {
					$objCase              = CaseReport::find($request['caseID']);
					$objCaseStatus        = CaseStatus::where('name', '=', $typeStatus)->first();
					$objCase->referred_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
					$objCase->status      = $objCaseStatus->id;
					$objCase->save();
				}
//
//                \Mail::send('emails.caseEscalated', $data, function ($message) use ($typeStatus) {
//                    $message->from('info@siyaleader.net', 'Siyaleader');
//                    $message->to($address)->subject("Siyaleader Notification - Case $typeStatus: ");
//
//                });
//
//                \Mail::send('emails.caseEscalatedSMS', $data, function ($message) use ($cellphone) {
//                    $message->from('info@siyaleader.net', 'Siyaleader');
//                    $message->to('cooluma@siyaleader.net')->subject("REFER: $cellphone");
//
//                });
				$caseObj = \DB::table('cases')
					->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
					->where('cases.id', '=', $request['caseID'])
					->select(\DB::raw("
                                    cases.id,
                                    cases.case_sub_type,
                                    cases.case_type,
                                    cases.house_holder_id,
                                    cases_statuses.name as status
                                   "
					))
					->first();
				if ($caseObj->status == 'Allocated') {
					$case = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->join('cases_types', 'cases.case_type', '=', 'cases_types.id')
						->join('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
						->where('cases.id', '=', $request['caseID'])
						->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                
                                    cases_types.name as  case_type,
                                    cases_sub_types.name  as  case_sub_type ,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.client_reference_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases_statuses.name as status,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell
                                   "
						)
						)
						->get();
				}
			}
		}
//        foreach ($caseOwners as $caseOwner) {
//
//            $user = User::find($caseOwner->user);
//            $data = array(
//
//                'name' => $user->name,
//                'caseID' => $request['caseID'],
//                'content' => $request['message'],
//                'executor' => \Auth::user()->name . ' ' . \Auth::user()->surname,
//            );
//
//
//            \Mail::send('emails.caseEscalation', $data, function ($message) use ($user) {
//                $message->from('info@siyaleader.net', 'Siyaleader');
//                $message->to($user->email)->subject("Siyaleader Notification - Case Referred: ");
//
//            });
//
//        }
		\Session::flash('success', 'A Case has been ' . "" . "$typeStatus" . "" . ' successfully');

		return Redirect::to('casetest/' . $request['caseID']);
	}

	public function mobilecalendarListPerUser() {
		$api_key = \Input::get('api_key');
		$user = User::where('api_key', '=', $api_key)->first();
		//  $events    = CaseEscalator::select('id','title','start','end','color', 'description' 'department' '' 'investigation_note'  'message' )->where('to','=',$user->id)->get();
		$events = \DB::table('cases_escalations')
			->join('categories', 'cases_escalations.category', '=', 'categories.id')
			->join('cases_statuses', 'cases_escalations.status', '=', 'cases_statuses.id')
			->join('sub_categories', 'cases_escalations.sub_category', '=', 'sub_categories.id')
			->where('to', '=', $user->id)
			->select(\DB::raw("
                                    cases_escalations.id,
                                    cases_escalations.title,
                                    cases_escalations.start,
                                    cases_escalations.end,
									cases_escalations.color,
									cases_escalations.description,
									cases_escalations.message,
									cases_escalations.investigation_note,

									cases_statuses.name  as status,

									categories.name as category,
									sub_categories.name as sub_category
									")
			)->get();
		echo json_encode($events);
	}

	public function addCasePoi(Request $request) {
		$contacts = explode(',', $request['pois']);
		foreach ($contacts as $contact) {
			$poi = Poi::where('email', '=', $contact)->first();
			$casepoi          = New CasePoi();
			$casepoi->case_id = $request['caseID'];
			$casepoi->poi_id  = $poi->id;
			$casepoi->save();
		}

		return response()->json(['status' => 'ok']);
	}

	public function addAssociatePoi(Request $request) {
		$checking_one = PoiAssociate::where("poi_id", $request['poiID'])->where("associate_id", $request['poi_associate'])->first();
		$checking_two = PoiAssociate::where("poi_id", $request['poi_associate'])->where("associate_id", $request['poiID'])->first();
		if (sizeof($checking_one) == 0 && sizeof($checking_two) == 0) {
			if ($request['poi_associate'] != "") {
				if ($request['poi_associate'] != $request['poiID']) {
					$assocatepoi                   = New PoiAssociate();
					$assocatepoi->associate_id     = $request['poi_associate'];
					$assocatepoi->poi_id           = $request['poiID'];
					$assocatepoi->association_type = $request['poi_association_type'];
					$assocatepoi->created_by       = \Auth::user()->id;
					$assocatepoi->save();

					return response()->json(['status' => 'ok']);
				}
			}
		}
	}

	public function addCaseAssociatePoi(Request $request) {
		$checking_one = CasePoi::where("poi_id", $request['poi_associate'])->where("case_id", $request['caseID'])->first();
		if (sizeof($checking_one) == 0) {
			if ($request['poi_associate'] != "") {
				if ($request['poi_associate'] != $request['poiID']) {
					$assocatepoi             = New CasePoi();
					$assocatepoi->case_id    = $request['caseID'];
					$assocatepoi->poi_id     = $request['poi_associate'];
					$assocatepoi->created_by = \Auth::user()->id;
					$assocatepoi->save();

					return response()->json(['status' => 'ok']);
				}
			}
		}
	}

	public function addCaseAssociatePoiCase(Request $request) {
		$checking_one = CasePoi::where("case_id", $request['add_case_search'])->where("poi_id", $request['poiID'])->first();
		if (sizeof($checking_one) == 0) {
			if ($request['add_case_search'] != "") {
				$assocatepoi             = New CasePoi();
				$assocatepoi->case_id    = $request['add_case_search'];
				$assocatepoi->poi_id     = $request['poiID'];
				$assocatepoi->created_by = \Auth::user()->id;
				$assocatepoi->save();

				return response()->json(['status' => 'ok']);
			}
		}
	}

	public function list_case_poi($id) {
		$casePois = \DB::table('cases_poi')->where('case_id', '=', $id)
			->join('poi', 'poi.id', '=', 'cases_poi.poi_id')
			->select(array('poi.id', 'poi.name', 'poi.surname'));

		return \Datatables::of($casePois)->addColumn('actions', '<a target="_blank" class="btn btn-xs btn-alt" href="{{ url(\'edit-poi-user\',$id) }}" >View / Edit</a>
                                                   <a target="_blank" class="btn btn-xs btn-alt" href="{{ url(\'view-poi-associates\',$id) }}" >View / Add Associates</a>

                                        '
		)->make(true);
	}

	public function allocate(Request $request) {
		$responders     = $request['responders'];
		$department     = $request['department'];
		$category       = $request['category'];
		$subCategory    = $request['sub_category'];
		$subSubCategory = $request['sub_sub_category'];
		foreach ($responders as $responder) {
			$caseOwner          = new CaseOwner();
			$caseOwner->case_id = $request['caseID'];
			$caseOwner->user    = $responder;
			$caseOwner->type    = 1;
			$caseOwner->save();
			$user = User::find($responder);
			$caseActivity              = New CaseActivity();
			$caseActivity->case_id     = $request['caseID'];
			$caseActivity->user        = $user->id;
			$caseActivity->addressbook = 0;
			$caseActivity->note        = "Case Referred to " . $user->name . " " . $user->surname . " by " . \Auth::user()->name . ' ' . \Auth::user()->surname;
			$caseActivity->save();
			$email     = $user->email;
			$cellphone = $user->cellphone;
			$case      = CaseReport::find($request['caseID']);
			$data = array(
				'name'    => $user->name,
				'caseID'  => $request['caseID'],
				'content' => $case->description
			);
			\Mail::send('emails.caseEscalated', $data, function ($message) use ($email) {
				$message->from('info@siyaleader.net', 'Siyaleader');
				$message->to($email)->subject("Siyaleader Notification - Case Referred: ");
			});
			\Mail::send('emails.caseEscalatedSMS', $data, function ($message) use ($cellphone) {
				$message->from('info@siyaleader.net', 'Siyaleader');
				$message->to('cooluma@siyaleader.net')->subject("REFER: $cellphone");
			});
		}
		$objDept   = Department::where('slug', '=', $department)->first();
		$objCat    = Category::where('slug', '=', $category)->first();
		$objSubCat = SubCategory::where('slug', '=', $subCategory)->first();
		if (strlen($subSubCategory) > 1) {
			$objSubSubCat   = SubSubCategory::where('slug', '=', $subSubCategory)->first();
			$objSubSubCatId = $objSubSubCat->id;
		}
		else {
			$objSubSubCatId = 0;
		}
		$objCase                   = CaseReport::find($request['caseID']);
		$objCaseStatus             = CaseStatus::where('name', '=', 'Referred')->first();
		$objCase->status           = $objCaseStatus->id;
		$objCase->department       = $objDept->id;
		$objCase->category         = $objCat->id;
		$objCase->sub_category     = $objSubCat->id;
		$objCase->sub_sub_category = $objSubSubCatId;
		$objCase->referred_at      = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
		$objCase->updated_by       = \Auth::user()->id;
		$objCase->save();

		return 'ok';
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function closeCase($id) {
		$txtDebug          = __CLASS__ . "->" . __FUNCTION__ . "(\$id) \$id - {$id}";
		$case              = CaseReport::find($id);
		$case->status      = 3;
		$case->resolved_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
		$case->save();
		$caseActivity              = New CaseActivity();
		$caseActivity->case_id     = $id;
		$caseActivity->user        = \Auth::user()->id;
		$caseActivity->addressbook = 0;
		$caseActivity->note        = \Auth::user()->name . ' ' . \Auth::user()->surname . " closed case";
		$caseActivity->save();
		$data = array(
			'name'     => \Auth::user()->name,
			'caseID'   => $id,
			'content'  => $case->description,
			'executor' => \Auth::user()->name . ' ' . \Auth::user()->surname,
		);
		$user = User::find($case->reporter);
		if (sizeof($user) <= 0) {
			$userAddressbook = addressbook::where('user', '=', $case->reporter)->first();
		}
		$txtDebug .= "\n  \$userAddressbook - " . ($userAddressbook ? print_r($userAddressbook->toArray(), 1) : "");
		$txtDebug .= "\n  \$user - " . ($user ? print_r($user->toArray(), 1) : "");
		$txtDebug .= "\n  \$case - " . print_r($case->toArray(), 1);
		$txtDebug .= "\n  \$data - " . print_r($data, 1);
die("<pre>{$txtDebug}</pre>");
		$email = (sizeof($user) <= 0) ? $userAddressbook->email : $user->email;
die("<pre>{$txtDebug}</pre>");
		\Mail::send('emails.caseClosed', $data, function ($message) use ($email) {
			$message->from('info@siyaleader.net', 'Siyaleader');
			$message->to($email)->subject("Siyaleader Notification - Case Closed: ");
		});

		return Response::success("ok");
	}

	public function requestCaseClosure(Request $request) {
		$case         = CaseReport::find($request['caseID']);
		$case->status = 2;
		$case->save();
		$caseActivity              = New CaseActivity();
		$caseActivity->case_id     = $request['caseID'];
		$caseActivity->user        = \Auth::user()->id;
		$caseActivity->addressbook = 0;
		$caseActivity->note        = \Auth::user()->name . ' ' . \Auth::user()->surname . " requested case closure";
		$caseActivity->save();
		$caseAdministrators = User::where('role', '=', 1)
			->orWhere('role', '=', 3)
			->get();
		foreach ($caseAdministrators as $caseAdmin) {
			$data = array(
				'name'      => $caseAdmin->name,
				'caseID'    => $case->id,
				'content'   => $case->description,
				'note'      => $request['caseNote'],
				'requestor' => \Auth::user()->name . ' ' . \Auth::user()->surname,
			);
			\Mail::send('emails.requestCaseClosure', $data, function ($message) use ($caseAdmin) {
				$message->from('info@siyaleader.net', 'Siyaleader');
				$message->to($caseAdmin->email)->subject("Siyaleader Notification - Request for Case Closure: ");
			});
		}

		return "Case Closed";
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 *
	 *
	 */
	public function viewcase($id) {
		if (\Auth::check()) {
			$attrCS = array('cid' => $id, 'uid' => \Auth::id());
			if (\App\CasesSeen::where($attrCS)->count() == 0) \App\CasesSeen::create($attrCS);
		}
		$destinationFolder = 'files/case_' . $id;
		$case              = null;
		if (!\File::exists($destinationFolder)) {
			$createDir = \File::makeDirectory($destinationFolder, 0777, true);
		}
		$caseObj = \DB::table('cases')
			->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
			->where('cases.id', '=', $id)
			->select(\DB::raw("
                                    cases.id,
                                    cases.case_sub_type,
                                    cases.case_type,
                                    cases.house_holder_id,
                                    cases_statuses.name as status
																		, cases.user
																		,cases.investigation_officer
                                   "
			))
			->first();
//e("<pre>".print_r($caseObj,1)."</pre>");
		if ($caseObj->status == 'Pending') {
			$case = \DB::table('cases')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_types', 'cases.case_type', '=', 'cases_types.id')
				->leftJoin('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
				->leftJoin('departments','departments.id','=','cases_types.department')
				->leftJoin('companies','companies.id','=','departments.company')
				->where('cases.id', '=', $id)
				->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                cases.gps_lat,
									cases.gps_lng, occured_at, cases.address,
									departments.company AS id_company,
									cases.department AS id_department,
									cases.case_type AS id_type,
									cases.case_sub_type AS id_sub_type,
                                    cases_types.name as  case_type,
                                    cases_sub_types.name  as  case_sub_type ,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.client_reference_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases_statuses.name as status,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell
                                    , (SELECT `name` FROM `companies` WHERE `companies`.`id`=`departments`.`company`) AS company
                                    , (SELECT `name` FROM `departments` WHERE `departments`.`id`=`cases_types`.`department`) AS department
                                   "
				)
				)
				->get();
		}
		elseif ($caseObj->status == 'Pending Closure') {
			$case = \DB::table('cases')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_types', 'cases.case_type', '=', 'cases_types.id')
				->leftJoin('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
				->leftJoin('departments','departments.id','=','cases_types.department')
				->leftJoin('companies','companies.id','=','departments.company')
				->where('cases.id', '=', $id)
				->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                cases.gps_lat,
									cases.gps_lng, occured_at, cases.address,
									departments.company AS id_company,
									cases.department AS id_department,
									cases.case_type AS id_type,
									cases.case_sub_type AS id_sub_type,
                                    cases_types.name as  case_type,
                                    cases_sub_types.name  as  case_sub_type ,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.client_reference_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases_statuses.name as status,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell
                                    , (SELECT `name` FROM `companies` WHERE `companies`.`id`=`departments`.`company`) AS company
                                    , (SELECT `name` FROM `departments` WHERE `departments`.`id`=`cases_types`.`department`) AS department

                                   "
				)
				)
				->get();
		}
		elseif ($caseObj->status == 'Resolved') {
			$case = \DB::table('cases')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_types', 'cases.case_type', '=', 'cases_types.id')
				->leftJoin('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
				->leftJoin('departments','departments.id','=','cases_types.department')
				->leftJoin('companies','companies.id','=','departments.company')
				->where('cases.id', '=', $id)
				->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                cases.gps_lat,
									cases.gps_lng, occured_at, cases.address,
									departments.company AS id_company,
									cases.department AS id_department,
									cases.case_type AS id_type,
									cases.case_sub_type AS id_sub_type,
                                    cases_types.name as  case_type,
                                    cases_sub_types.name  as  case_sub_type ,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.client_reference_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases_statuses.name as status,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell
                                    , (SELECT `name` FROM `companies` WHERE `companies`.`id`=`departments`.`company`) AS company
                                    , (SELECT `name` FROM `departments` WHERE `departments`.`id`=`cases_types`.`department`) AS department
                                   "
				)
				)
				->get();
		}
		elseif ($caseObj->status == 'Allocated') {
			$case = \DB::table('cases')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_types', 'cases.case_type', '=', 'cases_types.id')
				->leftJoin('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
				->leftJoin('departments','departments.id','=','cases_types.department')
				->leftJoin('companies','companies.id','=','departments.company')
				->where('cases.id', '=', $id)
				->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                cases.gps_lat,
									cases.gps_lng, occured_at, cases.address,
									departments.company AS id_company,
									cases.department AS id_department,
									cases.case_type AS id_type,
									cases.case_sub_type AS id_sub_type,
                                    cases_types.name as  case_type,
                                    cases_sub_types.name  as  case_sub_type ,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.client_reference_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases_statuses.name as status,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell
                                    , (SELECT `name` FROM `companies` WHERE `companies`.`id`=`departments`.`company`) AS company
                                    , (SELECT `name` FROM `departments` WHERE `departments`.`id`=`cases_types`.`department`) AS department
                                   "
				)
				)
				->get();
		}
		elseif ($caseObj->status == 'Referred') {
			$case = \DB::table('cases')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_types', 'cases.case_type', '=', 'cases_types.id')
				->leftJoin('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
				->leftJoin('departments','departments.id','=','cases_types.department')
				->leftJoin('companies','companies.id','=','departments.company')
				->where('cases.id', '=', $id)
				->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                cases.gps_lat,
									cases.gps_lng, occured_at, cases.address,
									departments.company AS id_company,
									cases.department AS id_department,
									cases.case_type AS id_type,
									cases.case_sub_type AS id_sub_type,
                                    cases_types.name as  case_type,
                                    cases_sub_types.name  as  case_sub_type ,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.client_reference_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases_statuses.name as status,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell
                                    , (SELECT `name` FROM `companies` WHERE `companies`.`id`=`departments`.`company`) AS company
                                    , (SELECT `name` FROM `departments` WHERE `departments`.`id`=`cases_types`.`department`) AS department
												
                                   "
				)
				)
				->get();
		}
		elseif ($caseObj->status == 'Referred') {
			$case = \DB::table('cases')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_types', 'cases.case_type', '=', 'cases_types.id')
				->leftJoin('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
				->leftJoin('departments','departments.id','=','cases_types.department')
				->leftJoin('companies','companies.id','=','departments.company')
				->where('cases.id', '=', $id)
				->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
									cases.gps_lat,
									cases.gps_lng, occured_at, cases.address,
									departments.company AS id_company,
									cases.department AS id_department,
									cases.case_type AS id_type,
									cases.case_sub_type AS id_sub_type,
                                    cases_types.name as  case_type,
                                    cases_sub_types.name  as  case_sub_type ,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.client_reference_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases_statuses.name as status,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell
                                    , (SELECT `name` FROM `companies` WHERE `companies`.`id`=`departments`.`company`) AS company
                                    , (SELECT `name` FROM `departments` WHERE `departments`.`id`=`cases_types`.`department`) AS department
                                   "
				)
				)
				->get();
		}
		$relatedCases = \DB::table('related_cases')
			->join('cases', 'related_cases.child', '=', 'cases.id')
			->where('related_cases.parent', '=', $id)
			->select(
				array(
					'cases.id as id',
					'cases.description as description',
					'related_cases.created_at as created_at'
				)
			);

		$capturer = array('name'=>"", 'cellphone'=>"", 'email'=>"");
		if ($caseObj->user && \App\User::find($caseObj->user)) $capturer = \App\User::find($caseObj->user);
		$investigator = array('name'=>"", 'cellphone'=>"", 'email'=>"");
		if ($caseObj->investigation_officer && \App\InvestigationOfficer::find($caseObj->investigation_officer)) $investigator = \App\InvestigationOfficer::find($caseObj->investigation_officer);
		$reporter = array('name'=>"", 'cellphone'=>"", 'email'=>"");
		if (count($case) > 0 && $case[0]->reporteID && \App\Reporter::find($case[0]->reporteID)) $reporter = \App\Reporter::find($case[0]->reporteID);
		$txtDebug = "\$caseObj - ".print_r($caseObj,1);
		$txtDebug .= "\n  \$case - ".print_r($case,1);
		$txtDebug .= "\n  \$capturer - ".print_r($capturer,1);
		$txtDebug .= "\n  \$reporter - ".print_r($reporter,1);
		$txtDebug .= "\n  \$investigator - ".print_r($investigator,1);
		//die("<pre>{$txtDebug}</pre>");
		$co = new \App\Company();
		$extra = array('id_company'=>0,'id_department'=>0, 'id_type'=>0, 'id_subtype'=>0);
		if ($case[0]->department) {
			$co = \App\Company::find($case[0]->company);
			//$co = \App\Company::find("name",$case[0]->department)->first();
			
		}
		
$txtDebug .= "\n  \$co - ".print_r($co,1);
$txtDebug .= "\n  \$extra - ".print_r($extra,1);
		//die("<pre>{$txtDebug}</pre>");

        $checkPosition    = User::where('id',Auth::user()->id)->first();
        $positionId       =$checkPosition->position;

		return view('cases.test')->with(compact('case', 'reporter', 'capturer', 'investigator', 'co','positionId'));
		$cases    = CaseReport::where('id', $id)->first();
		$accepted = $cases->accepted;

		return view('cases.test')->with(compact('case', 'accepted'));
	}

	public function edit($id) {
		$destinationFolder = 'files/case_' . $id;
		if (!\File::exists($destinationFolder)) {
			$createDir = \File::makeDirectory($destinationFolder, 0777, true);
		}
		$caseObj = \DB::table('cases')
			->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
			->where('cases.id', '=', $id)
			->select(\DB::raw("
                                    cases.id,
                                    cases.case_sub_type,
                                    cases.case_type,
                                    cases.house_holder_id,
                                    cases_statuses.name as status
                                   "
			))
			->first();
		if ($caseObj->status == 'Pending' && $caseObj->house_holder_id == 0) {
			$case = \DB::table('cases')
				->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->where('cases.id', '=', $id)
				->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.client_reference_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases_statuses.name as status,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell
                                   "
				)
				)
				->get();
		}
		if ($caseObj->status == 'Pending' && $caseObj->house_holder_id > 0) {
			$case = \DB::table('cases')
				->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->join('cases_types', 'cases.case_type', '=', 'cases_types.id')
				->join('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
				->where('cases.id', '=', $id)
				->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases.client_reference_number,
                                    cases_statuses.name as status,
                                    cases_types.name as case_type,
                                    cases_sub_types.name as case_sub_type,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `client_reference_number` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as reference_number
                                   "
				)
				)
				->get();
		}
		if ($caseObj->status != 'Pending') {
			if ($caseObj->case_sub_type > 0) {
				$case = \DB::table('cases')
					->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
					->join('cases_types', 'cases.case_type', '=', 'cases_types.id')
					->join('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
					->where('cases.id', '=', $id)
					->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                    cases.reporter as reporteID,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.house_holder_id,
                                    cases.saps_case_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases.client_reference_number,
                                    cases_statuses.name as status,
                                    cases_types.name as case_type,
                                    cases_sub_types.name as case_sub_type,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `client_reference_number` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as reference_number
                                   "
					))->get();
			}
			else {
				$case = \DB::table('cases')
					->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
					->join('cases_types', 'cases.case_type', '=', 'cases_types.id')
					->where('cases.id', '=', $id)
					->select(\DB::raw("
                                    cases.id,
                                    cases.description,
                                    cases.created_at,
                                    cases.img_url,
                                    cases.reporter as reporteID,
                                    cases.house_holder_id,
                                    cases.street_number,
                                    cases.route,
                                    cases.locality,
                                    cases.administrative_area_level_1,
                                    cases.postal_code,
                                    cases.country,
                                    cases.saps_case_number,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    cases.investigation_cell,
                                    cases.investigation_email,
                                    cases.investigation_note,
                                    cases.client_reference_number,
                                    cases_statuses.name as status,
                                    cases_types.name as case_type,
                                    cases.saps_station,
                                    cases.investigation_officer,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporter,
                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as household,
                                    (select `created_at` from `cases_activities` where `case_id` = `cases`.`id` order by `created_at` desc limit 1) as last_at,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `cellphone` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as householdCell,
                                    IF(`cases`.`addressbook` = 1,(SELECT `cellphone` FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`house_holder_id`), (SELECT `client_reference_number` FROM `users` WHERE `users`.`id`= `cases`.`house_holder_id`)) as reference_number
                                   "
					))->get();
			}
		}

		return view('cases.test');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request $request
	 * @param  int     $id
	 * @return Response
	 */
	public function captureCaseUpdate(CaseRequest $request) {
		$txtDebug = __CLASS__ . "." . __FUNCTION__ . "(CaseRequest \$request) \$request - " . print_r($request, 1);
		die("<pre>{$txtDebug}</pre>");
		$userRole           = UserRole::where('name', '=', 'House Holder')->first();
		$user               = New User();
		$user->role         = $userRole->id;
		$user->name         = $request['name'];
		$user->surname      = $request['surname'];
		$user->cellphone    = $request['cellphone'];
		$user->id_number    = $request['id_number'];
		$user->position     = $request['position'];
		$title              = Title::where('slug', '=', $request['title'])->first();
		$user->title        = $title->id;
		$user->gender       = $request['gender'];
		$user->dob          = $request['dob'];
		$user->house_number = $request['house_number'];
		$user->email        = $request['cellphone'] . "@siyaleader.net";
		$user->created_by   = \Auth::user()->id;
		$language           = Language::where('slug', '=', $request['language'])->first();
		$user->language     = $language->id;
		$province           = Province::where('slug', '=', $request['province'])->first();
		$user->province     = $province->id;
		$district           = District::where('slug', '=', $request['district'])->first();
		$user->district     = $district->id;
		$municipality       = Municipality::where('slug', '=', $request['municipality'])->first();
		$user->municipality = $municipality->id;
		$ward               = Ward::where('slug', '=', $request['ward'])->first();
		$user->ward         = $ward->id;
		$user->save();
		$casePriority          = CasePriority::where('slug', '=', $request['priority'])->first();
		$case                  = CaseReport::find($request['caseID']);
		$case->description     = $request['description'];
		$case->priority        = $casePriority->id;
		$case->province        = $user->province;
		$case->district        = $user->district;
		$case->municipality    = $user->municipality;
		$case->ward            = $user->ward;
		$case->area            = $user->area;
		$case->house_holder_id = $user->id;
		$case->updated_by      = \Auth::user()->id;
		$case->updated_at      = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
		$case->save();

		return 'ok';
	}

	public function captureCaseUpdateH(CaseRequestH $request) {
		$txtDebug = __CLASS__ . "." . __FUNCTION__ . "(CaseRequestH \$request) \$request - " . print_r($request, 1);
		die("<pre>{$txtDebug}</pre>");
		$casePriority          = CasePriority::where('slug', '=', $request['priority'])->first();
		$houseHolderObj        = User::find($request['hseHolderId']);
		$case                  = CaseReport::find($request['caseID']);
		$case->province        = $houseHolderObj->province;
		$case->district        = $houseHolderObj->district;
		$case->municipality    = $houseHolderObj->municipality;
		$case->ward            = $houseHolderObj->ward;
		$case->area            = $houseHolderObj->area;
		$case->description     = $request['description'];
		$case->priority        = $casePriority->id;
		$case->updated_by      = \Auth::user()->id;
		$case->house_holder_id = $request['hseHolderId'];
		$case->updated_at      = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
		$case->save();

		return 'ok';
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function create(CreateCaseRequest $request) {
		$txtDebug                 = __CLASS__ . "." . __FUNCTION__ . "(CreateCaseRequest \$request) \$request - " . print_r($request, 1);
		$case                     = CaseReport::find($request['caseID']);
		$newCase                  = New CaseReport();
		$newCase->created_at      = $case->created_at;
		$newCase->user            = $case->user;
		$newCase->priority        = $case->priority;
		$newCase->status          = 1;
		$newCase->description     = $request['description'];
		$newCase->province        = $case->province;
		$newCase->district        = $case->district;
		$newCase->municipality    = $case->municipality;
		$newCase->ward            = $case->ward;
		$newCase->area            = $case->area;
		$newCase->addressbook     = $case->addressbook;
		$newCase->source          = 3;
		$newCase->active          = 1;
		$newCase->house_holder_id = $case->house_holder_id;
		$newCase->agent           = $case->agent;
		die("<pre>{$txtDebug}</pre>");
		$newCase->save();
		$relatedCase             = New CaseRelated();
		$relatedCase->parent     = $request['caseID'];
		$relatedCase->child      = $newCase->id;
		$relatedCase->created_by = \Auth::user()->id;
		$relatedCase->created_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
		$relatedCase->save();
		$response["message"] = "Case created successfully";
		$response["error"]   = FALSE;
		$response["caseID"]  = $request['caseID'];

		return \Response::json($response, 201);
	}

	function workflow($id) {
		$case      = CaseReport::find($id);
		$workflows = \DB::table('workflows')
			->where('sub_category_id', '=', $case->sub_category)
			->select(
				\DB::raw("
                                        workflows.id,
                                        workflows.name,
                                        workflows.sub_category_id,
                                        workflows.order,
                                        workflows.created_by,
                                        workflows.updated_by,
                                        workflows.active
                                    "
				)
			)
			->groupBy('workflows.id');

		return \Datatables::of($workflows)
			->make(true);
	}

	/**
	 * @param CreateCaseAgentRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	function createCaseAgent(Request $request) {
		$txtDebug = __CLASS__ . "." . __FUNCTION__ . "(CreateCaseAgentRequest \$request) \$request - " . print_r($request->all(), 1);
		$house_holder_id = 0;
		if ($request['hseHolderId']) $house_holder_id = $request['hseHolderId'];
		else if ($request['hseHolderId']) $house_holder_id = $request['hseHolderId'];
		$txtDebug .= PHP_EOL . "  \$house_holder_id - {$house_holder_id}";
		//die("<pre>{$txtDebug}</pre>");
		/*if (empty($house_holder_id)) {
			$userRole                      = UserRole::where('name', '=', 'Client')->first();
			$user                          = New User();
			$user->role                    = $userRole ? $userRole->id : 0;
			$user->name                    = $request['name'];
			$user->surname                 = $request['surname'];
			$user->cellphone               = $request['cellphone'];
			$user->title                   = 1;
			$user->client_reference_number = $request['client_reference_number'];
			$user->email                   = $request['cellphone'] . "@siyaleader.net";
			$user->created_by              = \Auth::user()->id;
			$language                      = Language::where('slug', '=', $request['language'])->first();
			$user->language                = $language ? $language->id : 0;
			$user->company                 = $request['company'];
			$user->position                = 1;
			$user->gender                  = 1;
			$user->affiliation             = 1;
			$user->save();
			$house_holder_id = $user->id;
		}*/
		$house_holder_id = ($house_holder_id == 0) ? $request['hseHolderId'] : $house_holder_id;
		$case_type        = ($request['case_type'] == 0) ? 5 : $request['case_type'];
		$case_sub_type    = ($request['case_sub_type'] == 0) ? 7 : $request['case_sub_type'];
		$house_holder_obj = User::find($house_holder_id);
		if ($request['officers'] == 0) {
		$txtDebug .= "\n  Creating new officer";
			$officerObj            = new InvestigationOfficer();
			$officerObj->name      = array_key_exists("investigation_officer", $_REQUEST) ? $request['investigation_officer'] : "";
			$officerObj->email     = array_key_exists("investigation_email",$_REQUEST) ? $request['investigation_email'] : "";
			$officerObj->cellphone = array_key_exists("investigation_cell",$_REQUEST) ? $request['investigation_cell'] : "";
			$officerObj->save();
			$officer = $officerObj->id;
		}
		else {
			$officerObj = InvestigationOfficer::find($request['officers']);
			$officer    = $officerObj->id;
			$txtDebug .= "\n  Using existing officer: ".print_r($officerObj,1);
		}
		$txtDebug .= "\n  \$officer - ".print_r($officer,1);
		//die("<pre>{$txtDebug}</pre>");

		// VD BEGIN: Reporter
		$id_reporter = 0;
		$oReporter = null;
		if ($request['reporter'] == 0 && $request['reporter_name']) {
			$txtDebug .= "\n  Creating new reporter";
			$oReporter = new \App\Reporter();
			$oReporter->name      = array_key_exists('reporter_name',$_REQUEST) ? $request['reporter_name'] : "";
			$oReporter->email     = array_key_exists('reporter_email', $_REQUEST) ? $request['reporter_email'] : "";
			$oReporter->cellphone = array_key_exists('reporter_cell',$_REQUEST) ? $request['reporter_cell'] : "";
			//if ($request['reporter_email'] != "" || $request['reporter_cell'] ) 
			$oReporter->save();
			$txtDebug .= ", new id - ".$oReporter->id;
			$id_reporter = $oReporter->id;
		} else if ($request['reporter']) {
			$oReporter = \App\Reporter::find($request['reporter']);
			$txtDebug .= "\n  Using existing reporter: ".print_r($oReporter,1);
			$id_reporter = $oReporter->id;
		}
		// VD END: Reporter
//die("<pre>{$txtDebug}</pre>");
		$newCase                              = New CaseReport();
		$newCase->created_at                  = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
		$newCase->occured_at = "{$request['occured_at_date']} {$request['occured_at_time']}";
		$newCase->user                        = \Auth::user()->id;
		$newCase->reporter                    = $id_reporter;
		$newCase->house_holder_id             = $house_holder_id;
		$newCase->description                 = $request['description'];
		$newCase->case_type                   = is_array($case_type) ? $case_type[0] : $case_type;
		$newCase->case_sub_type               = is_array($case_sub_type) ? $case_sub_type[0] : $case_sub_type;
		$newCase->saps_case_number            = $request['saps_case_number'];
		$newCase->saps_station                = $request['saps_station'];
		$newCase->investigation_officer       = $officer;
		$newCase->investigation_cell          = $request['investigation_cell'];
		$newCase->investigation_email         = $request['investigation_email'];
		$newCase->investigation_note          = $request['investigation_note'];
		$newCase->client_reference_number     = $request['client_reference_number'];
		$newCase->rate_value                  = $request['rate_value'];
		$newCase->status                      = 1;
		$newCase->addressbook                 = 0;
		$newCase->source                      = 3;
		$newCase->active                      = 1;
		$newCase->street_number               = $request['street_number'];
		$newCase->route                       = $request['route'];
		$newCase->locality                    = $request['locality'];
		$newCase->administrative_area_level_1 = $request['administrative_area_level_1'];
		$newCase->postal_code                 = $request['postal_code'];
		$newCase->country                     = $request['country'];
		$newCase->gps_lat                     = $request['gpsAddressLat'];
		$newCase->gps_lng                     = $request['gpsAddressLong'];
		$newCase->address = $request['address'];
		$newCase->save();
		$create_case_owner_data = array(
			"case_id"     => $newCase->id,
			"user"        => $newCase->user,
			"type"        => 1,
			"addressbook" => 0
		);
		$user = User::find(\Auth::user()->id);
		$this->case_owners->create_case_owner($create_case_owner_data);
		$this->case_responders->send_com($user, $newCase);
		$first_responders = $this->case_responders->get_responders_by_sub_case_type($newCase->case_sub_type, 1);
		if (empty($first_responders)) {
			$first_responders = $this->case_responders->get_responders_by_case_type($newCase->case_type, 1);
		}
		foreach ($first_responders as $first_responder) {
			$create_case_owner_data = array(
				"case_id"     => $newCase->id,
				"user"        => $first_responder->responder,
				"type"        => 1,
				"addressbook" => 0
			);
			$this->case_owners->create_case_owner($create_case_owner_data);
		}
		$this->case_responders->send_comms_to_first_responders($newCase, $first_responders);
		$caseNote          = new CaseNote();
		$caseNote->note    = $request['investigation_note'] ? $request['investigation_note'] : "";
		$caseNote->user    = \Auth::user()->id;
		$caseNote->case_id = $newCase->id;
		$caseNote->save();
		if ($request->file('caseFile') == NULL) {
			$destinationFolder = 'files/case_' . $newCase->id;
			if (!File::exists($destinationFolder)) {
				$createDir = \File::makeDirectory($destinationFolder, 0777, true);
			}
		}
		else {
			$destinationFolder = 'files/case_' . $newCase->id;
			if (!File::exists($destinationFolder)) {
				$createDir = \File::makeDirectory($destinationFolder, 0777, true);
			}
			$fileName = $request->file('caseFile')->getClientOriginalName();
			$fileFullPath = $destinationFolder . '/' . $fileName;
			if (!File::exists($fileFullPath)) {
				$request->file('caseFile')->move($destinationFolder, $fileName);
				$caseFile          = new CaseFile();
				$caseFile->file    = $fileName;
				$caseFile->img_url = $fileFullPath;
				$caseFile->user    = \Auth::user()->id;
				$caseFile->case_id = $newCase->id;
				$caseFile->save();
			}
		}
		$response["message"] = "Case created successfully";
		$response["error"]   = FALSE;
		$response["caseID"]  = $newCase->id;
		//return "ok";
		\Session::flash('success', 'Well done! Case ' . $newCase->id . ' has been successfully created');

		return Redirect::to('pendingCases/');
	}

	public function getCases() {
		$searchString = \Input::get('q');
		$cases        = \DB::table('cases')
			->whereRaw(
				"CONCAT(`cases`.`id`, ' ', `cases`.`description`) LIKE '%{$searchString}%'")
			->select(
				array
				(
					'cases.id as id',
					'cases.description as description',
				)
			)
			->get();
		$data = array();
		foreach ($cases as $case) {
			$data[] = array(
				"id"   => "{$case->id}",
				"name" => "Case Number: {$case->id} >  Description: {$case->description}",
			);
		}

		return $data;
	}

	function relatedCases($id) {
		$relatedCases = \DB::table('related_cases')
			->join('cases', 'related_cases.child', '=', 'cases.id')
			->where('related_cases.parent', '=', $id)
			->select(
				array(
					'cases.id as id',
					'cases.description as description',
					'related_cases.created_at as created_at'
				)
			);

		return \Datatables::of($relatedCases)
			->addColumn('actions', '<a class="btn btn-xs btn-alt" data-toggle="modal" onClick="launchUpdateAffiliationModal({{$id}});" data-target=".modalEditAffiliation">Edit</a>')
			->make(true);
	}

	public function allCases() {
		return view('cases.allCases');
	}

	public function allCasesList() {
		$userRoleObj = UserRole::find(Auth::user()->role);
		if ($userRoleObj->id == 1) {
			$cases = \DB::table('cases')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_sources', 'cases.source', '=', 'cases_sources.id')
				->leftJoin('cases_seen', function ($join) {
					$join->on('cases_seen.cid', '=', 'cases.id');
					if (\Auth::check()) $join->on('cases_seen.uid', '=', \DB::raw(\Auth::id()));
				})
				->select(
					/*\DB::raw(
						"

                                    cases.id,
                                    cases.created_at,
                                    cases.description,
                                    cases_sources.name as source,
                                    cases_statuses.name as CaseStatus
									, cases_seen.when AS seen"
					)*/
					array("cases.id",
						"cases.created_at",
						"cases.description",
						"cases_sources.name as source",
                                    "cases_statuses.name as CaseStatus"
									, "cases_seen.when AS seen")
				);
		}
		else {
			$cases = \DB::table('cases')
				->leftJoin('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
				->leftJoin('cases_sources', 'cases.source', '=', 'cases_sources.id')
				->leftJoin('cases_seen', function ($join) {
					$join->on('cases_seen.cid', '=', 'cases.id');
					if (\Auth::check()) $join->on('cases_seen.uid', '=', \DB::raw(\Auth::id()));
				})
				->where('cases.agent', '=', \Auth::user()->id)
				->select(
					/*\DB::raw("

                                            cases.id,
                                            cases.created_at,
                                            cases.description,
                                            cases_sources.name as source,
                                            cases_statuses.name as CaseStatus
											, cases_seen.when AS seen"
					)*/
					array("cases.id",
						"cases.created_at",
						"cases.description",
						"cases_sources.name as source",
                                            "cases_statuses.name as CaseStatus"
											, "cases_seen.when AS seen")
				);
		}
		/*
		select
		cases.id,
		cases.created_at,
		cases.description,
		cases_sources.name as source,
		cases_statuses.name as CaseStatus
		, cases_seen.when AS seen
		from `cases` inner join `cases_statuses` on `cases`.`status` = `cases_statuses`.`id` inner join `cases_sources` on `cases`.`source` = `cases_sources`.`id`
		left join cases_seen on cases.id = cases_seen.cid and cases_seen.uid = 10

		*/

//die($cases->toSql());
		return \Datatables::of($cases)
			->addColumn('seen', '<img class="btnSeen" id="btnSeen_{{ $id }}" src="{{ asset(\'images/bell_\'.($seen ? \'seen\' : \'unseen\').\'.png\') }}" style="text-align: right">')
			->addColumn('actions', '<a class="btn btn-xs btn-alt" data-toggle="modal" href="casetest/{{ $id }}"  target="_self">View</a>

                                                   <a class="btn btn-xs btn-alt" data-toggle="modal" href="view-case-poi-associates/{{ $id }}" target="_blank">POI Chart</a>
                                                    ')
			->make(true);
	}

	public function allocatedCases() {
		return view('cases.allocatedCases');
	}

	public function closedCases() {
		return view('cases.closedCases');
	}

	public function pendingCases() {
		return view('cases.pendingCases');
	}

	public function pendingClosureCases() {
		return view('cases.pendingClosureCases');
	}

	public function updateCase(Request $req) {
		$txtDebug    = __CLASS__ . "" . __FUNCTION__."(\$req) \$req - ".print_r($req->all(),1);
		$case = \App\CaseReport::find($req['caseID']);
		$reporter = \App\Reporter::find($case['reporter']);
		$vals = array();
		foreach ($req->all() AS $k=>$v) {
			if (is_array($v)) $vals[$k] = $v[0];
			else $vals[$k] = $v;
		}
		$txtDebug .= "\n  \$vals - ".print_r($vals,1);
		$case->fill($vals);
		//if ($vals['reporter_name']) $reporter['name'] = $vals['reporter_name'];
		if ($vals['reporter_cellphone']) $reporter['cellphone'] = $vals['reporter_cellphone'];
		if ($vals['reporter_email']) $reporter['email'] = $vals['reporter_email'];
		if (array_key_exists("reporter", $vals)) $case['reporter'] = $vals['reporter'];
		$txtDebug .= "\n  \$case - ".print_r($case,1);
		$txtDebug .= "\n  \$reporter - ".print_r($reporter,1);
		//die("<pre>{$txtDebug}</pre>");
		$saved = $case->save();

		if ($saved) \Session::flash('success', 'Well done! Case ' . $case->id . ' has been successfully updated');
		else \Session::flash('success', 'Whoop! Problem updating case ' . $case->id);

		if ($reporter) $reporter->save();

		return Redirect::to('allCases/');
		die("<pre>{$txtDebug}</pre>");
	}

}
