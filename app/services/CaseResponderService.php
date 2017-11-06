<?php


namespace App\services;

use App\CaseResponder;
class CaseResponderService
{


    public function get_responders_by_sub_case_type($sub_case_type,$responder_type){


    if($responder_type == 0) {

        $data  = CaseResponder::with('responderTypeFunc')->with('user')->where('case_sub_type','=',$sub_case_type)
            ->where('case_sub_sub_type','=',0)
            ->get();
    } else {

        $data  = CaseResponder::with('responderTypeFunc')->with('user')->where('case_sub_type','=',$sub_case_type)
            ->where('case_sub_sub_type','=',0)->where('responder_type',$responder_type)
            ->get();


    }

    return $data;

}

    public function get_responders_by_case_type($case_type,$responder_type){


        if($responder_type == 0) {

            $data  = CaseResponder::with('responderTypeFunc')->with('user')->where('case_type','=',$case_type)
                      ->get();
        } else {

            $data  = CaseResponder::with('responderTypeFunc')->with('user')->where('case_type','=',$case_type)
                       ->where('responder_type',$responder_type)
                       ->get();

        }

        return $data;

    }



    public function get_responders_by_sub_case_type_and_by_responder($user,$sub_case_type){


        $data  = CaseResponder::with('responderTypeFunc')->with('user')->where('case_sub_type','=',$sub_case_type)
            ->where('case_sub_sub_type','=',0)->where('responder',$user)
            ->first();

        return $data;


    }


    public  function send_coms_to_responders($case,$responders) {


        foreach($responders as $responder){

            $user = $responder->user;

            $data = array(
                'name'         => $user->name,
                'caseID'       => $case->id,
                'caseDesc'     => $case->description,
                'caseReporter' => $case->description,
                'intervalTime' => $responder->interval_time
            );

            \Mail::send('emails.firstNotification',$data, function($message) use ($user) {
                $message->from('info@siyaleader.net', 'Siyaleader');
                $message->to($user->email)->subject("Siyaleader Notification - New Case Notification:");

            });

        }


    }

    public  function get_case_responders($case_sub_type,$responder_type){

        $data  = CaseResponder::with('responderTypeFunc')->with('user')->where('case_sub_type','=',$case_sub_type)
            ->where('case_sub_sub_type','=',0)->where('responder_type',$responder_type)
            ->get();

        return $data;

    }

    public function responder_exist($case_type,$case_sub_type,$responder){

        $response      = true;
        $responder     = CaseResponder::where('case_type',$case_type)->where('case_sub_type',$case_sub_type)->where('responder',$responder)->first();
        if (is_null($responder)){

            $response      = false;

        }

        return $response;

    }

    public function responder_cat_exist($case_type,$responder){

        $response      = true;
        $responder     = CaseResponder::where('case_type',$case_type)->where('responder',$responder)->first();
        if (is_null($responder)){

            $response      = false;

        }

        return $response;

    }



    public function send_comms_to_first_responders($case,$first_responders){

        $this->send_coms_to_responders($case,$first_responders);


    }

    public function send_com($user,$case){


         $data = array(
                'name'         => $user->name,
                'caseID'       => $case->id,
                'caseDesc'     => $case->description,
                'caseReporter' => $case->description,
                'intervalTime' => 0
            );


        \Mail::send('emails.firstNotification',$data, function($message) use ($user) {
                $message->from('info@siyaleader.net', 'Siyaleader');
                $message->to($user->email)->subject("Siyaleader Notification - New Case Notification:");

        });

    }





}