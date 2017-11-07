<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Position;
use App\Department;
use App\Province;
use App\District;
use App\Municipality;
use App\Ward;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\CaseReport;
use App\User;
use App\Relationship;
use App\addressbook;
use App\Message;
use App\UserRole;
use App\Title;
use App\Language;
use App\CaseStatus;
use App\CasePriority;
use App\UserStatus;
use App\Affiliation;
use App\AffiliationPositions;
use App\Meeting;
use App\MeetingVenue;
use App\CaseType;
use App\CaseSubType;
use App\Poi;
use App\Permission;
use App\userPermission;
use App\GroupPermission;
use App\Country;
use App\PhoneType;
use App\Religion;
use App\QualificationType;
use App\TrainingType;
use App\InvestigationOfficer;
use App\TaskCategory;
use App\TaskPriority;
use App\TaskStatus;
use App\DroneType;
use Auth;
use App\CalendarEventType; 







class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		$txtDebug = __CLASS__."".__FUNCTION__."()";
        if (\Schema::hasTable('positions'))
        {
            $positions          = Position::orderBy('name','ASC')->get();
            $selectPositions    = array();
            $selectPositions[0] = "Select / All";

            foreach ($positions as $position) {
               $selectPositions[$position->slug] = $position->name;
            }

             \View::share('selectPositions',$selectPositions);

        }
		
		if (\Schema::hasTable('calendar_event_types'))
        {
            $calendarEventTypes          = CalendarEventType::where('name','==','case')
                                                            ->where('name','==','task')
                                                            ->where('name','==','reminder')
                                                            ->orderBy('name','ASC')
                                                            ->get();
            $selectCalendarEventTypes    = array();
            $selectCalendarEventTypes[0] = "Select / All";

            foreach ($calendarEventTypes as $calendarEventType) {
               $selectCalendarEventTypes[$calendarEventType->slug] = $calendarEventType->name;
            }

             \View::share('selectCalendarEventTypes',$selectCalendarEventTypes);

        }


        if (\Schema::hasTable('calendar_event_types'))
        {
            $calendarEventType          = CalendarEventType::orderBy('name','ASC')
                                                            ->get();
            $selectCalendarEventType    = array();
            $selectCalendarEventType[0] = "Select / All";

            foreach ($calendarEventType as $calendarEventType) {
               $selectCalendarEventType[$calendarEventType->slug] = $calendarEventType->name;
            }

             \View::share('selectCalendarEventType',$selectCalendarEventType);

        }
	
	//if (\Schema::hasTable('investigation_officers'))
	if (class_exists(InvestigationOfficer::class))
        {
            $investigation_officers     = InvestigationOfficer::orderBy('name','ASC')->get();
            $selectOfficers    		= array();
            $selectOfficers[0] 		= "Select / Add";
	    
            foreach ($investigation_officers as $investigation_officer) {

               $selectOfficers[$investigation_officer->id] = $investigation_officer->name;
            }

             \View::share('selectOfficers',$selectOfficers);

        }

        if (\Schema::hasTable('training_types'))
        {
            $training_types         = TrainingType::orderBy('name','ASC')->get();
            $selectTrainingTypes    = array();
            $selectTrainingTypes[0] = "Select / All";
            foreach ($training_types as $training_type) {

               $selectTrainingTypes[$training_type->id] = $training_type->name;
            }

             \View::share('selectTrainingTypes',$selectTrainingTypes);

        }

        if (\Schema::hasTable('drone_types'))
        {
            $droneTypes          = DroneType::orderBy('name','ASC')->get();
            $selectDroneTypes    = array();
            $selectDroneTypes[0] = "Choose a Drone";

            foreach ($droneTypes as $droneType) {
                $selectDroneTypes[$droneType->id] = $droneType->name;
            }

            \View::share('selectDroneTypes',$selectDroneTypes);

        }


        if (\Schema::hasTable('religions'))
        {
            $religions          = Religion::orderBy('name','ASC')->get();
            $selectReligions    = array();
            $selectReligions[0] = "Select / All";

            foreach ($religions as $religion) {
              
               $selectReligions[$religion->id] = $religion->name;
            }

             \View::share('selectReligions',$selectReligions);

        }

        if (\Schema::hasTable('qualification_types'))
        {
            $qualification_types         = QualificationType::orderBy('name','ASC')->get();
            $selectQualificationTypes    = array();
            $selectQualificationTypes[0] = "Select / All";

            foreach ($qualification_types as $type) {
              
               $selectQualificationTypes[$type->id] = $type->name;
            }

             \View::share('selectQualificationTypes',$selectQualificationTypes);

        }

        if (\Schema::hasTable('phone_types'))
        {
            $phone_types           = PhoneType::orderBy('name','ASC')->get();
            $select_phone_types    = array();
            $select_phone_types[0] = "Select Phone Type";

            foreach ($phone_types as $phone_type) {
               $select_phone_types[$phone_type->id] = $phone_type->name;
            }

             \View::share('selectPhoneTypes',$select_phone_types);

        }

        if (\Schema::hasTable('countries'))
        {
            $countries          = Country::orderBy('name','ASC')->get();
            $selectCountries    = array();
            $selectCountries[0] = "Select Country";

            foreach ($countries as $country) {
               $selectCountries[$country->id] = $country->name;
            }

             \View::share('selectCountries',$selectCountries);

        }


        if (\Schema::hasTable('affiliations'))
        {
            $affiliations          = Affiliation::orderBy('name','ASC')->get();
            $selectAffiliations    = array();
            $selectAffiliations[0] = "Select / All";

            foreach ($affiliations as $affiliation) {

               $selectAffiliations[$affiliation->id] = $affiliation->name;

            }

             \View::share('selectAffiliations',$selectAffiliations);

        }

        if (\Schema::hasTable('users_statuses'))
        {
            $userStatuses          = UserStatus::orderBy('name','ASC')->get();
            $selectUserStatuses    = array();
            $selectUserStatuses[0] = "Select / All";

            foreach ($userStatuses as $userStatus) {
               $selectUserStatuses[$userStatus->id] = $userStatus->name;
            }

             \View::share('selectUserStatuses',$selectUserStatuses);

        }



        if (\Schema::hasTable('cases_priorities'))
        {
            $priorities          = CasePriority::orderBy('name','ASC')->get();
            $selectPriorities    = array();
            $selectPriorities[0] = "Select / All";

            foreach ($priorities as $priority) {

               $selectPriorities[$priority->slug] = $priority->name;
            }

             \View::share('selectPriorities',$selectPriorities);

        }

        if (\Schema::hasTable('cases_types'))
        {
            $caseTypes          = CaseType::orderBy('name','ASC')->get();
            $selectCasesTypes    = array();
            $selectCasesTypes[0] = "Select / All";

            foreach ($caseTypes as $caseType) {

               $selectCasesTypes[$caseType->id] = $caseType->name;
            }

             \View::share('selectCasesTypes',$selectCasesTypes);
             \View::share('caseTypes',$caseTypes);
        }
	    if (\Schema::hasTable('cases_types')) {
		    $caseSubTypes          = CaseSubType::orderBy('name','ASC')->get();
		    \View::share('caseSubTypes',$caseSubTypes);
	    }

        if (\Schema::hasTable('titles'))
        {
            $titles          = Title::orderBy('name','ASC')->get();
            $selectTitles    = array();
            $selectTitles[0] = "Select / All";

            foreach ($titles as $title) {
               $selectTitles[$title->slug] = $title->name;
            }

             \View::share('selectTitles',$selectTitles);

        }

         if (\Schema::hasTable('languages'))
        {
            $languages          = Language::orderBy('name','ASC')->get();
            $selectLanguages    = array();
            $selectLanguages[0] = "Select / All";

            foreach ($languages as $language) {
               $selectLanguages[$language->slug] = $language->name;
            }

             \View::share('selectLanguages',$selectLanguages);

        }



         if (\Schema::hasTable('departments'))
        {
            $departments          = Department::orderBy('name','ASC')->get();
            $selectDepartments    = array();
            $selectDepartments[0] = "Select Company";

            foreach ($departments as $department) {
               $selectDepartments[$department->id] = $department->name;
            }

             \View::share('selectDepartments',$selectDepartments);
             \View::share('departments',$departments);

        }

        if (\Schema::hasTable('users_roles'))
        {
            $roles          = UserRole::orderBy('name','ASC')->get();
            $selectRoles    = array();
            $selectRoles[0] = "Select / All";

            $selectRoles1    = array();
            $selectRoles1[''] = "Select / All";

            foreach ($roles as $role) {
                $selectRoles[$role->slug] = $role->name;
                $selectRoles1[$role->id] = $role->name;
            }

             \View::share('selectRoles',$selectRoles,$selectRoles1);
             \View::share('selectRoles1',$selectRoles1);

        }


        if (\Schema::hasTable('provinces'))
        {
            $provinces          = Province::orderBy('name','ASC')->get();
            $selectProvinces    = array();
            $selectProvinces[0] = "Select / All";

            foreach ($provinces as $Province) {
               $selectProvinces[$Province->slug] = $Province->name;
            }

             \View::share('selectProvinces',$selectProvinces);

        }

        if (\Schema::hasTable('districts'))
        {
            $districts          = District::orderBy('name','ASC')->get();
            $selectDistrict     = array();
            $selectDistricts[0] = "Select / All";

            foreach ($districts as $district) {
               $selectDistricts[$district->slug] = $district->name;
            }

             \View::share('selectDistricts',$selectDistricts);

        }

        if (\Schema::hasTable('municipalities'))
        {
            $municipalities          = Municipality::orderBy('name','ASC')->get();
            $selectMunicipalities    = array();
            $selectMunicipalities[0] = "Select / All";
            foreach ($municipalities as $municipality) {
               $selectMunicipalities[$municipality->slug] = $municipality->name;
            }

             \View::share('selectMunicipalities',$selectMunicipalities);

        }

        if (\Schema::hasTable('wards'))
        {
            $wards          = Ward::orderBy('name','ASC')->get();
            $selectWards    = array();
            $selectWards[0] = "Select / All";
            foreach ($wards as $ward) {
               $selectWards[$ward->slug] = $ward->name;
            }

             \View::share('selectWards',$selectWards);

        }

        if (\Schema::hasTable('categories'))
        {
            $categories          = Category::orderBy('name','ASC')->get();
            $selectCategories    = array();
            $selectCategories[0] = "Select / All";
            foreach ($categories as $category) {
               $selectCategories[$category->slug] = $category->name;
            }

             \View::share('selectCategories',$selectCategories);

        }

        if (\Schema::hasTable('sub_categories'))
        {
            $subCategories       = SubCategory::orderBy('name','ASC')->get();
            $selectSubCategories    = array();
            $selectSubCategories[0] = "Select / All";
            foreach ($subCategories as $subCategory) {
               $selectSubCategories[$subCategory->slug] = $subCategory->name;
            }

             \View::share('selectSubCategories',$selectSubCategories);

        }

        if (\Schema::hasTable('meetings_venues'))
        {
            $venues          = MeetingVenue::orderBy('name','ASC')->get();
            $selectVenues    = array();
            $selectVenues[0] = "Select one";

            foreach ($venues as $venue) {
               $selectVenues[$venue->id] = $venue->name;
            }

             \View::share('selectVenues',$selectVenues);

        }

        if (\Schema::hasTable('sub_sub_categories'))
        {
            $subSubCategories          = SubSubCategory::orderBy('name','ASC')->get();
            $selectSubSubCategories    = array();
            $selectSubSubCategories[0] = "Select / All";
            foreach ($subSubCategories as $subSubCategory) {
               $selectSubSubCategories[$subSubCategory->slug] = $subSubCategory->name;
            }

             \View::share('selectSubSubCategories',$selectSubSubCategories);

        }

         if (\Schema::hasTable('relationships'))
        {
            $relationships          = Relationship::orderBy('name','ASC')->get();
            $selectRelationships    = array();
            $selectRelationships[0] = "Select / All";
            foreach ($relationships as $relationship) {
               $selectRelationships[$relationship->id] = $relationship->name;
            }

             \View::share('selectRelationships',$selectRelationships);

        }


        if (\Schema::hasTable('cases')) {

            $cases = \DB::table('cases')
                        ->join('users', 'cases.reporter', '=', 'users.id')
                        ->select(
                                    \DB::raw(
                                                "
                                                    IF(`cases`.`addressbook` = 1,(SELECT CONCAT(`first_name`, ' ', `surname`) FROM `addressbook` WHERE `addressbook`.`id`= `cases`.`reporter`), (SELECT CONCAT(users.`name`, ' ', users.`surname`) FROM `users` WHERE `users`.`id`= `cases`.`reporter`)) as reporterName

                                                "
                                            )
                                )
                        ->get();



            $reporters    = array();
            $reporters[0] = "Select / All";
            foreach ($cases as $case) {
               $reporters[$case->reporterName] = $case->reporterName;
            }

             \View::share('selectReporters',$reporters);

        }

         if (\Schema::hasTable('users')) {


            $users    = User::select('created_by')->get();
            $idsArray = array();

            foreach ($users as $user) {

                $idsArray[] = $user->created_by;
            }

            $idsArray =  array_unique($idsArray);

            $userObjs = User::whereIn('id',$idsArray)

            ->select(
                    \DB::raw(
                                "
                                   `id`,
                                   CONCAT(`name`, ' ', `surname`)  as createByName

                                "
                            )
                    )

            ->get();

            $users    = array();
            $users[0] = "Select / All";
            foreach ($userObjs as $userObj) {
               $users[$userObj->createByName] = $userObj->createByName;
            }

             \View::share('selectUsersCreatedBy',$users);

        }


        if (\Schema::hasTable('task_priorities'))
        {
            $taskPriorities          = TaskPriority::orderBy('name','ASC')->get();
            $selectTaskPriorities    = array();
            $selectTaskPriorities[0] = "Choose a priority";

            foreach ($taskPriorities as $taskPriority) {
                $selectTaskPriorities[$taskPriority->id] = $taskPriority->name;
            }

            \View::share('selectTaskPriorities',$selectTaskPriorities);

        }

        if (\Schema::hasTable('task_statuses'))
        {
            $taskStatuses          = TaskStatus::orderBy('name','ASC')->get();
            $selectTaskStatuses    = array();
            $selectTaskStatuses[0] = "Select / All";

            foreach ($taskStatuses as $taskStatus) {
                $selectTaskStatuses[$taskStatus->id] = $taskStatus->name;
            }

            \View::share('selectTaskStatuses',$selectTaskStatuses);

        }

        if (\Schema::hasTable('task_categories'))
        {
            $taskCategories          = TaskCategory::orderBy('name','ASC')->get();
            $selectTaskCategories    = array();
            $selectTaskCategories[] = "Choose a category";

            foreach ($taskCategories as $taskCategory) {
                $selectTaskCategories[$taskCategory->id] = $taskCategory->name;
            }

            \View::share('selectTaskCategories',$selectTaskCategories);

        }

	    $optsCompanies    = array("Select");
	    if (\Schema::hasTable('companies'))
	    {
		    $companies          = \App\Company::orderBy('name','ASC')->get();

		    foreach ($companies as $co) {
			    $cntDep = \App\Department::where("company", $co->id)->count();
			    $optsCompanies[$co->id] = "{$co->name} ({$cntDep})";
		    }

	    }
	    \View::share('optsCompanies',$optsCompanies);
$txtDebug .= "\n  \$optsCompanies - ".print_r($optsCompanies,1);
	    $optsReporters    = array("Select / Add");
	    if (\Schema::hasTable('reporters'))
	    {
		    $reporters          = \App\Reporter::orderBy('name','ASC')->get();
$txtDebug .= "\n  \$reporters - ".print_r($reporters,1);
		    foreach ($reporters as $reporter) {
			    $optsReporters[$reporter->id] = $reporter->name;
		    }
$txtDebug .= "\n  \$optsReporters - ".print_r($optsReporters,1);
	    }
//die("<pre>{$txtDebug}</pre>");
	    \View::share('optsReporters',$optsReporters);


        View()->composer('master',function($view){

        $view->with('addressBookNumber',addressbook::all());

	        $view->with('noPrivateMessages',0);
	        $view->with('noFormsIn',0);
          if(\Auth::check()) {

            $number = addressbook::where('user','=',\Auth::user()->id)->get();
            $view->with('addressBookNumber',$number);

            $allUsers = User::where('id','<>',\Auth::user()->id)->get();
            $view->with('loggedInUsers',$allUsers);

            $noPrivateMessages = Message::where('to','=',\Auth::user()->id)
                                         ->where('read','=',0)
                                         ->where('online','=',0)
                                         ->get();

            $view->with('noPrivateMessages',$noPrivateMessages);

              $userId=Auth::user();

              $allTasks  = \App\TaskOwner::with('user','task','task.status')
                  ->where('user_id',$userId->id)
                  ->where('task_owner_type_id',2)->orderBy('id','desc')->get();

              $view->with('allTasks',$allTasks);

              $tasks  = \App\TaskOwner::with('user','task','task.status')
                  ->where('user_id',$userId->id)
                  ->where('task_owner_type_id',2)->orderBy('id','desc')->take(3)->get();

              $view->with('tasks',$tasks);

              $noOfPendingAllocationCases=CaseReport::where('user', '=', \Auth::user()->id)
                  ->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
                  ->where('cases_statuses.name', '=', 'Pending')
                  ->where('user', '=', \Auth::user()->id)
                  ->get();

              $view->with('noOfPendingAllocationCases',$noOfPendingAllocationCases);

            $noInboxMessages = Message::where('to','=',\Auth::user()->id)
                                        ->where('online','=',0)
                                        ->get();

            $view->with('noInboxMessages',$noInboxMessages);


            $noDepartments = Department::all();

            $view->with('noDepartments',$noDepartments);

            $noUsers = User::all();

            $view->with('noUsers',$noUsers);

            $noPOIUsers = Poi::all();
            $view->with('noPOIUsers',$noPOIUsers);


            $noRoles = UserRole::all();

            $view->with('noRoles',$noRoles);

            $noPositions = Position::all();

            $view->with('noPositions',$noPositions);

            $noRelationships = Relationship::all();

            $view->with('noRelationships',$noRelationships);

            $noProvinces = Province::all();

            $view->with('noProvinces',$noProvinces);

            $noCaseStatuses = CaseStatus::all();

            $view->with('noCaseStatuses',$noCaseStatuses);

            $userRole = UserRole::where('id','=',\Auth::user()->role)->first();

            $view->with('systemRole',$userRole);

            $noCasesPriorities = CasePriority::all();

            $view->with('noCasesPriorities',$noCasesPriorities);

            $noAffiliations = Affiliation::all();

            $view->with('noAffiliations',$noAffiliations);

            $noMeetings = Meeting::all();

            $view->with('noMeetings',$noMeetings);

            $noPermissions = Permission::all();
            $view->with('noPermissions',$noPermissions);
            
            $noForms = 0;
            $view->with('noForms',$noForms);


           $userViewAffiliationPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',1)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();


            $view->with('userViewAffiliationPermission',$userViewAffiliationPermission);



            $userViewCalendarPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',13)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();




            $view->with('userViewCalendarPermission',$userViewCalendarPermission);

          $userViewCasesPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',15)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewCasesPermission',$userViewCasesPermission);


          $userViewAdministrationPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',14)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewAdministrationPermission',$userViewAdministrationPermission);

          $userViewCasePriorityPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',2)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewCasePriorityPermission',$userViewCasePriorityPermission);

          $userViewCaseStatusPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',3)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewCaseStatusPermission',$userViewCaseStatusPermission);

          $userViewDepartmentsPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',4)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewDepartmentsPermission',$userViewDepartmentsPermission);

          $userViewMeetingsPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',5)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewMeetingsPermission',$userViewMeetingsPermission);

          $userViewPositionsPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',6)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewPositionsPermission',$userViewPositionsPermission);

          $userViewProvincesPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',7)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewProvincesPermission',$userViewProvincesPermission);

          $userViewRelationshipsPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',8)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewRelationshipsPermission',$userViewRelationshipsPermission);

          $userViewUserGroupsPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',9)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewUserGroupsPermission',$userViewUserGroupsPermission);

          $userViewUsersPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',10)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewUsersPermission',$userViewUsersPermission);


          $userViewPOIPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',11)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewPOIPermission',$userViewPOIPermission);

          $userViewPermissionsPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',12)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewPermissionsPermission',$userViewPermissionsPermission);

          $userViewReportsPermission   = \DB::table('group_permissions')
                            ->join('users_roles','group_permissions.group_id','=','users_roles.id')
                            ->where('group_permissions.permission_id','=',16)
                            ->where('group_permissions.group_id','=',\Auth::user()->role)
                            ->first();

          $view->with('userViewReportsPermission',$userViewReportsPermission);




						$noFormsIn = \DB::table('forms_assigned')->where('user_id','=',\Auth::user()->id)
							//->where('read','=',0)
							//->where('online','=',0)
							->get();
						$view->with('noFormsIn',$noFormsIn);
          }

        });

      }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
