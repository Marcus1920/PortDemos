<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Report;
//use App\DepartmentCategory;
//use App\Department;
//use App\DepartmentSubCategory;
//use App\DepartmentSubSubCategory;
use App\Department;
use App\CaseType;
use App\CaseSubType;
use App\User;
use DB;
use App\Allocate_mobs;
use App\CaseReport;
use App\CaseResponder;
use App\CaseOwner;
use App\CasePriority;
use App\CaseStatus;
use App\UserNew;
use DateTime;
use App\CaseNote ;
use  App\CaseActivity;
use  App\Student_pancak_books;
use  App\CaseEscalator ;

use App\UserReportdetails;

class ReportCController extends Controller
{


    private $report;


    public function __construct(Report $report)
    {

        $this->report = $report;

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $reports  = $this->report->get();

        return $reports;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function statuss()
    {
$CaseStatus  =  CaseStatus::all();
 return \Response::json($CaseStatus,200);
//return json_encode($CaseStatus);
    }


	 public  function   closeIncidentmobile(){
		 $response = array  () ;
		 $ID_id   = \Input::get('ID_id');

		 $api_key   = \Input::get('api_key');

		 if($api_key){

			  $userNew = UserNew::where('api_key','=',$api_key)->first();

             if(sizeof($userNew) > 0) {

		      $closeincident           = CaseReport::where('id' ,'=',$ID_id)->first();
		      $closeincident ->Status  =  3;
		  $closeincident ->save () ;
		  $response['message'] = 'Incident close';
          $response['case_id']=$closeincident->id;
		   $response['status']=$closeincident->Status;
          $response['error']   = false; // error must be false here otherwise consumer might think there was some error
          return \Response::json($response,200);

			 }
		 }

		 else  {
	     $response['message'] = 'No key  found ';
         $response['error']   = true; // error must be false here otherwise consumer might think there was some error
         return \Response::json($response,200);

		 }

	 }



// Function for resizing jpg, gif, or png image files
public function ak_img_resize($target, $newcopy, $w, $h, $ext)
{ list($w_orig, $h_orig) = getimagesize($target); $scale_ratio = $w_orig / $h_orig; if (($w / $h) > $scale_ratio) { $w = $h * $scale_ratio; } else { $h = $w / $scale_ratio; } $img = ""; $ext = strtolower($ext); if ($ext == "gif"){ $img = imagecreatefromgif($target); } else if($ext =="png"){ $img = imagecreatefrompng($target); } else { $img = imagecreatefromjpeg($target); } $tci = imagecreatetruecolor($w, $h); // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig); imagejpeg($tci, $newcopy, 80); }


public function  CaseReportjs(){
	$cases =  CaseReport::all()   ;
	//$cases    = CaseReport::select('id','nuberof_person_involve', 'name_person_involve', 'color','surname_person_involve','phone_person_involve' ,'email_person_involve' , 'description' , 'gps_lat','gps_lng' ,'img_url','category','sub_category','sub_sub_category','name_pain','cell_pain','addressHotel_pain','numberOfpeople_pain')->get();

	 return \Response::json($cases,201);

}

public function  CaseReportjss(){


	   $myReports = \DB::table('cases')
                ->leftjoin('departments', 'cases.department', '=', 'departments.id')
                ->join('categories', 'cases.category', '=', 'categories.id')
                ->join('sub_categories', 'cases.sub_category', '=', 'sub_categories.id')
                ->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
                //->join('cases_priorities', 'cases.priority', '=', 'cases_priorities.id')
                ->leftjoin('sub_sub_categories', 'cases.sub_sub_category', '=', 'sub_sub_categories.id')
                ->join('users', 'cases.user', '=', 'users.id')
              //  ->where('cases.user','=',$user->id)
                ->select(\DB::raw("cases.id ,cases.description ,cases.user ,cases.department,
				       cases.province ,cases.ref_no,cases.district,cases.municipality,cases.ward ,cases_statuses.id as status ,cases_statuses.name as status,
			cases.addressbook,cases.reporter,cases.severity,cases.busy,cases.accepted_at,cases.referred_at  ,
			cases.escalated_at,cases.source,cases.location,cases.gps_lat,cases.gps_lng ,

	cases.resolved_at ,cases.closed_at,cases.active,cases.created_at,cases.updated_at,cases.gps_lng ,cases.gps_lng ,cases.img_url
 ,cases.agent,cases.house_holder_id,cases.case_type,cases.case_sub_type,cases.saps_case_number,
 cases.client_reference_number ,cases.allocated_at  ,cases.email_person_involve ,cases.actiontaken , cases.nuberof_person_involve ,
	cases.name_person_involve,cases.phone_person_involve,cases.cell_pain,cases.incident_date_time,cases.color,cases.img_url,
categories.name as category, categories.id as category_id,`sub_categories`.name as sub_category,
`sub_categories`.id as sub_category_id, `sub_sub_categories`.name as sub_sub_category,
`sub_sub_categories`.id as sub_sub_category_id ,cases.name_pain,cases.addressHotel_pain,cases.numberOfpeople_pain,cases.incident_date_time,cases.cases_type"))
               ->get();
				 return \Response::json($myReports,201);



}


    public function store(Report $report, Request $request)
    {



        \Log::info("Request ".$request);

         \Log::info("Request ".$request);
         $category         = \Input::get('category');
         \Log::info('GET Category ' .$category);
         $sub_category     = \Input::get('sub_category');
         \Log::info('GET Sub Category ' .$sub_category);
         $sub_sub_category = \Input::get('sub_sub_category');
         \Log::info('GET Sub Sub Category ' .$sub_sub_category);
         $sub_sub_category = (empty($sub_sub_category))? " " : $sub_sub_category;
         $description      = \Input::get('description');
         \Log::info('Get Description :'.$description);
         $description      = (empty($description))? " " : $description;
         $gps_lat          = \Input::get('gps_lat');
         \Log::info('GPS Lat :' .$gps_lat);
         $gps_lng          = \Input::get('gps_lng');
         \Log::info('GPS Lng :' .$gps_lng);
         $user_email       = \Input::get('user_email');
         \Log::info('Email :' .$user_email);
         $priority         = \Input::get('priorities');
         $priority         = (empty($priority))? 1 : $priority;
         \Log::info('Priority :' .$priority);
         $headers          = apache_request_headers();
         $response         = array();

        \Log::info("Request ".$request);
        if (count($_FILES) > 0) {

            $files = $_FILES['img'];
            $name  = uniqid('img-'.date('Ymd').'-');
            $temp  = explode(".",$files['name']);
            $name  = $name . '.'.end($temp);


            if (file_exists("uploads/".$name))
            {
                echo $_FILES["img"]["name"]."already exists. ";
            }
            else
            {

                $img_url      = "uploads/".$name;
                $target_file  = "uploads/$name";
                $resized_file = "uploads/$name";
                $wmax         = 600;
                $hmax         = 480;
                $fileExt      = 'jpg';

                if(move_uploaded_file($_FILES["img"]["tmp_name"],$img_url))
                {

                     $this->ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);

                }

            }
        }


       $img_url = isset($img_url)? $img_url : "uploads/noimage.png";


        if (isset($headers['api_key'])) {


              $userNew = UserNew::where('api_key','=',$headers['api_key'])->first();

             if(sizeof($userNew) > 0) {


                 $objCat                           = CaseType::where('name','=',$category)->first();
                 \Log::info('Category Object :'.$objCat);

                 $objSubCat                        = CaseSubType::where('name','=',$sub_category)->first();
                 $SubCatName                       = (sizeof($objSubCat) > 0)? $objSubCat->name : "";



                 $objPriority            = CasePriority::where('name','=',$priority)->first();
                 $priority               = (sizeof($objPriority) == 0)? 1 : $objPriority->id;

                 $case                   = New CaseReport();
                 $case->description      = $description;
                 $case->user             = $userNew->id;
                 $case->reporter         = $userNew->id;
                 $case->department       = $objCat->department;
                 $case->case_type        = $objCat->id;
                 $case->province         = $userNew->province;
                 $case->district         = $userNew->district;
                 $case->municipality     = $userNew->municipality;
                 $case->ward             = $userNew->ward;
                 $case->area             = $userNew->area;
                 $case->priority         = $priority;
                 $case->status           = 1; //Pending
                 $case->gps_lat          = $gps_lat;
                 $case->img_url          = $img_url;
                 $case->gps_lng          = $gps_lng;
                 $case->source           = 2; //Mobile
                 $case->save();


                 $caseOwner              = new CaseOwner();
                 $caseOwner->user        = $userNew->id;
                 $caseOwner->case_id     = $case->id;
                 $caseOwner->type        = 0;
                 $caseOwner->active      = 1;
                 $caseOwner->save();

                 $response["message"]          = "Report created successfully";
                 $response['error']            = FALSE;



                $data = array(

                    'name'      =>$userNew->name,
                    'caseID'    =>$case->id,
                    'caseDesc'  =>$case->description
                );


/*
                \Mail::send('emails.sms',$data, function($message) use ($userNew) {

                    $message->from('info@siyaleader.com', 'siyaleader');
                    $message->to($userNew->email)->subject("Port  Notification - New Case Reported:");

                });

*/


//  Email  configuration   on  the  serve  need  to  execute  this  code

          /*      if (is_object($objSubSubCat)) {

                    $firstRespondersObj  = CaseResponder::where("sub_sub_category",'=',$objSubSubCat->id)
                                                ->select('first_responder')->first();

                    if (sizeof($firstRespondersObj) > 0) {


                        $case->status      = 4;
                        $case->referred_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                        $case->save();

                        $firstResponders  = explode(",",$firstRespondersObj->first_responder);

                        if($firstRespondersObj->first_responder > 0) {

                            foreach ($firstResponders as $firstResponder) {


                                $firstResponderUser = UserNew::find($firstResponder);
                                $caseOwner          = new CaseOwner();
                                $caseOwner->user    = $firstResponder ;
                                $caseOwner->case_id = $case->id;
                                $caseOwner->type    = 1;
                                $caseOwner->active  = 1;
                                $caseOwner->save();

                                 $data = array(
                                        'name'   =>$firstResponderUser->name,
                                        'caseID' =>$case->id,
                                        'caseDesc' => $case->description,
                                        'caseReporter' => $case->description,
                                    );

                                \Mail::send('emails.responder',$data, function($message) use ($firstResponderUser) {

                                    $message->from('info@redfrogs.net', 'Redfrogs');
                                    $message->to($firstResponderUser->email)->subject("Redfrogs Notification - New Case Reported:");

                                });

                                $cellphone = $firstResponderUser->email;

                                \Mail::send('emails.caseEscalatedSMS',$data, function($message) use ($cellphone)
                                {
                                    $message->from('redfrogs.net', 'redfrogs');
                                    $message->to('cooluma@siyaleader.net')->subject("REFER: $cellphone" );

                                });



                            }


                        }
                    }

                }   */




            /*    if (sizeof($objSubCat) > 0 && $objSubSubCat == "") {



                     $allObjSubCats  = SubCategory::where('name','=',$sub_category)->get();
                     \Log::info(sizeof($allObjSubCats));
                     \Log::info($allObjSubCats);


                     foreach ($allObjSubCats as $value) {


                        $firstRespondersObj  = CaseResponder::where("sub_category",'=',$value->id)
                                                ->select('first_responder')->first();

                        if (sizeof($firstRespondersObj) > 0) {

                            $case->status = 4;
                            $case->referred_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                            $case->save();

                            $firstResponders  = explode(",",$firstRespondersObj->first_responder);

                            if($firstRespondersObj->first_responder > 0) {

                                foreach ($firstResponders as $firstResponder) {


                                        $firstResponderUser = UserNew::find($firstResponder);
                                        $caseOwner          = new CaseOwner();
                                        $caseOwner->user    = $firstResponder ;
                                        $caseOwner->case_id = $case->id;
                                        $caseOwner->type    = 1;
                                        $caseOwner->active  = 1;
                                        $caseOwner->save();

                                         $data = array(
                                                'name'          =>$firstResponderUser->name,
                                                'caseID'        =>$case->id,
                                                'caseDesc'      =>$case->description,
                                                'caseReporter'  =>$case->description,
                                            );

                                        \Mail::send('emails.responder',$data, function($message) use ($firstResponderUser) {
                                            $message->from('info@ecin.net', 'Ecin');
                                            $message->to($firstResponderUser->email)->subject("Ecin Notification - New Case Reported:");

                                        });

                                        $cellphone = $firstResponderUser->cellphone;

                                       \Mail::send('emails.caseEscalatedSMS',$data, function($message) use ($cellphone)
                                        {
                                            $message->from('info@ecin.net', 'Ecin');
                                            $message->to('cooluma@ecin.net')->subject("REFER: $cellphone" );

                                        });

                                }



                            }
                        }


                    }


                } */

                return \Response::json($response,201);
             }

             else
             {

                $response['message'] = 'Access Denied. Ensure that all fields are correctly filled in';
                $response['error']   = TRUE;
                return \Response::json($response,401);

             }

        }
        else
        {
             $response['message'] = 'Access Denied. Invalid Api key';
             $response['error']   = TRUE;
             return \Response::json($response,401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */


	 // accept  case   from   mobile
	 public  function   acceptedcaseMoblie  () {


		 $case_id   =    \Input::get('id');
		 $api_key   =   \Input::get('api_key');

		  $id   = CaseReport::select('id')->where('id','=',$case_id )->first();

		// dd($case_id . "   " .  $api_key ) ;

		 $cases  =  CaseReport::where('id','=',$case_id )->first();

          $cases->status = 4 ;
          $cases->save() ;

		 return  "ok" ;

	 }


	  // dicline    case   from   mobile
	 public  function   declinseMoblie  () {



		    $case_id   =    \Input::get('id');
		    $api_key   =   \Input::get('api_key');

		  $id   = CaseReport::select('id')->where('id','=',$case_id )->first();

		// dd($case_id . "   " .  $api_key ) ;

		  $cases  =  CaseReport::where('id','=',$case_id )->first();

          $cases->status = 1 ;
          $cases->save() ;


		  $CaseEscalator  =   CaseEscalator::where('case_id' , '=' , $case_id)->first() ;

		  $CaseEscalator->delete() ;

		 return  "ok" ;
	 }




	 //request   closoer  of   the  case

	 public   function    requestcloser  (){



	     $response   =  array()  ;
	     $api_key      = \Input::get('api_key');
         $case_id      = \Input::get('id');

		 $not     = \Input::get('note');






	   if ( $not==null){

		  $use_id  = UserNew::select('id')->where('api_key','=',$api_key)->first();
		  $cases  =  CaseReport::where('id','=',$case_id )->first();
          $cases->save() ;


		  return "ok" ;

	  } else {
          $use_id  = UserNew::select('id')->where('api_key','=',$api_key)->first();
		      $cases  =  CaseReport::where('id','=',$case_id )->first();
          $cases->status = 2;
          $cases->save() ;





        $caseOwners = CaseOwner::where('case_id','=',$use_id->id)->get();
        $author     = User::find($use_id->id);

        $caseNote         = new CaseNote();
        $caseNote->note   = $not  ;
        $caseNote->user   =  $use_id->id;
        $caseNote->case_id = $case_id;
        $caseNote->save();

        $caseActivity              = New CaseActivity();
        $caseActivity->case_id     =$case_id;
        $caseActivity->user        = $use_id->id;
        $caseActivity->addressbook = 0;
        $caseActivity->note        = "New Case Noted Added by ".$author->name ." ".$author->surname;
        $caseActivity->save();


       $CaseEscalator = CaseEscalator::where('case_id' , '=' , $case_id)->first() ;
       $CaseEscalator->delete() ;

        foreach ($caseOwners as $caseOwner) {

            $user = User::find($caseOwner->user);

            $data = array(
                            'name'     => $user->name,
                            'caseID'   => $case_id,
                            'caseNote' => $not ,
                            'author'   => $author->name .' '.$author->surname
                        );

            \Mail::send('casenotes.email',$data, function($message) use ($user)
            {
                $message->from('info@siyaleader.net', 'Siyaleader');
                $message->to($user->email)->subject("Siyaleader Notification - New Case Note: ");

            });




        }

		$response['msg'] = "case  secefully  update";

	    return \Response::json($response,201);

		  }



		// return  "ok" ;


}

	 // update  case  from  mobile   test
public   function   updatecasemobile  (){



	     $response   =  array()  ;
	     $api_key      = \Input::get('api_key');
         $case_id      = \Input::get('id');

		 $not   =    \Input::get('note');

          $use_id  = UserNew::select('id')->where('api_key','=',$api_key)->first();
	     $cases  =  CaseReport::where('id','=',$case_id )->first();
          $cases->status = 4 ;
         $cases->save() ;





        $caseOwners = CaseOwner::where('case_id','=',$use_id->id)->get();
        $author     = User::find($use_id->id);

        $caseNote         = new CaseNote();
        $caseNote->note   = $not  ;
        $caseNote->user   =  $use_id->id;
        $caseNote->case_id = $case_id;
        $caseNote->save();

        $caseActivity              = New CaseActivity();
        $caseActivity->case_id     =$case_id;
        $caseActivity->user        = $use_id->id;
        $caseActivity->addressbook = 0;
        $caseActivity->note        = "New Case Noted Added by ".$author->name ." ".$author->surname;
        $caseActivity->save();



        foreach ($caseOwners as $caseOwner) {

            $user = User::find($caseOwner->user);

            $data = array(
                            'name'     => $user->name,
                            'caseID'   => $case_id,
                            'caseNote' => $not ,
                            'author'   => $author->name .' '.$author->surname
                        );

            \Mail::send('casenotes.email',$data, function($message) use ($user)
            {
                $message->from('info@siyaleader.net', 'Siyaleader');
                $message->to($user->email)->subject("Siyaleader Notification - New Case Note: ");

            });

        }

		$response['msg'] = "case  secefully  update";

	    return \Response::json($response,201);
}



	 public  function   refercase (Request   $request){



		   $response = array();
		  \Log::info("api_key".$request);

		    $headers          = apache_request_headers();

               $api_key     =  \Input::get('api_key');


        if ($api_key ) {


    $user  = UserNew::where('api_key','=',$api_key )->first();
    $to_id    =  \DB::table('cases_escalations')
	->select('to')
	->where('to','=',$user->id)->first();

	// $data   = 	 array('events' => $events);
	 /// $dd =  json_encode($events);
	//  $array = json_decode($dd );


   #or first convert it and then change its properties using
   #an array syntax, it's up to you


           if(sizeof($user) > 0)
             {


                 $myReports = \DB::table('cases_escalations')

                ->join('categories', 'cases_escalations.category', '=', 'categories.id')
                ->join('sub_categories', 'cases_escalations.sub_category', '=', 'sub_categories.id')
                ->join('cases_statuses', 'cases_escalations.status', '=', 'cases_statuses.id')
                  ->join('departments', 'cases_escalations.department', '=', 'departments.id')
              //  ->leftjoin('sub_sub_categories', 'cases.sub_sub_category', '=', 'sub_sub_categories.id')

                ->where('cases_escalations.to','=',$to_id->to )


                ->select(\DB::raw("
				cases_escalations.id,
				cases_escalations.case_id,
				cases_escalations.created_at,
				departments.name as department ,
			    categories.name as category,
				sub_categories.name as sub_category,
				cases_escalations.description,
				cases_statuses.name as status


				"))
                ->get();

                $response["error"]   = FALSE;
                $response["reports"] = $myReports;
                return \Response::json($response,201);
			 }















	   //dd($events->case_id);


		}



	 }



	 // refercase

	      public function  referemyrepor(Report $report)
    {

         $response = array();
         $api_key         = \Input::get('api_key');


        if ($api_key ) {


             $user  = UserNew::where('api_key','=',$api_key )->first();

			 $user  = User::where('api_key','=',$api_key )->first();



    $to_id    =  \DB::table('cases_activities')
	->select('to')
	->where('to','=',$user->id)->first();




             if(sizeof($user) > 0)
             {


                 $myReports = \DB::table('cases_activities')

               ->join('categories', 'cases_activities.category', '=', 'categories.id')
                ->join('sub_categories', 'cases_activities.sub_category', '=', 'sub_categories.id')
                ->join('cases_statuses', 'cases_activities.status', '=', 'cases_statuses.id')
                ->join('departments', 'cases_activities.department', '=', 'departments.id')

			    ->where('cases_activities.to','=',$to_id->to)

                ->select(\DB::raw("
				cases_activities.case_id,
				cases_activities.id,
				cases_activities.to,
				cases_activities.created_at,
				cases_statuses.name as status,
				categories.name as category,
				sub_categories.name as sub_category,
				departments.name as department,
				cases_activities.description



				"))
                ->get();

                $response["error"]   = FALSE;
                $response["reports"] = $myReports;
                return \Response::json($response,201);
             }
             else {

                $response['message'] = 'Access Denied. Invalid Api key';;
                $response['error']   = TRUE;
                return \Response::json($response,401);
             }
        }
        else
        {
            $response['message'] = 'Access Denied. Invalid Api key';;
            $response['error']   = TRUE;
            return \Response::json($response,401);
        }
    }





	 //end
	 // functuion  get  all  the  user
	 public function  getallusers(Report $report)
    {



                 $myReports = \DB::table('users')


				//->where('cases.status','=',1)
                ->select(\DB::raw("
				users.id,
				users.name,
				users.surname,
				users.email,
				users.cellphone


				"))
                ->get();


                $response["error"]   = FALSE;
                $response["reports"] = $myReports;
                return \Response::json($response,201);



    }




	     public function  internalmyrepor(Report $report)
    {

         $response = array();
       $api_key         = \Input::get('api_key');


        if ($api_key ) {


             $user  = UserNew::where('api_key','=',$api_key )->first();

             if(sizeof($user) > 0)
             {








                 $myReports = \DB::table('cases')

               ->join('categories', 'cases.category', '=', 'categories.id')
                ->join('sub_categories', 'cases.sub_category', '=', 'sub_categories.id')
                ->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
               ->join('departments', 'cases.department', '=', 'departments.id')
              //  ->leftjoin('sub_sub_categories', 'cases.sub_sub_category', '=', 'sub_sub_categories.id')
                ->join('users', 'cases.user', '=', 'users.id')
                ->where('cases.user','=',$user->id)
				->where('cases.status','=',1)
                ->select(\DB::raw("
				cases.id,
				cases.created_at,
				cases_statuses.name as status,
				departments.name as department,
				categories.name as category,
				sub_categories.name as sub_category,
				cases.description


				"))
                ->get();


                $response["error"]   = FALSE;
                $response["reports"] = $myReports;
                return \Response::json($response,201);
             }
             else {

                $response['message'] = 'Access Denied. Invalid Api key';;
                $response['error']   = TRUE;
                return \Response::json($response,401);
             }
        }
        else
        {
            $response['message'] = 'Access Denied. Invalid Api key';;
            $response['error']   = TRUE;
            return \Response::json($response,401);
        }
    }





    public function myReport(Report $report , Request $request)
    {

         $response = array();



		  \Log::info("api_key".$request);
           $api_key         = \Input::get('api_key');
          $user_id     = UserNew::where('api_key' , '=' , $api_key )->first();

           $status ;

        if ($api_key) {


         if ($status=4 && $status=1){

           $user    = UserNew::where('api_key' , '=' ,$api_key )->first();

	///	  $user->id);
		 // dd($user->id);


             if(sizeof($user) > 0)
             {



                 $myReports = \DB::table('cases')

                ->join('cases_types', 'cases.case_type', '=', 'cases_types.id')
            //    ->join('sub_categories', 'cases.sub_category', '=', 'sub_categories.id')
                ->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
                ->join('cases_priorities', 'cases.priority', '=', 'cases_priorities.id')
              //  ->leftjoin('sub_sub_categories', 'cases.sub_sub_category', '=', 'sub_sub_categories.id')
                ->join('users', 'cases.user', '=', 'users.id')
                ->where('cases.user','=',$user->id)
			//	->where('cases.status','=',1)


          ->select(\DB::raw("
        cases.id ,
        cases.created_at ,
				cases_statuses.name as status,
				cases.description,

				cases.img_url,
        cases_priorities.name  as  priority ,
				cases_types.name as category


				"))
               ->groupBy('cases.created_at')->get();







                $response["error"]   = FALSE;
                $response["reports"] = $myReports;


				//$response["alloctereports"] = $AllocateReports;

			//	AllocateReports
                return \Response::json($response,200);

			 }
          }  elseif($status=7){


			if(sizeof($user) > 0)
             {

                 $myReports = \DB::table('cases')
                ->leftjoin('departments', 'cases.department', '=', 'departments.id')
                ->join('cases_types', 'cases.case_type', '=', 'cases_types.id')
                ->join('cases_sub_types', 'cases.case_sub_type', '=', 'cases_sub_types.id')
                ->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
                ->join('users', 'cases.user', '=', 'users.id')
                ->where('cases.user','=',$user->id)
				->where('cases.status', '=' ,7)
                ->select(\DB::raw("cases.id ,cases_statuses.name as status,cases.description,cases.location,cases.gps_lat ,cases.gps_lng ,cases.actiontaken , cases.nuberof_person_involve ,cases.name_person_involve,cases.surname_person_involve ,cases.phone_person_involve,cases.email_person_involve,cases.incident_date_time,cases.img_url,cases_types.name as category,cases_types.id as category_id,`cases_sub_types`.name as sub_category,  `cases_sub_types`.id as sub_category_id"))
               ->groupBy('cases.created_at')->get();

                $response["error"]   = FALSE;
                $response["reports"] = $myReports;
                return \Response::json($response,200);

			 }
		  }
             else {

                $response['message'] = 'Access Denied. Invalid Api key';;
                $response['error']   = TRUE;
                return \Response::json($response,401);
             }
        }
        else
        {
            $response['message'] = 'Access Denied. Invalid Api keyss';;
            $response['error']   = TRUE;
            return \Response::json($response,401);
        }



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function saveReportImage(Report $report)
    {
		  $key     ="57ea53e62d40e";
		  $api_key      = UserNew::select('api_key')->where('api_key','=',$key)->first();

         $category         = \Input::get('category');
         $sub_category     = \Input::get('sub_category');
         $sub_sub_category = \Input::get('sub_sub_category');
         $description      = \Input::get('description');
         $gps_lat          = \Input::get('gps_lat');
         $gps_lng          = \Input::get('gps_lng');
         $user_email       = \Input::get('user_email');
         $headers          = apache_request_headers();
         $response         = array();
        // $files            = $_FILES['img'];



         if ($key) {

             $user  = User::where('api_key','=',$key)->first();

             if(sizeof($user) > 0) {

                 $newReport = New Report();
                 $newReport->prob_category    = $category;
                 $newReport->prob_dis         = 'Durban';
                 $newReport->prob_mun         = 'Maydon Wharf';
                 $newReport->Province         = 'KZN';
                 $newReport->status           = 'Pending';
                 $newReport->prob_exp         = $description;
              //   $newReport->img_url          = $img_url;
                 $newReport->ccg_nam          = $user->Fname;
                 $newReport->ccg_sur          = $user->Sname;
                 $newReport->ccg_pos          = $user->Position;
                 $newReport->prob_subcategory = $sub_sub_category['name'];
                 $newReport->GPS              = $gps_lat .', '.$gps_lng;
                 $newReport->gps_lat          = $gps_lat;
                 $newReport->gps_lng          = $gps_lng;
                 $newReport->submit_date      =  \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                 $newReport->user             = $user->ID;
                 $newReport->source           = 'M';
                 $newReport->save();
                 $response["message"]         = "Report created successfully";
                 $response['error']           = FALSE;
                 return \Response::json($response,201);
             }

             else
             {

                $response['message'] = 'Access Denied. Invalid Api keys';;
                $response['error']   = TRUE;
                return \Response::json($response,401);

             }

        }
        else
        {
             $response['message'] = 'Access Denied. Invalid Api keyss';;
             $response['error']   = TRUE;
             return \Response::json($response,401);
        }


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

	  public function creatReport(Request $request)
    {


           $key         = \Input::get('api_key');
		   $ref_number        = \Input::get('ref_no');
		   $ID_id    = \Input::get('ID_id');

		   if($key){





		//$key     ="57ea53e62d40e";
		  $api_key      = UserNew::select('api_key')->where('api_key','=',$key)->first();





		\Log::info("cases_type".$request);
         $cases_type         = \Input::get('cases_type');

		\Log::info("incident_date_time".$request);
         $incident_date_time         = \Input::get('incident_date_time');



		\Log::info("actiontaken".$request);
         $actiontaken         = \Input::get('actiontaken');


		 \Log::info("location".$request);
         $location         = \Input::get('location');

       \Log::info("name_pain".$request);


         $name_pain         = \Input::get('name_pain');

		 \Log::info("cell_pain".$request);
         $cell_pain         = \Input::get('cell_pain');

		 \Log::info("addressHotel_pain".$request);
         $addressHotel_pain         = \Input::get('addressHotel_pain');

		 \Log::info("numberOfpeople_pain".$request);
         $numberOfpeople_pain         = \Input::get('numberOfpeople_pain');



	\Log::info("nuberof_person_involve".$request);
         $nuberof_person_involve         = \Input::get('nuberof_person_involve');

		 \Log::info("name_person_involve ".$request);
         $name_person_involve         = \Input::get('name_person_involve');

		  \Log::info("surname_person_involve ".$request);
         $surname_person_involve         = \Input::get('surname_person_involve');

		  \Log::info("phone_person_involve ".$request);
         $phone_person_involve         = \Input::get('phone_person_involve');

		  \Log::info("email_person_involve ".$request);
         $email_person_involve         = \Input::get('email_person_involve');

		  \Log::info("color ".$request);
         $color         = \Input::get('color');


         \Log::info("Request ".$request);
         $category         = \Input::get('category');
         \Log::info('GET Category ' .$category);
         $sub_category     = \Input::get('sub_category');
         \Log::info('GET Sub Category ' .$sub_category);
         $sub_sub_category = \Input::get('sub_sub_category');
         \Log::info('GET Sub Sub Category ' .$sub_sub_category);
         $sub_sub_category = (empty($sub_sub_category))? " " : $sub_sub_category;
         $description      = \Input::get('description');
         \Log::info('Get Description :'.$description);
        // $description      = (empty($description))? " " : $description;
         $gps_lat          = \Input::get('gps_lat');
         \Log::info('GPS Lat :' .$gps_lat);
         $gps_lng          = \Input::get('gps_lng');
         \Log::info('GPS Lng :' .$gps_lng);
         $user_email       = \Input::get('user_email');
         \Log::info('Email :' .$user_email);
         $priority         = \Input::get('priorities');
         $priority         = (empty($priority))? 1 : $priority;
         \Log::info('Priority :' .$priority);
         $headers          = apache_request_headers();
         $response         = array();
		 //  update cases  contion
		 if($ID_id=="")
		 {







		 //pancake  booking
		 if ($category=="" )
		 {

			 if ($key) {


             //  $users  = User::where('api_key','=',$key)->first();
            $userNew = UserNew::select('id')->where('api_key','=',$key)->first();

                $enddate = \Carbon\Carbon::now()->addMinutes(120)->toDateTimeString();
				 $case                   = New CaseReport();
                 $case->description      = "Pancake Booking"."  \r ".
				"Number of peoples  :".$numberOfpeople_pain."  \r "."Hotel  Name: ".$addressHotel_pain.
				 ""."\r".$description;


				 $case->cases_type      = $cases_type;
				 $case->actiontaken      = $actiontaken;

				 $case->location         = $location;
                 $case->user             = $userNew->id;
				 $case->district             = $userNew->district;
                 $case->reporter         = $userNew->id;
				 $case->ref_no           = time();//rand(1000, 9999);



                 $case->category         = 7;
                 $case->sub_category     = 25;
                 $case->sub_sub_category =22;

                 $case->status           = 1; //Pending
                 $case->gps_lat          = $gps_lat;
             //    $case->img_url          = $img_url;
                 $case->gps_lng          = $gps_lng;
                 $case->source           = 2; //Mobile

				$case->nuberof_person_involve   =$numberOfpeople_pain;
				$case->name_person_involve      =$name_pain;
				$case->surname_person_involve   =$surname_person_involve  ;
				$case->phone_person_involve     =$cell_pain  ;
				$case->email_person_involve     =$email_person_involve ;

				$case->incident_date_time       = $incident_date_time  ;


				$case->name_pain                =$name_pain  ;
				$case->cell_pain                =$cell_pain  ;
				$case->addressHotel_pain        =$addressHotel_pain  ;
				$case->numberOfpeople_pain      =$numberOfpeople_pain  ;

			     $case->color        ="#E5C879" ;

				 $case->location         = $location;
                 $case->description      = $description;
                 $case->save();
	// calender  booking

		$dates =$incident_date_time;
       // $result = $date->format('Y-m-d H:i:s');
        $dateTimebook= date('result'  , time()+4680);
       // $dates = \Carbon\Carbon::now()->toDateTimeString();
		$enddate = \Carbon\Carbon::now()->addMinutes(360)->toDateTimeString();

		$Student_pancak_books=  new  Student_pancak_books() ;

        $Student_pancak_books->mobile_number =   $cell_pain;
        $Student_pancak_books->number_of_people =  $numberOfpeople_pain;
        $Student_pancak_books->name_of_person = $name_pain;
        $Student_pancak_books->gps_lat = $gps_lat;
        $Student_pancak_books->gps_lng = $gps_lng;

        $Student_pancak_books->location =  $location;
        $Student_pancak_books->dateTimeBook = $dates;
		$Student_pancak_books->title       ="Pancke Booking :".$name_pain;
		$Student_pancak_books->start       = $dates ;
		$Student_pancak_books-> end         = $enddate ;
		$Student_pancak_books->color       = "#E5C879";
		$Student_pancak_books->resourceId  = $userNew->id;
        $Student_pancak_books->save() ;





                 $caseOwner              = new CaseOwner();
                 $caseOwner->user        = $userNew->id;
                 $caseOwner->case_id     = $case->id;
                 $caseOwner->type        = 0;
                 $caseOwner->active      = 1;
                 $caseOwner->save();

                 //$savedReport  = CaseReport::select('status','ref_no')->where('id', '=' ,$case->id)->first();
                 //$savedReport= CaseReport::where('id','=',$case->id)->first();
                 //$savedReport= CaseReport::where('id',$case->id)->first();

                $savedReport = CaseReport::where('id',$case->id)->first();

//dd($savedReport);


				$response['message'] = 'Incident pancake  succsefuly create';
              //  $response['case'] = $savedReport;
                $response['case_id']=$case->id;
                //$response['error']   = TRUE; // error must be false here otherwise consumer might think there was some error
                $response['error']   = false; // error must be false here otherwise consumer might think there was some error
                return \Response::json($response,200);



			$data = array(

                    'name'      =>$userNew->name,
                    'caseID'    =>$case->id

                );

                \Mail::send('emails.sms',$data, function($message) use ($userNew) {

                    $message->from('info@Redfrogs.net', 'redfrogs');
                    $message->to($userNew->email)->subject("Redfrogs - New Case Reported:");

				  });
		 }
		 }


		 //  end  pancka booking

        \Log::info("Request ".$request);
        if (count($_FILES) > 0) {

            $files = $_FILES['img'];
            $name  = uniqid('img-'.date('Ymd').'-');
            $temp  = explode(".",$files['name']);
            $name  = $name . '.'.end($temp);


            if (file_exists("uploads/".$name))
            {
                echo $_FILES["img"]["name"]."already exists. ";
            }
            else
            {

                $img_url      = "uploads/".$name;
                $target_file  = "uploads/$name";
                $resized_file = "uploads/$name";
                $wmax         = 600;
                $hmax         = 480;
                $fileExt      = 'jpg';

                if(move_uploaded_file($_FILES["img"]["tmp_name"],$img_url))
                {

                     $this->ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);

                }

            }
        }


	 if ($key) {

             $userNew  = User::where('api_key','=',$key)->first();


			     $objCatlor = SubCategory::select('color')->where('name','=',$sub_category)->first();
			     $objCatlors = SubSubCategory::select('color')->where('name','=',$sub_sub_category)->first();
			     $objCatecolr = Category::select('color')->where('name','=',$category)->first();




             if(sizeof($userNew) > 0) {


				  $objCat                           = Category::where('name','=',$category)->first();

                 \Log::info('Category Object :'.$objCat);

                $objSubCat                          = SubCategory::where('name','=',$sub_category)->first();


		//	$objSubCat 	= DB::table('sub_categories')->where('name','=','Relationship-Issues')->first();




                 $SubCatName                       = (sizeof($objSubCat) > 0)? $objSubCat->name : "";

                 if(strlen($sub_sub_category) > 1) {

                     $objSubSubCat =SubSubCategory::where('name','=',$sub_sub_category)->first();

                     $objSubSub    = $objSubSubCat->id;

                 }
                 else {

                     $objSubSubCat = 0;
                     $objSubSub    = 0;
                 }

                 $objPriority            = CasePriority::where('name','=',$priority)->first();
                 $priority               = (sizeof($objPriority) == 0)? 1 : $objPriority->id;



		        $colors  = "";
                if($objCatlors==null)
              	{
						 $colors = $objCatecolr->color;
					//dd($objCatecolr->color);
				}

			      elseif($objCatlors==null)
				 {

				 $colors = $objCatlor->color;
				 }
				 else{

				// dd($objCatlor->color);

				 $colors = $objCatlors->color;

				 }

				//  dd($objCat ->id);
				 $case                   = New CaseReport();
				 $case->location         = $location;
                 $case->description      = $description;
				 $case->cases_type      = $cases_type;
				 $case->actiontaken      = $actiontaken;
				 $case->ref_no           = time();
				 $case->district         = $userNew->district;
                 $case->user             = $userNew->id;
                 $case->reporter         = $userNew->id;
				 $case->ref_no           = time();//rand(1000, 9999);


                 $case->category         = $objCat ->id;

                 $case->sub_category     = $objSubCat->id;

                 $case->sub_sub_category = $objSubSub;


                 $case->status           = 1; //Pending
                 $case->gps_lat          = $gps_lat;
             //    $case->img_url          = $img_url;
                 $case->gps_lng          = $gps_lng;
                 $case->source           = 2; //Mobile

				$case->nuberof_person_involve   =$nuberof_person_involve;
				$case->name_person_involve      =$name_person_involve;
				$case->surname_person_involve   =$surname_person_involve  ;
				$case->phone_person_involve     =$phone_person_involve  ;
				$case->email_person_involve     =$email_person_involve ;
				$case->color                    = $colors  ;
				$case->incident_date_time       = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();


				$case->name_pain                =$name_pain  ;
				$case->cell_pain                =$cell_pain  ;
				$case->addressHotel_pain        =$addressHotel_pain  ;
				$case->numberOfpeople_pain      =$numberOfpeople_pain  ;


                 $case->save();

                 $caseOwner              = new CaseOwner();
                 $caseOwner->user        = $userNew->id;
                 $caseOwner->case_id     = $case->id;
                 $caseOwner->type        = 0;
                 $caseOwner->active      = 1;
                 $caseOwner->save();

               $savedReport = CaseReport::where('id',$case->id)->first();

			  // dd($savedReport);

				$response['message'] = 'Incident   succsefuly create   ';
                //$response['error']   = TRUE; //error must be false here
              //  $response['case']=$savedReport;
                $response['case_id']=$case->id;
                $response['error']=false;

                return \Response::json($response,200);



			$data = array(

                    'name'      =>$userNew->name,
                    'caseID'    =>$case->id,
                    'caseDesc'  =>$case->description
                );

                \Mail::send('emails.sms',$data, function($message) use ($userNew) {

                    $message->from('info@redfrogs.net', 'redfrogs');
                    $message->to($userNew->email)->subject("redfrogs Notification - New Case Reported:");

                });




                if (is_object($objSubSubCat)) {

                    $firstRespondersObj  = CaseResponder::where("sub_sub_category",'=',$objSubSubCat->id)
                                                ->select('first_responder')->first();

                    if (sizeof($firstRespondersObj) > 0) {


                        $case->status      = 4;
                        $case->referred_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                        $case->save();

                        $firstResponders  = explode(",",$firstRespondersObj->first_responder);

                        if($firstRespondersObj->first_responder > 0) {

                            foreach ($firstResponders as $firstResponder) {


                                $firstResponderUser = UserNew::find($firstResponder);
                                $caseOwner          = new CaseOwner();
                                $caseOwner->user    = $firstResponder ;
                                $caseOwner->case_id = $case->id;
                                $caseOwner->type    = 1;
                                $caseOwner->active  = 1;
                                $caseOwner->save();

                                 $data = array(
                                        'name'   =>$firstResponderUser->name,
                                        'caseID' =>$case->id,
                                        'caseDesc' => $case->description,
                                        'caseReporter' => $case->description,
                                    );

                                \Mail::send('emails.responder',$data, function($message) use ($firstResponderUser) {

                                    $message->from('redfrogs.net', 'Redfrohs');
                                    $message->to($firstResponderUser->email)->subject("Redfrogs Notification - New Case Reported:");

                                });

                                $cellphone = $firstResponderUser->email;

                                \Mail::send('emails.caseEscalatedSMS',$data, function($message) use ($cellphone)
                                {
                                    $message->from('redfrogs.net', 'Ecin');
                                    $message->to('cooluma@siyaleader.net')->subject("REFER: $cellphone" );

                                });



                            }


                        }
                    }

                }






                if (sizeof($objSubCat) > 0 && $objSubSubCat == "") {



                     $allObjSubCats  = SubCategory::where('name','=',$sub_category)->get();
                     \Log::info(sizeof($allObjSubCats));
                     \Log::info($allObjSubCats);


                     foreach ($allObjSubCats as $value) {


                        $firstRespondersObj  = CaseResponder::where("sub_category",'=',$value->id)
                                                ->select('first_responder')->first();

                        if (sizeof($firstRespondersObj) > 0) {

                            $case->status = 4;
                            $case->referred_at = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                            $case->save();

                            $firstResponders  = explode(",",$firstRespondersObj->first_responder);

                            if($firstRespondersObj->first_responder > 0) {

                                foreach ($firstResponders as $firstResponder) {


                                        $firstResponderUser = UserNew::find($firstResponder);
                                        $caseOwner          = new CaseOwner();
                                        $caseOwner->user    = $firstResponder ;
                                        $caseOwner->case_id = $case->id;
                                        $caseOwner->type    = 1;
                                        $caseOwner->active  = 1;
                                        $caseOwner->save();

                                         $data = array(
                                                'name'          =>$firstResponderUser->name,
                                                'caseID'        =>$case->id,
                                                'caseDesc'      =>$case->description,
                                                'caseReporter'  =>$case->description,
                                            );

                                        \Mail::send('emails.responder',$data, function($message) use ($firstResponderUser) {
                                            $message->from('info@redfrogs.net', 'Redfrogs');
                                            $message->to($firstResponderUser->email)->subject("Red frogs Notification - New Case Reported:");

                                        });

                                        $cellphone = $firstResponderUser->cellphone;

                                       \Mail::send('emails.caseEscalatedSMS',$data, function($message) use ($cellphone)
                                        {
                                            $message->from('redfrogs.net','Redfrogs');
                                            $message->to('cooluma@redfros.net')->subject("REFER: $cellphone" );

                                        });

                                }



                            }
                        }


                    }


                }

                return \Response::json($response,200);
             }

             else
             {

                $response['message'] = 'Access Denied. Ensure that all fields are correctly filled in';
                $response['error']   = TRUE;
                return \Response::json($response,401);

             }

        }
        else
        {
             $response['message'] = 'Access Denied. Invalid Api key';
             $response['error']   = TRUE;
             return \Response::json($response,401);
        }

		 }else{


	//	funtion  to update  the  records

                 //$updatecase = CaseRep
		         $userNew  = User::where('api_key','=',$key)->first();
			     $objCatlor = SubCategory::select('color')->where('name','=',$sub_category)->first();
			     $objCatlors = SubSubCategory::select('color')->where('name','=',$sub_sub_category)->first();
			     $objCatecolr = Category::select('color')->where('name','=',$category)->first();




                if(sizeof($userNew) > 0) {


				  $objCat                           = Category::where('name','=',$category)->first();

                 \Log::info('Category Object :'.$objCat);

                $objSubCat                          = SubCategory::where('name','=',$sub_category)->first();
		//	$objSubCat 	= DB::table('sub_categories')->where('name','=','Relationship-Issues')->first();





                 $SubCatName                       = (sizeof($objSubCat) > 0)? $objSubCat->name : "";

                 if(strlen($sub_sub_category) > 1) {

                     $objSubSubCat =SubSubCategory::where('name','=',$sub_sub_category)->first();

                     $objSubSub    = $objSubSubCat->id;

                 }
                 else {

                     $objSubSubCat = 0;
                     $objSubSub    = 0;
                 }

                 $objPriority            = CasePriority::where('name','=',$priority)->first();
                 $priority               = (sizeof($objPriority) == 0)? 1 : $objPriority->id;



		        $colors  = "";
                if($objCatlors==null)
              	{
				$colors = $objCatecolr->color;
					//dd($objCatecolr->color);
				}

			      elseif($objCatlors==null)
				 {

				 $colors = $objCatlor->color;
				 }
				 else{

				// dd($objCatlor->color);

				 $colors = $objCatlors->color;

				 }

				//  dd($objCat ->id);
				 $case                   = CaseReport::where('id' ,'=',$ID_id)->first();
                 $case->description      = $description;
				 $case->cases_type      = $cases_type;
				 $case->actiontaken      = $actiontaken;

				 $case->location         = $location;
                 $case->user             = $userNew->id;
                 $case->reporter         = $userNew->id;
				 $case->ref_no           = time();//rand(1000, 9999);


                 $case->category         = $objCat ->id;

                 $case->sub_category     = $objSubSubCat;
				   //dd($objCat ->id);
                 $case->sub_sub_category = $objSubSub;
                // $case->category         = $category;
                 ////$case->sub_category     = $sub_category;
                // $case->sub_sub_category = "3";
                // dd($objCat ->id);
                 $case->status           = 1; //Pending
                 $case->gps_lat          = $gps_lat;
             //    $case->img_url          = $img_url;
                 $case->gps_lng          = $gps_lng;
                 $case->source           = 2; //Mobile

				$case->nuberof_person_involve   =$nuberof_person_involve;
				$case->name_person_involve      =$name_person_involve;
				$case->surname_person_involve   =$surname_person_involve  ;
				$case->phone_person_involve     =$phone_person_involve  ;
				$case->email_person_involve     =$email_person_involve ;
				$case->color                    = $colors  ;
				$case->incident_date_time       = $incident_date_time  ;


				$case->name_pain                =$name_pain  ;
				$case->cell_pain                =$cell_pain  ;
				$case->addressHotel_pain        =$addressHotel_pain  ;
				$case->numberOfpeople_pain      =$numberOfpeople_pain  ;


                 $case->save();

                $response['message'] = 'Incident  successfully  update';
                $response['case_id']=$case->id;

			   $response['error']   = false;
                return \Response::json($response,401);


		 }


		 }
    }
	}


}
