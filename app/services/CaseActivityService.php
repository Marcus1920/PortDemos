<?php
namespace App\services;
use App\CaseActivity;

class CaseActivityService
{

    public  function get_cases_with_no_activities(){

        $cases = CaseActivity::all();
    }

    public function get_last_activity_by_case_and_user($case_id,$user_id){

        $case_activity = CaseActivity::where('case_id',$case_id)->where('user',$user_id)->first();
        return $case_activity;
    }

    public function get_last_activity_by_case($case_id){

        $case_activity = CaseActivity::where('case_id',$case_id)->first();
        return $case_activity;
    }

}