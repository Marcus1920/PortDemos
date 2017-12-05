<?php

namespace App\Http\Controllers;
use App\DroneSubType;
use Illuminate\Http\Request;
use App\User;
use App\Position;
use App\DroneRequest;
use App\DroneRequestActivity;
use App\DroneRejectReason;
use App\Department;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\DroneType;
use function MongoDB\BSON\toJSON;
use Redirect;
use Mapper;
use App\Http\Requests\DroneRequestForm;
class DroneRequestController extends Controller
{
    public function getList()
    {
        return view('drones.DroneRequestList');
    }
    public function getPerUser($id)
    {
        $user = User::find($id);
        $position = Position::find($user->position);
        if($position->name=="Harbour Master")
        {
            $droneRequests = \DB::table('drone_requests')
                ->join('drone_types', 'drone_requests.drone_type_id', '=', 'drone_types.id')
                ->join('drone_sub_types', 'drone_requests.sub_drone_type_id', '=', 'drone_sub_types.id')
                ->join('users', 'drone_requests.created_by', '=', 'users.id')
                ->join('drone_approval_statuses', 'drone_requests.drone_case_status', '=', 'drone_approval_statuses.id')
                ->join('departments', 'drone_requests.department', '=', 'departments.id')
                ->join('drone_reject_reasons', 'drone_requests.reject_reason', '=', 'drone_reject_reasons.id')
                ->select(\DB::raw
                (
                    "
                    drone_requests.id,
                    drone_requests.created_at,
                    drone_types.name as DroneType,
                    drone_sub_types.name as DroneSubType,
                    drone_requests.notes,
                    users.name as CreatedBy,
                    drone_approval_statuses.name as CaseStatus,
                    departments.name as Department,
                    drone_requests.notes,
                    drone_reject_reasons.reason as RejectReason,
                    drone_requests.created_by,
                    drone_requests.drone_case_status,
                    drone_requests.caseNumber,
                    drone_requests.serviceRequired,
                    drone_requests.drone_sub_service_type_id,
                    drone_requests.purposeOfSurvey,
                    drone_requests.numberOfStockpiles,
                    drone_requests.vertical_accuracy
                "
                ))
                ->where('drone_case_status',2)
                ->groupBy('drone_requests.id');
            return \Datatables::of($droneRequests)
                ->addColumn('actions', '
            <div class="row">
                    <div class="col-md-3">
                  <a class="btn btn-xs btn-alt" data-toggle="modal" href="api/v1/drone/{{ $id }}" target="">View</a></div> 
                  </div>
                      '
                )
                ->make(true);
        }
        else if($position->name=="Dive Master")
        {
            $droneRequests = \DB::table('drone_requests')
                ->join('drone_types', 'drone_requests.drone_type_id', '=', 'drone_types.id')
                ->join('drone_sub_types', 'drone_requests.sub_drone_type_id', '=', 'drone_sub_types.id')
                ->join('users', 'drone_requests.created_by', '=', 'users.id')
                ->join('drone_approval_statuses', 'drone_requests.drone_case_status', '=', 'drone_approval_statuses.id')
                ->join('departments', 'drone_requests.department', '=', 'departments.id')
                ->join('drone_reject_reasons', 'drone_requests.reject_reason', '=', 'drone_reject_reasons.id')
                ->select(\DB::raw
                (
                    "
                    drone_requests.id,
                    drone_requests.created_at,
                    drone_types.name as DroneType,
                    drone_sub_types.name as DroneSubType,
                    drone_requests.notes,
                    users.name as CreatedBy,
                    drone_approval_statuses.name as CaseStatus,
                    departments.name as Department,
                    drone_requests.notes,
                    drone_reject_reasons.reason as RejectReason,
                    drone_requests.created_by,
                    drone_requests.drone_case_status,
                    drone_requests.caseNumber,
                    drone_requests.serviceRequired,
                    drone_requests.drone_sub_service_type_id,
                    drone_requests.purposeOfSurvey,
                    drone_requests.numberOfStockpiles,
                    drone_requests.vertical_accuracy
                    
                "
                )
                )
                ->where('drone_case_status',3)
                ->groupBy('drone_requests.id');
            return \Datatables::of($droneRequests)
                ->addColumn('actions', '
            <div class="row">
                    <div class="col-md-3">
                  <a class="btn btn-xs btn-alt" data-toggle="modal" href="api/v1/drone/{{ $id }}" target="">View</a>
                  </div> 
                  </div>
                      '
                )
                ->make(true);
        }
        else {
            $droneRequests = \DB::table('drone_requests')
                ->join('drone_types', 'drone_requests.drone_type_id', '=', 'drone_types.id')
                ->join('drone_sub_types', 'drone_requests.sub_drone_type_id', '=', 'drone_sub_types.id')
                ->join('users', 'drone_requests.created_by', '=', 'users.id')
                ->join('drone_approval_statuses', 'drone_requests.drone_case_status', '=', 'drone_approval_statuses.id')
                ->join('departments', 'drone_requests.department', '=', 'departments.id')
                ->join('drone_reject_reasons', 'drone_requests.reject_reason', '=', 'drone_reject_reasons.id')
                ->select(\DB::raw
                (
                    "
                    drone_requests.id,
                    drone_requests.created_at,
                    drone_types.name as DroneType,
                    drone_sub_types.name as DroneSubType,
                    drone_requests.notes,
                    users.name as CreatedBy,
                    drone_approval_statuses.name as CaseStatus,
                    departments.name as Department,
                    drone_requests.notes,
                    drone_reject_reasons.reason as RejectReason,
                    drone_requests.created_by,
                    drone_requests.drone_case_status,
                    drone_requests.caseNumber,
                    drone_requests.serviceRequired,
                    drone_requests.drone_sub_service_type_id,
                    drone_requests.purposeOfSurvey,
                    drone_requests.numberOfStockpiles,
                    drone_requests.vertical_accuracy
                "
                )
                )
                ->where('drone_request_owner', $user->position)
                ->orWhere('drone_requests.created_by', $id)
                ->groupBy('drone_requests.id');
            return \Datatables::of($droneRequests)
                ->addColumn('actions', '
            <div class="row">
            
            <div class="col-md-3">
                  <a class="btn btn-xs btn-alt"  href="api/v1/showDroneRequest/{{ $id }}" target="">View</a>
                  </div>
                  <div class="col-md-1"></div>
                  </div>
                      '
                )
                ->make(true);
        }
    }
    public function index()
    {
        $droneRequests = \DB::table('drone_requests')
            ->join('drone_types', 'drone_requests.drone_type_id', '=', 'drone_types.id')
            ->join('drone_sub_types', 'drone_requests.sub_drone_type_id', '=', 'drone_sub_types.id')
            ->join('users', 'drone_requests.created_by', '=', 'users.id')
            ->join('drone_approval_statuses', 'drone_requests.drone_case_status', '=', 'drone_approval_statuses.id')
            ->join('departments', 'drone_requests.department', '=', 'departments.id')
            ->join('drone_reject_reasons', 'drone_requests.reject_reason', '=', 'drone_reject_reasons.id')
            ->select(\DB::raw
            (
                "
                    drone_requests.id,
                    drone_requests.created_at,
                    drone_types.name as DroneType,
                    drone_sub_types.name as DroneSubType,
                    drone_requests.notes,
                    users.name as CreatedBy,
                    drone_approval_statuses.name as CaseStatus,
                    departments.name as Department,
                    drone_requests.notes,
                    drone_reject_reasons.reason as RejectReason
                "
            )
            )
            ->groupBy('drone_requests.id');
        return \Datatables::of($droneRequests)
            ->addColumn('actions','
            <div class="row">
            
            <div class="col-md-3">
                 
                  <a class="btn btn-xs btn-alt"  href="api/v1/showDroneRequest/{{ $id }}" target="">View</a>
                  </div>
                  <div class="col-md-1"></div>
            
                    <div class="col-md-3">
                  <a class="btn btn-xs btn-alt" data-toggle="modal" href="api/v1/drone/{{ $id }}" target="">View</a>
                  </div> 
                  </div>
                      '
            )
            ->make(true);
        //  return $droneRequests;
    }
    public function store(Request $request)
    {
        $newDroneRequest = new DroneRequest();
        $userRole = User::find(\Auth::user()->id);
        $position = Position::find($userRole->position);
        if($position->name == "SHE Representative") {
            $responderPosition = Position::where('name', 'Environmental Manager')->first();
            $newDroneRequest->drone_request_owner = $responderPosition->id;
        }
        else if($position->name == "Engineering Officer") {
            $responderPosition = Position::where('name', 'Senior Engineer')->first();
            $newDroneRequest->drone_request_owner = $responderPosition->id;
        }
        else if($position->name == "Vessel Traffic Controller") {
            $responderPosition = Position::where('name', 'Deputy Harbour Master')->first();
            $newDroneRequest->drone_request_owner = $responderPosition->id;
        }
        else if($position->name == "Joint Operations Centre Monitor") {
            $responderPosition = Position::where('name', 'Deputy Harbour Master')->first();
            $newDroneRequest->drone_request_owner = $responderPosition->id;
        }
        $drone_sub_types   = DroneSubType::find($request['sub_drone_type_id']);
        if($drone_sub_types->name == "Real Time")
        {
            $newDroneRequest->created_by = $request['created_by'];
            $newDroneRequest->drone_type_id = $request['drone_type_id'];
            $newDroneRequest->sub_drone_type_id = $request['sub_drone_type_id'];
            $newDroneRequest->drone_case_status = 1;
            $newDroneRequest->notes = $request['notes'];
            $newDroneRequest->department = $request['dronesDepartment'];
            $newDroneRequest->reject_reason = 4;
            $newDroneRequest->reject_other_reason = "None";
            $newDroneRequest->scope_of_work = $request['scope_of_work'];
            $newDroneRequest->serviceRequired = $request['service'];
            $newDroneRequest->save();
        }
        elseif($drone_sub_types->name =="Ad Hoc") {
            $newDroneRequest->created_by = $request['created_by'];
            $newDroneRequest->drone_type_id = $request['drone_type_id'];
            $newDroneRequest->sub_drone_type_id = $request['sub_drone_type_id'];
            $newDroneRequest->drone_case_status = 1;
            $newDroneRequest->notes = $request['notes'];
            $newDroneRequest->scope_of_work = $request['scope_of_work'];
            $newDroneRequest->drone_sub_service_type_id = $request['drone_sub_service_type_id'];
            $newDroneRequest->interest = $request['interest'];
            $newDroneRequest->department = $request['dronesDepartment'];
            $newDroneRequest->reject_reason = 4;
            $newDroneRequest->reject_other_reason = "None";
            $newDroneRequest->caseNumber = $request['caseNumber'];
            $newDroneRequest->geoFence = $request['geoFenceCoords'];
            $newDroneRequest->purposeOfSurvey = $request['purpose_of_survey'];
            $newDroneRequest->numberOfStockpiles = $request['number_of_stockpiles'];
            $newDroneRequest->vertical_accuracy = $request['vertical_accuracy'];
            $newDroneRequest->save();
        }
        $newDroneRequest->save();
        $dronRequestActivity = new DroneRequestActivity();
        $dronRequestActivity->drone_request_id = $newDroneRequest->id;
        $dronRequestActivity->user = $request['created_by'];
        $dronRequestActivity->activity = "requested a drone";
        $dronRequestActivity->save();
        $userRole = User::find($request['created_by']);
        $position = Position::find($userRole->position);
        if($position->name == "SHE Representative")
        {
            $responderPosition = Position::where('name','Environmental Manager')->first();
            $droneRequestResponder = User::where('position',$responderPosition->id)->get();
            $departmentName        = Department::where('id', $newDroneRequest->department)->first();
            $droneName             = DroneType::where('id',$newDroneRequest->drone_type_id)->first();

            if($droneRequestResponder!=NULL)
            {
                $data = array(
                    'name'    => $droneRequestResponder[0]['name'],
                    'messageBody'=> "This is a message from". " ". Auth::user()->name ." ". Auth::user()->surname." to inform you that their department ( $departmentName->name ) requested to use an "."$droneName->name"
                );
                \Mail::send('emails.Drones.DronesRequestCreate',$data,function($message) use ($droneRequestResponder)
                {
                    $email = $droneRequestResponder[0]['email'];
                    $message->from('info@siyaleader.net', 'Siyaleader');
                    $message->to($email)->subject('New drone request');
                });
            }
            else
            {
                \Session::flash('success', 'A drone request  has been sent, you will get a response soon!');
                return Redirect::back();
            }
        }
        else if($position->name == "Engineering officer")
        {
            $responderPosition = Position::where('name','Senior Engineer')->first();
            $droneRequestResponder = User::where('position',$responderPosition->id)->get();
            $departmentName        = Department::where('id', $newDroneRequest->department)->first();
            $droneName             = DroneType::where('id',$newDroneRequest->drone_type_id)->first();

            if($droneRequestResponder!=NULL)
            {
                $data = array(
                    'name'    => $droneRequestResponder[0]['name'],
                    'messageBody'=> "This is a message from". " ". Auth::user()->name ." ". Auth::user()->surname." to inform you that their department ( $departmentName->name ) requested to use an "."$droneName->name"
                );
                \Mail::send('emails.Drones.DronesRequestCreate',$data,function($message) use ($droneRequestResponder)
                {
                    $email = $droneRequestResponder[0]['email'];
                    $message->from('info@siyaleader.net', 'Siyaleader');
                    $message->to($email)->subject('New drone request');
                });
            }
            else
            {
                \Session::flash('success', 'A drone request  has been sent, you will get a response soon!');
                return Redirect::back();
            }
        }
        else if($position->name == "Vessel Traffic Controller")
        {
            $responderPosition = Position::where('name','Deputy Harbour Master')->first();
            $droneRequestResponder = User::where('position',$responderPosition->id)->get();
            $departmentName        = Department::where('id', $newDroneRequest->department)->first();
            $droneName             = DroneType::where('id',$newDroneRequest->drone_type_id)->first();

            if($droneRequestResponder!=NULL)
            {
                $data = array(
                    'name'    => $droneRequestResponder[0]['name'],
                    'messageBody'=> "This is a message from". " ". Auth::user()->name ." ". Auth::user()->surname." to inform you that their department ( $departmentName->name ) requested to use an "."$droneName->name"
                );
                \Mail::send('emails.Drones.DronesRequestCreate',$data,function($message) use ($droneRequestResponder)
                {
                    $email = $droneRequestResponder[0]['email'];
                    $message->from('info@siyaleader.net', 'Siyaleader');
                    $message->to($email)->subject('New drone request');
                });
            }
            else
            {
                \Session::flash('success', 'A drone request  has been sent, you will get a response soon!');
                return Redirect::back();
            }
        }
        else if($position->name == "Joint Operations Centre Monitor")
        {
            $responderPosition = Position::where('name','Deputy Harbour Master')->first();
            $droneRequestResponder = User::where('position',$responderPosition->id)->get();
            $departmentName        = Department::where('id', $newDroneRequest->department)->first();
            $droneName             = DroneType::where('id',$newDroneRequest->drone_type_id)->first();
            if($droneRequestResponder!=NULL)
            {
                $data = array(
                    'name'    => $droneRequestResponder[0]['name'],
                    'messageBody'=> "This is a message from". " ". Auth::user()->name ." ". Auth::user()->surname." to inform you that their department ( $departmentName->name ) requested to use an "."$droneName->name"
                );
                \Mail::send('emails.Drones.DronesRequestCreate',$data,function($message) use ($droneRequestResponder)
                {
                    $email = $droneRequestResponder[0]['email'];
                    $message->from('info@siyaleader.net', 'Siyaleader');
                    $message->to($email)->subject('New drone request');
                });
            }
            else
            {
                \Session::flash('success', 'A drone request  has been sent, you will get a response soon!');
                return Redirect::back();
            }
        }
        \Session::flash('success', 'A drone request  has been sent, you will get a response soon!');
        return Redirect::back();
    }
    public function FirstApprove($id, Request $request)
    {
        $dronRequest = DroneRequest::where('id',$id)
            ->update(['drone_case_status'=> 2,
                'updated_at'=>\Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString()]);
        $droneRequest = DroneRequest::with('DroneType')
            ->with('User')
            ->with('DroneSubType')
            ->with('DroneCaseStatus')
            ->with('Department')
            ->with('RejectReason')
            ->where('id',$id)
            ->first();

        $finalApproverPosition = Position::where('name','Harbour Master')->first();
        $user = User::where('position',$finalApproverPosition->id)->first();
        $data = array(
            'name'    => $user->name,
            'messageBody' =>Auth::user()->name ." ". Auth::user()->surname ." has approved your  drone request , please wait for the second approval from the higher officials."
            );
        \Mail::send('emails.Drones.approve',$data,function($message) use ($user)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($user->email)->subject('First Approved drone request');
        });
        $data = array(
            'name'    => $droneRequest->User->name,
            'messageBody' =>Auth::user()->name ." ". Auth::user()->surname ." has approved your  drone request , please wait for the second approval from the higher officials.
            "
        );
        \Mail::send('emails.Drones.approve',$data,function($message) use ($droneRequest)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($droneRequest->User->email)->subject('First Approved drone request');
        });
        $dronRequestActivity = new DroneRequestActivity();
        $dronRequestActivity->drone_request_id = $id;
        $dronRequestActivity->user = $request['user'];
        $dronRequestActivity->activity = "first approved drone request";
        $dronRequestActivity->save();
        \Session::flash('success', 'Successfully first approved Drone request '.$id);
        return Redirect::to('DroneList');
    }
    public function Approve($id, Request $request)
    {
        $dronRequest = DroneRequest::where('id',$id)
            ->update(['drone_case_status'=> 3,
                'updated_at'=>\Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString()]);
        $droneRequest = DroneRequest::with('DroneType')
            ->with('User')
            ->with('DroneSubType')
            ->with('DroneCaseStatus')
            ->with('Department')
            ->with('RejectReason')
            ->where('id',$id)
            ->first();
        $dronRequestActivity = new DroneRequestActivity();
        $dronRequestActivity->drone_request_id = $id;
        $dronRequestActivity->user = $request['user'];
        $dronRequestActivity->activity = "final approved drone request";
        $dronRequestActivity->save();
        $droneActivity = DroneRequestActivity::where('drone_request_id',$id)->get();
        $firstResponder = User::find($droneActivity[1]['user']);
        $data1 = array(
            'name'    => $firstResponder->name,
            'messageBody' =>Auth::user()->name ." ". Auth::user()->surname ." has approved your  drone request."

        );
        \Mail::send('emails.Drones.approve',$data1,function($message) use ($firstResponder)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($firstResponder->email)->subject('Second approved drone request');
        });
        $data = array(
            'name'    => $droneRequest->User->name,
            'messageBody' =>Auth::user()->name ." ". Auth::user()->surname ." has approved your  drone request."
        );
        \Mail::send('emails.Drones.approve',$data,function($message) use ($droneRequest)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($droneRequest->User->email)->subject('Second approved drone request');
        });
        $diveMaster = Position::where('name','Dive Master')->first();
        $user = User::where('position',$diveMaster->id)->first();
        if($user!=NULL)
        {
            $data = array(
                'name'    => $user->name,
                'messageBody' =>Auth::user()->name ." ". Auth::user()->surname ." has approved your  drone request."
            );
            \Mail::send('emails.Drones.approve',$data,function($message) use ($user)
            {
                $message->from('info@siyaleader.net', 'Siyaleader');
                $message->to($user->email)->subject('Second approved drone request');
            });
        }
        else
        {
            \Session::flash('success', 'Finally Approved');
            return Redirect::back();
        }
        \Session::flash('success', 'Finally Approved');
        return Redirect::back();
    }
    public function Reject($id, Request $request)
    {
        if($request['reject_other_reason']==NULL)
        {
            $dronRequest = DroneRequest::where('id',$id)
                ->update(['drone_case_status'=> 4,
                    'reject_reason'=>$request['reject_reason'],
                    'updated_at'=>\Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString()]);
        }
        else
        {
            $dronRequest = DroneRequest::where('id',$id)
                ->update(['drone_case_status'=> 4,
                    'reject_reason'=>$request['reject_reason'],
                    'reject_other_reason'=>$request['reject_other_reason'],
                    'updated_at'=>\Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString()]);
        }
        $droneRequest = DroneRequest::with('DroneType')
            ->with('User')
            ->with('DroneSubType')
            ->with('DroneCaseStatus')
            ->with('Department')
            ->with('RejectReason')
            ->where('id',$id)
            ->first();
        $data = array(
            'name'    => $droneRequest->User->name,
            'messageBody'=>
        );
        \Mail::send('emails.Drones.reject',$data,function($message) use ($droneRequest)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($droneRequest->User->email)->subject('rejected drone request');
        });
        $dronRequestActivity = new DroneRequestActivity();
        $dronRequestActivity->drone_request_id = $id;
        $dronRequestActivity->user = $request['user'];
        $dronRequestActivity->activity = "rejected drone request";
        $dronRequestActivity->save();
        \Session::flash('success', 'Successfully rejected Drone request '.$id);
        return Redirect::to('DroneList');
    }
    public function showFirst($id)
    {
        $droneRequest = DroneRequest::with('DroneType')
            ->with('DroneSubType')
            ->with('DroneCaseStatus')
            ->with('Department')
            ->with('RejectReason')
            ->where('id',$id)
            ->first();
        $droneRejectReasons=DroneRejectReason::find([1,2,3]);
        $droneRequestActivity = DroneRequestActivity::with('DroneRequest')
            ->with('User')
            ->where('drone_request_id',$id)
            ->orderBy('id','DESC')
            ->get();
        $new_str                          =str_replace(str_split('()[object Object]'), '', $droneRequest->geoFence);
        $coordinates                      =chop(str_replace("_",",",$new_str),',');
        return view('drones.droneApprove',compact('droneRequest','droneRequestActivity','droneRejectReasons','coordinates'));
    }
    public function droneCoordinates($id)
    {
        $coordinates   = DroneRequest::where('id',$id)->first();
        return $coordinates;
    }
    public function show($id)
    {
        $droneRequest = DroneRequest::with('DroneType')
            ->with('DroneSubType')
            ->with('DroneCaseStatus')
            ->with('Department')
            ->with('RejectReason')
            ->where('id',$id)
            ->first();
        $droneRequestActivity = DroneRequestActivity::with('DroneRequest')
            ->with('User')
            ->where('drone_request_id',$id)
            ->orderBy('id','DESC')
            ->get();
        $new_str                          =str_replace(str_split('()[object Object]'), '', $droneRequest->geoFence);
        $coordinates                      =chop(str_replace("_",",",$new_str),',');
        $droneRejectReasons = DroneRejectReason::find([1,2,3]);
        return  view('drones.secondApprovalForm',compact('droneRequest','droneRequestActivity','droneRejectReasons','coordinates'));
    }
    public function userDepartment()
    {
        $searchString = \Input::get('q');
        $userDepartment = \DB::table('departments')
            ->whereRaw(
                "CONCAT(`departments`.`id`, ' ', `departments`.`name`) LIKE '%{$searchString}%'")
            ->select(
                array
                (
                    'departments.id as id',
                    'departments.name as name',
                )
            )
            ->get();
        $data = array();
        foreach ($userDepartment as $department) {
            $data[] = array(
                "name" => "Department ID: {$department->id} >  Name: {$department->name}",
                "id" => "{$department->id}"
            );
        }
        return $data;
    }
}


