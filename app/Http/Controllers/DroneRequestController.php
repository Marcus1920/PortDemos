<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Position;
use App\DroneRequest;
use App\DroneRequestActivity;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\Http\Requests\DroneRequestForm;
use App\DroneRejectReason;

class DroneRequestController extends Controller
{
    public function getList()
    {
        return view('drones.DroneRequestList');
    }

    public function index()
    {
        //Eloquent
//        $droneRequests = DroneRequest::with('User')
//            ->with('DroneType')
//            ->with('DroneSubType')
//            ->with('DroneCaseStatus')
//            ->with('Department')
//            ->with('RejectReason')
//            ->get();

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
                    drone_requests.comments,
                    users.name as CreatedBy,
                    drone_approval_statuses.name as CaseStatus,
                    departments.name as Department,
                    drone_requests.comments,
                    drone_reject_reasons.reason as RejectReason
                "
            )
            )
            ->groupBy('drone_requests.id');

        return \Datatables::of($droneRequests)
            ->make(true);
    }

    public function create()
    {
        //
    }

    public function store(DroneRequestForm $request)
    {
        $newDroneRequest = new DroneRequest();
        $newDroneRequest->created_by = $request['created_by'];
        $newDroneRequest->drone_type_id = $request['drone_type_id'];
        $newDroneRequest->sub_drone_type_id = $request['sub_drone_type_id'];
        $newDroneRequest->drone_case_status = 1;
        $newDroneRequest->comments = $request['comment'];
        $newDroneRequest->department = $request['department'];
        $newDroneRequest->reject_reason = 4;
        $newDroneRequest->reject_other_reason = "None";
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

            $data = array(
                'name'    => $droneRequestResponder[0]['name'],

            );

            \Mail::send('emails.Drones.DronesRequestCreate',$data,function($message) use ($droneRequestResponder)
            {
                $email = $droneRequestResponder[0]['email'];
                $message->from('info@siyaleader.net', 'Siyaleader');
                $message->to($email)->subject('testing notification');
            });


        }
        else if($position->name == "Engineering officer")
        {
            return "Engineering officer";
        }
        else if($position->name == "Vessel Traffic Controller")
        {
            return "vessel traffic controller";
        }
        else if($position->name == "Joint Operations Centre Monitor")
        {
            return "joint operations centre monitor";
        }

        \Session::flash('success', 'A drone request   has been sent, you will get a response soon!');
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

        $data = array(
            'name'    => $droneRequest->User->name,

        );

        \Mail::send('emails.Drones.DronesRequestCreate',$data,function($message) use ($droneRequest)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($droneRequest->User->email)->subject('First Approved drone request');
        });

        $dronRequestActivity = new DroneRequestActivity();
        $dronRequestActivity->drone_request_id = $id;
        $dronRequestActivity->user = $request['user'];
        $dronRequestActivity->activity = "first approved drone request";
        $dronRequestActivity->save();

        return "First Approved!";
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

        $droneActivity = DroneRequestActivity::where('drone_request_id',$id)->get();

        $firstResponder = User::find($droneActivity[1]['user']);

        $data1 = array(
            'name'    => $firstResponder->name,

        );

        \Mail::send('emails.Drones.DronesRequestCreate',$data1,function($message) use ($firstResponder)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($firstResponder->email)->subject('Second approved drone request');
        });

        $data = array(
            'name'    => $droneRequest->User->name,

        );

        \Mail::send('emails.Drones.DronesRequestCreate',$data,function($message) use ($droneRequest)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($droneRequest->User->email)->subject('Second approved drone request');
        });

        $dronRequestActivity = new DroneRequestActivity();
        $dronRequestActivity->drone_request_id = $id;
        $dronRequestActivity->user = $request['user'];
        $dronRequestActivity->activity = "final approved drone request";
        $dronRequestActivity->save();

        return "Successfully Approved";
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

        );

        \Mail::send('emails.Drones.DronesRequestCreate',$data,function($message) use ($droneRequest)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($droneRequest->User->email)->subject('rejected drone request');
        });


        $dronRequestActivity = new DroneRequestActivity();
        $dronRequestActivity->drone_request_id = $id;
        $dronRequestActivity->user = $request['user'];
        $dronRequestActivity->activity = "rejected drone request";
        $dronRequestActivity->save();

        return "Successfully Rejected drone request";
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
            ->get();

        $droneRejectReasons = DroneRejectReason::find([1,2,3]);

        return  view('drones.secondApprovalForm',compact('droneRequest','droneRequestActivity','droneRejectReasons'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        //
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
