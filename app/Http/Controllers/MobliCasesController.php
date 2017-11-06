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
use App\CaseType;
use App\CaseSubType;
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
use App\InvestigationOfficer;
use  App\Messagenotifications ; 


class MobliCasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
		
         $api_key           = \Input::get('api_key');
		 $fileNote         = \Input::get('fileNote'); 
		  $file            = \Input::get('file'); 
		  $case_id         = \Input::get('caseID'); 
		  $name            = \Input::get('name');
	   
		  $email           = \Input::get('email');
		  $cellphone       = \Input::get('cellphone');
		  $duedate         = \Input::get('duedate');
		  $duetime         = \Input::get('duetime');
		  $etimatdate      = \Input::get('etimatdate');
		  $etimatime       = \Input::get('etimatime');
		  $depart          = \Input::get('depart');
		  $cat             = \Input::get('cat');
		
		  $subcat          = \Input::get('subcat');
		  $message         = \Input::get('message');
		  $description     = \Input::get('description');
		  $to              = $request['responders'];
		
		
		
		$Fromuser  = User::where('api_key','=',$api_key )->first();
		
        $responders     = $request['responders'];
        $department     = $request['depart'];
		
	
        $category       = $request['cat'];
        $subCategory    = $request['subcat'];
		
	
        $subSubCategory = $request['sub_sub_category'];
		
			

        $dep_internal = Department::where('name','=',$department)->first();
		$cat_internal = CaseType::where('name','=',$category)->first();
	    $sub_cat_internal = CaseSubType::where('name','=',$subCategory)->first();

        $CaseReport = CaseReport::where('id','=',$case_id)->first();
		
		



		
		  
            $caseOwner          = new CaseOwner();
            $caseOwner->case_id = $case_id;
            $caseOwner->user    = $responders;
            $caseOwner->type    = 1;
            $caseOwner->save();
 

            $user  = User::find($responders);

				$caseActivity              = New CaseActivity();
				$caseActivity->case_id     =  $case_id;
				$caseActivity->user        = $user->id;
				$caseActivity->addressbook = 0;
				$caseActivity->note        = "Case Referred to ".$user->name ." ".$user->surname." by ".$Fromuser->name.' '.$Fromuser->surname;
				$caseActivity->case_id = $case_id;
				$caseActivity->from    = $Fromuser->id ; 
				$caseActivity->to      = $to; 
				//$caseEscalationObj->type    = $type;
				$caseActivity->message ="Case Referred to ".$user->name ." ".$user->surname." by ".$Fromuser->name.' '.$Fromuser->surname;
				$caseActivity->color    = "#4caf50";
			    $caseActivity->created_at              = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                $caseActivity->reporter                 = $Fromuser->id;
              
				$caseActivity->category				    = $CaseReport ->case_type;   
	      		$caseActivity->sub_category		        = $CaseReport ->case_sub_type; 
		        //$caseActivity->case_type                = $sub_cat_internal->id;
                $caseActivity->investigation_officer    =  $name ;
                $caseActivity->investigation_cell    =  $cellphone ;
                $caseActivity->investigation_email   =  $email; 
                $caseActivity->investigation_note    =  $fileNote ; 
                $caseActivity->status          = 7;
                $caseActivity->addressbook     = 0;
                $caseActivity->source          = 2; //Mobile
                $caseActivity->active          = 1;
			    $caseActivity->save();
				
				
			 $caseEscalationObj = New CaseEscalator();
            $caseEscalationObj->case_id = $request['caseID'];
            $caseEscalationObj->from = $Fromuser->id ;
            $caseEscalationObj->to = $to;
            $caseEscalationObj->type = 0;
			$caseEscalationObj->description = $description ;
			$caseEscalationObj->category =$CaseReport ->case_type;
			$caseEscalationObj->sub_category = $CaseReport ->case_sub_type;	
			$caseEscalationObj->investigation_officer = $name ;
			$caseEscalationObj->investigation_cell = $cellphone ;
			$caseEscalationObj->investigation_email =  $email; 
			$caseEscalationObj->status = 7;
			$caseEscalationObj->start    = date("Y-m-d");
			$caseEscalationObj->color    = "#4caf50";
			$caseEscalationObj->end = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
			$caseEscalationObj->title    = "Case ID: " . $request['caseID'];
			$caseEscalationObj->due_date = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
            $caseEscalationObj->message = "Case Referred to ".$user->name ." ".$user->surname." by ".$Fromuser->name.' '.$Fromuser->surname;
            $caseEscalationObj->save();

         

            $email     = $user->email;
            $cellphone = $user->cellphone;
            $case  = CaseReport::find($case_id);

            $data = array(
                'name'    => $user->name,
                'caseID'  =>  $case_id,
                'content' => $case->description,
            );

            \Mail::send('emails.caseEscalated',$data, function($message) use ($email) {
                $message->from('info@siyaleader.net', 'Siyaleader');
                $message->to($email)->subject("Siyaleader Notification - Case Referred: " );

            });
			
			return "ok" ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

	
		 public  function   mobilecaeCreate (){
		 
		 
		
		  $api_key         = \Input::get('api_key');
		  $name            = \Input::get('name');
		  $email           = \Input::get('email');
		  $cellphone       = \Input::get('cellphone');
		  $duedate         = \Input::get('duedate');
		  $duetime         = \Input::get('duetime');
		  $etimatdate      = \Input::get('etimatdate');
		  $etimatime       = \Input::get('etimatime');
		  $depart          = \Input::get('depart');
		  $cat             = \Input::get('cat');
		  $to              = \Input::get('to');
		  $subcat          = \Input::get('subcat');
		
		  $sapsnumber      = \Input::get('sapsnumber');
		  $station         = \Input::get('station');
		  $description     = \Input::get('description');
		  $message         =  \Input::get('message');
		  
		  
		  	$idi  = User::where('api_key','=',$api_key )->first();
		 

		 
		$dueDate					 =  $duedate;
		
		$department_internal		 = $depart;
		$category_internal			 = $cat;
		$sub_category				 =   $subcat;
		
	
	//	$sub_sub_category     		 = $request['sub_sub_category'];
		$estimatedDate   			 =  $etimatdate;
		$estimateTime 					= $etimatime  ;
		
	
		$cat_internal = Category::where('name','=',$category_internal)->first();
	    $sub_cat_internal = SubCategory::where('name','=',$sub_category)->first();
		
	    $dep_id;
		$cat_id;
		$sub_cat_id;
		
	
		if($cat_internal == null){
			$cat_id = 0;
		}else{
			$cat_id = $cat_internal->id;
		}
		
		if($sub_cat_internal == null){
			$sub_cat_id = 0;
		}else{
			$sub_cat_id = $sub_cat_internal->id;
		}
		// $sub_cat = \DB::table('sub_categories')->where('name','=',$sub_category)->first();
            
		//$sub_sub_cat = Department::where('name','=',$sub_sub_category)->first();
		 
                $newCase                        = New CaseReport();
                $newCase->created_at            = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                $newCase->user                  = $idi->id;
                $newCase->reporter              = $idi->id;
               
                $newCase->saps_case_number      = $sapsnumber ;
				$newCase->saps_station          = $station ;
			    $newCase->description           = $description ;
		
				$newCase->category				= $cat_id;
				$newCase->sub_category		    = $sub_cat_id;
		        $newCase->case_type             = $sub_cat_id;
               
                $newCase->due_date              =  $duedate ;
           
                $newCase->investigation_officer =  $name ;
                $newCase->investigation_cell    =  $cellphone ;
                $newCase->investigation_email   =  $email; 
                $newCase->investigation_note    =  $message ;
  
                $newCase->status          = 1;
                $newCase->addressbook     = 0;
                $newCase->source          = 2; //Mobile
                $newCase->active          = 1;
               
                $newCase->save();
				
				
				
					/*-------------------------------------------------------------*/
				$caseEscalationObj          = New CaseEscalator();
				$caseEscalationObj->case_id =$newCase->id;
				$caseEscalationObj->from    = $idi->id;
				$caseEscalationObj->to      = $to; 
				//$caseEscalationObj->type    = $type;
				$caseEscalationObj->message =$message;
				$caseEscalationObj->due_date = $dueDate ;
				$caseEscalationObj->title    = "Case ID: " .$newCase->id;
				$caseEscalationObj->start    = date("Y-m-d");
				$caseEscalationObj->end      = $dueDate;
				$caseEscalationObj->color    = "#4caf50";
			
				
			
				
			    $caseEscalationObj->created_at              = \Carbon\Carbon::now('Africa/Johannesburg')->toDateTimeString();
                $caseEscalationObj->user                    = $idi->id;
                $caseEscalationObj->reporter                = $idi->id;
               
                $caseEscalationObj->description             = $description ;
				//$caseEscalationObj->department		        =  $dep_id;
				$caseEscalationObj->category				= $cat_id;
				$caseEscalationObj->sub_category		    = $sub_cat_id;
		        $caseEscalationObj->case_type               = $sub_cat_id;
               
                $caseEscalationObj->due_date                 =  $duedate ;
           
                $caseEscalationObj->investigation_officer    =  $name ;
                $caseEscalationObj->investigation_cell    =  $cellphone ;
                $caseEscalationObj->investigation_email   =  $email; 
                $caseEscalationObj->investigation_note    =  $message ;
  
                $caseEscalationObj->status          = 4;
                $caseEscalationObj->addressbook     = 0;
                $caseEscalationObj->source          = 2; //Mobile
                $caseEscalationObj->active          = 1;
				
			    $caseEscalationObj->save();
				/*-------------------------------------------------------------*/
				
				
				
						
	   $Messagenotifications  = new  Messagenotifications() ; 
	   $Messagenotifications->from             =$idi->id;
	   $Messagenotifications->to               =  $to ; 
	   $Messagenotifications->message          = $message ;
	   $Messagenotifications->case_id          =  $newCase->id;
	   $Messagenotifications->title          =  $newCase->id;
	   $Messagenotifications->case_escalator_id=$newCase->id;
	   $Messagenotifications-> save() ;
				
		//		$caseId			= CaseReport::where('description','=',$description)->first();
			
			
			    $caseOwner              = new CaseOwner();
                $caseOwner->user        = $idi->id;
                $caseOwner->case_id     = $newCase->id;
                $caseOwner->type        = 0;
                $caseOwner->active      = 1;
                $caseOwner->save();


               


                $response["message"]      = "Case created successfully";
                $response["error"]        = FALSE;
                $response["caseID"]       = $newCase->id;

                return \Response::json($response,201);
		
		
	//	dd( $newCase ) ;
		 
		 
	 } 
	
	
	
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
