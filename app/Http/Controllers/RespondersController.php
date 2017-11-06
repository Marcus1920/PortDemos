<?php

namespace App\Http\Controllers;


use App\CaseReport;
use Illuminate\Http\Request;

use App\services\CaseResponderService;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CaseResponder;

class RespondersController extends Controller
{



    protected $case_responders;

    public function __construct(CaseResponderService $service) {

        $this->case_responders = $service;
        $this->middleware('auth.token',['only' => ['store']]);
    }




    public function index($id)
    {

        $caseResponders = \DB::table('cases_owners')
            ->where('case_id','=',$id)
            ->join('users','users.id','=','cases_owners.user')
            ->select(
                array(
                    'users.id',
                    'users.name',
                    'users.surname',
                    'users.cellphone',
                    'cases_owners.type',
                    'cases_owners.accept'
                )
            );

        return \Datatables::of($caseResponders)
            ->addColumn('actions','<a class="btn btn-xs btn-alt" data-dest="{{$id}}" data-name="{{$name}} {{$surname}}" data-toggle="modal" onClick="launchMessageModal({{$id}},this);" data-target=".compose-message"><i class="fa fa-envelope"></i></a>'
            )
            ->make(true);

    }
    public function indexResponders($id)
    {
        $case=CaseReport::find($id);
        $caseType=$case->case_type;

        $caseResponders=\DB::table('responders')
            ->where('case_type','=',$caseType)
            ->join('users','users.id','=','responders.responder')
            ->select(
                array(
                    'users.id',
                    'users.name',
                    'users.surname',
                    'users.cellphone',
                    'responders.responder_type as type'
                )
            );

        return \Datatables::of($caseResponders)
            ->addColumn('actions','<a class="btn btn-xs btn-alt" data-dest="{{$id}}" data-name="{{$name}} {{$surname}}" data-toggle="modal" onClick="launchMessageModal({{$id}},this);" data-target=".compose-message"><i class="fa fa-envelope"></i></a>'
            )
            ->make(true);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storeSubSubResponder(Request $request)
    {

        $sub_sub_cat = $request['subsubCategoryID'];
        $result = CaseResponder::where('sub_sub_category','=',$sub_sub_cat)->first();

        if($result)
        {
            $result->first_responder   = $request['firstResponder'];
            $result->second_responder  = $request['secondResponder'];
            $result->third_responder   = $request['thirdResponder'];
            $result->created_by        = \Auth::user()->id;
            $result->save();
            \Session::flash('success','Responders have been successfully added!');
            return redirect()->back();



        }
        else {

            $responder                   = new CaseResponder();
            $responder->department       = $request['deptID'];
            $responder->category         = $request['catID'];
            $responder->sub_category     = $request['subCatID'];
            $responder->sub_sub_category = $request['subsubCategoryID'];
            $responder->first_responder  = $request['firstResponder'];
            $responder->second_responder = $request['secondResponder'];
            $responder->third_responder  = $request['thirdResponder'];
            $responder->created_by       = \Auth::user()->id;
            $responder->active           = 1;
            $responder->save();

            \Session::flash('success','Responders have been successfully added!');
            return redirect()->back();




        }

    }


    public function delete_responders($responders){


        foreach ($responders as $responder){

            $responder = CaseResponder::find($responder->id);
            $responder->delete();

        }

    }

    public function save_responder($responder,$request,$responder_type,$interval_time){

        $case_responder                   = new CaseResponder();
        $case_responder->department       = $request['deptID'];
        $case_responder->case_type        = $request['catID'];
        $case_responder->case_sub_type    = ($request['subCatID'])?$request['subCatID']:0;
        $case_responder->responder_type   = $responder_type;
        $case_responder->responder        = $responder;
        $case_responder->responder        = $responder;
        $case_responder->interval_time    = $interval_time;
        $case_responder->created_by       = \Auth::user()->id;
        $case_responder->active           = 1;
        $case_responder->save();
    }


    public function store_responder($responders,$request,$responder_type,$interval_time) {

        $responders = explode(',',$responders);

        foreach ($responders as $responder) {

            if(!empty($responder)) {

                $data = $this->case_responders->responder_exist($request['catID'],$request['subCatID'],$responder);

                if(!$data){

                    $this->save_responder($responder,$request,$responder_type,$interval_time);
                }

            }

        }


    }

    public function store_cat_responder($responders,$request,$responder_type,$interval_time) {

        $responders = explode(',',$responders);

        foreach ($responders as $responder) {

            if(!empty($responder)) {

                $data = $this->case_responders->responder_cat_exist($request['catID'],$responder);

                if(!$data){

                    $this->save_responder($responder,$request,$responder_type,$interval_time);
                }

            }

        }


    }


    public function storeSubResponder(Request $request)
    {

        $responders = $this->case_responders->get_responders_by_sub_case_type($request['subCatID'],0);
        $this->delete_responders($responders);
        $this->store_responder($request['firstResponder'],$request,1,$request['first_responder_interval_time']);
        $this->store_responder($request['secondResponder'],$request,2,$request['second_responder_interval_time']);
        $this->store_responder($request['thirdResponder'],$request,3,$request['third_responder_interval_time']);
        $this->store_responder($request['fourthResponder'],$request,4,$request['fourth_responder_interval_time']);

        \Session::flash('success','Responders have been successfully added!');
        return redirect()->back();

    }


    public function storeResponder(Request $request)
    {

        $responders = $this->case_responders->get_responders_by_case_type($request['catID'],0);
        $this->delete_responders($responders);
        $this->store_cat_responder($request['firstResponder'],$request,1,$request['first_responder_interval_time']);
        $this->store_cat_responder($request['secondResponder'],$request,2,$request['second_responder_interval_time']);
        $this->store_cat_responder($request['thirdResponder'],$request,3,$request['third_responder_interval_time']);
        $this->store_cat_responder($request['fourthResponder'],$request,4,$request['fourth_responder_interval_time']);

        \Session::flash('success','Responders have been successfully added!');
        return redirect()->back();

    }

    public function subResponder($id)
    {


        $first_responders     = CaseResponder::with('responderTypeFunc')
            ->with('user')
            ->where("case_sub_type",'=',$id)
            ->where('responder_type',1)->get();


        $second_responders    = CaseResponder::with('responderTypeFunc')
            ->with('user')
            ->where("case_sub_type",'=',$id)
            ->where('responder_type',2)->get();


        $third_responders    = CaseResponder::with('responderTypeFunc')
            ->with('user')
            ->where("case_sub_type",'=',$id)
            ->where('responder_type',3)->get();


        $fourth_responders    = CaseResponder::with('responderTypeFunc')
            ->with('user')
            ->where("case_sub_type",'=',$id)
            ->where('responder_type',4)->get();


        $response            = array();


        if (sizeof($first_responders) > 0) {


            foreach ($first_responders as $first_responder) {

                $user = \DB::table('users')
                    ->where('id','=',$first_responder->user->id)
                    ->select(\DB::raw(
                        "
                                    id,
                                    (select CONCAT(name, ' ',surname) ) as firstResponder

                                    "
                    )
                    )->first();

                $user->first_responder_interval_time = $first_responder->interval_time;

                $response[] = $user;

            }


        }

        if (sizeof($second_responders) > 0) {


            foreach ($second_responders as $second_responder) {

                $user = \DB::table('users')
                    ->where('id','=',$second_responder->user->id)
                    ->select(\DB::raw(
                        "
                                id,
                                (select CONCAT(name, ' ',surname) ) as secondResponder

                                "
                    )
                    )->first();

                $user->second_responder_interval_time = $second_responder->interval_time;

                $response[] = $user;

            }

        }

        if (sizeof($third_responders) > 0) {


            foreach ($third_responders as $third_responder) {

                $user = \DB::table('users')
                    ->where('id','=',$third_responder->user->id)
                    ->select(\DB::raw(
                        "
                                id,
                                (select CONCAT(name, ' ',surname) ) as thirdResponder

                                "
                    )
                    )->first();

                $user->third_responder_interval_time = $third_responder->interval_time;

                $response[] = $user;

            }


        }

        if (sizeof($fourth_responders) > 0) {


            foreach ($fourth_responders as $fourth_responder) {

                $user = \DB::table('users')
                    ->where('id','=',$fourth_responder->user->id)
                    ->select(\DB::raw(
                        "
                                id,
                                (select CONCAT(name, ' ',surname) ) as fourthResponder

                                "
                    )
                    )->first();

                $user->fourth_responder_interval_time = $fourth_responder->interval_time;

                $response[] = $user;

            }


        }

        return $response;
    }


    public function responder($id){

        $first_responders     = CaseResponder::with('responderTypeFunc')
            ->with('user')
            ->where("case_type",'=',$id)
            ->where('responder_type',1)->get();


        $second_responders    = CaseResponder::with('responderTypeFunc')
            ->with('user')
            ->where("case_type",'=',$id)
            ->where('responder_type',2)->get();


        $third_responders    = CaseResponder::with('responderTypeFunc')
            ->with('user')
            ->where("case_type",'=',$id)
            ->where('responder_type',3)->get();


        $fourth_responders    = CaseResponder::with('responderTypeFunc')
            ->with('user')
            ->where("case_type",'=',$id)
            ->where('responder_type',4)->get();


        $response            = array();


        if (sizeof($first_responders) > 0) {


            foreach ($first_responders as $first_responder) {

                $user = \DB::table('users')
                    ->where('id','=',$first_responder->user->id)
                    ->select(\DB::raw(
                        "
                                    id,
                                    (select CONCAT(name, ' ',surname) ) as firstResponder

                                    "
                    )
                    )->first();

                $user->first_responder_interval_time = $first_responder->interval_time;

                $response[] = $user;

            }


        }

        if (sizeof($second_responders) > 0) {


            foreach ($second_responders as $second_responder) {

                $user = \DB::table('users')
                    ->where('id','=',$second_responder->user->id)
                    ->select(\DB::raw(
                        "
                                id,
                                (select CONCAT(name, ' ',surname) ) as secondResponder

                                "
                    )
                    )->first();

                $user->second_responder_interval_time = $second_responder->interval_time;

                $response[] = $user;

            }

        }

        if (sizeof($third_responders) > 0) {


            foreach ($third_responders as $third_responder) {

                $user = \DB::table('users')
                    ->where('id','=',$third_responder->user->id)
                    ->select(\DB::raw(
                        "
                                id,
                                (select CONCAT(name, ' ',surname) ) as thirdResponder

                                "
                    )
                    )->first();

                $user->third_responder_interval_time = $third_responder->interval_time;

                $response[] = $user;

            }


        }

        if (sizeof($fourth_responders) > 0) {


            foreach ($fourth_responders as $fourth_responder) {

                $user = \DB::table('users')
                    ->where('id','=',$fourth_responder->user->id)
                    ->select(\DB::raw(
                        "
                                id,
                                (select CONCAT(name, ' ',surname) ) as fourthResponder

                                "
                    )
                    )->first();

                $user->fourth_responder_interval_time = $fourth_responder->interval_time;

                $response[] = $user;

            }


        }

        return $response;




    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function subSubResponder($id)
    {

        $firstRespondersObj  = CaseResponder::where("sub_sub_category",'=',$id)
            ->select('first_responder')->first();

        $secondRespondersObj = CaseResponder::where("sub_sub_category",'=',$id)
            ->select('second_responder')->first();

        $thirdRespondersObj  = CaseResponder::where("sub_sub_category",'=',$id)
            ->select('third_responder')->first();

        $response            = array();

        if (sizeof($firstRespondersObj) > 0) {
            $firstResponders  = explode(",",$firstRespondersObj->first_responder);

            if ($firstRespondersObj->first_responder > 0) {

                foreach ($firstResponders as $firstResponder) {

                    $user = \DB::table('users')
                        ->where('id','=',$firstResponder)
                        ->select(\DB::raw(
                            "
                                                    id,
                                                    (select CONCAT(name, ' ',surname) ) as firstResponder

                                                    "
                        )
                        )->first();

                    $response[] = $user;

                }

            }

        }

        if (sizeof($secondRespondersObj) > 0) {

            $secondResponders = explode(",",$secondRespondersObj->second_responder);

            if ($secondRespondersObj->second_responder > 0) {

                foreach ($secondResponders as $secondResponder) {

                    $user = \DB::table('users')
                        ->where('id','=',$secondResponder)
                        ->select(\DB::raw(
                            "
                                            id,
                                            (select CONCAT(name, ' ',surname) ) as secondResponder

                                            "
                        )
                        )->first();

                    $response[] = $user;

                }

            }

        }

        if (sizeof($thirdRespondersObj) > 0) {

            $thirdResponders  = explode(",",$thirdRespondersObj->third_responder);

            if ($thirdRespondersObj->third_responder > 0) {

                foreach ($thirdResponders as $thirdResponder) {

                    $user = \DB::table('users')
                        ->where('id','=',$thirdResponder)
                        ->select(\DB::raw(
                            "
                                            id,
                                            (select CONCAT(name, ' ',surname) ) as thirdResponder

                                            "
                        )
                        )->first();

                    $response[] = $user;

                }

            }

        }

        return $response;


    }




}
