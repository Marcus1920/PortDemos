<?php
use App\Province;
use App\District;
use App\Municipality;
use App\Department;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\CaseReport;
use App\Online;
use App\User;
use App\Message;
use App\Affiliation;
use App\MeetingVenue;
use App\CaseType;
use App\CaseSubType;
use App\AffiliationPositions;
use App\Position;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
|--------------------------------------------------------------------------
| HOME ROUTING
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => 'adminmiddlewar'], function () {
    Route::get('admin', 'SeniorHomeController@index');
    // Route::get('admin', 'SeniorHomeController@index');
});
Route::group(['middleware' => 'adminmiddlewar'], function () {
    Route::get('/', function () {
        if (!\Auth::check()) return view('auth.login');
        else return redirect("/home");
    });
    Route::get('home', ['uses' => 'HomeController@index']);
    Route::get('home', ['uses' => 'HomeController@index']);
    Route::get('generatecharts', ['uses' => 'HomeController@getcharts']);
});
$this->post('dologin', 'Auth\LoginController@doLogin');
$this->post('dosignup', 'Auth\LoginController@dosignup');
Route::group(array('prefix' => 'api/v1'), function () {
    Route::post('logi', 'UserController@login');
    Route::post('pedingcases', 'ReportController@Pendingcases');
    Route::post('allocatecase', 'ReportController@Allocatercase');
    Route::post('referecases', 'ReportController@Referecases');
    Route::get('getallusers', 'ReportController@Getallusers');
    Route::post('acceptedcases', 'ReportController@Acceptedcases');
    Route::post('declinsecase', 'ReportController@Declinsecase');
    Route::get('categoriess', 'DepartController@index');
    Route::get('myreport', 'ReportCController@myReport');
    Route::post('report', 'ReportController@store');
    Route::get('messagenofication', 'CaseNotesController@messagenofication');
    Route::post('mobilecaeCreate', 'MobliCasesController@mobilecaeCreate');
    Route::post('newmessagenofication', 'CaseNotesController@newmessagenofication');
    Route::get('showcontactmobile', 'AddressBookController@showcontactmobile');
    Route::post('requestcloser', 'ReportCController@requestcloser');
    Route::post('updatecasemobile', 'ReportCController@updatecasemobile');
    Route::get('statuss', 'ReportCController@statuss');
    Route::post('mobilerallocate', 'MobliCasesController@store');
    Route::post('actionteken', 'DepartController@action');
    Route::post('Casetype', 'DepartController@castype');
    Route::get('mobiledepartement', 'DepartController@mobiledepartement');
    Route::get('subcategories', 'DepartController@mobilesubcategories');
    Route::get('subsubcategories', 'DepartController@mobilesusubbcategories');
    Route::get('categories', 'DepartController@index');
    Route::get('mobilecalendarListPerUser', 'CasesController@mobilecalendarListPerUser');
    Route::post('reportImage', 'ReportCController@saveReportImage');
    Route::post('createincident', 'ReportCController@creatReport');
    Route::post('closeIncidentmobile', 'ReportCController@closeIncidentmobile');
    Route::post('login', 'UserCController@login');
    Route::post('forgot', 'UserCController@forgot');
});
Route::get('reports', 'MainreportController@index');
Route::get('creatCase', function () {
    $user = \App\User::findOrNew(\Auth::id());

    return view('cases.createFor')->with("user", $user);
});
Route::get('creatCase', "MapController@index");
/*
|--------------------------------------------------------------------------
| END HOME ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| ROLES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-roles', ['middleware' => 'UsersMilldware', function () {
    return view('roles.list');
}]);
Route::get('roles-list', ['middleware' => 'resetLastActive', 'uses' => 'RolesController@index']);
Route::get('roles/{id}', ['middleware' => 'resetLastActive', 'uses' => 'RolesController@edit']);
Route::post('add-role', ['middleware' => 'resetLastActive', 'uses' => 'RolesController@store']);
Route::post('update-role', ['middleware' => 'resetLastActive', 'uses' => 'RolesController@update']);
/*
|--------------------------------------------------------------------------
| END ROLES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| USERS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-users', ['middleware' => 'UsersMilldware', 'uses' => 'UserController@list_users']);
Route::get('users-list', ['uses' => 'UserController@index']);
Route::get('getResponder', ['middleware' => 'resetLastActive', 'uses' => 'UserController@responder']);
Route::get('getResponders', ['middleware' => 'resetLastActive', 'uses' => 'UserController@getResponders']);
Route::get('getPois', ['middleware' => 'resetLastActive', 'uses' => 'UserController@getPois']);
Route::get('getPoisAssociates/{id}', ['middleware' => 'resetLastActive', 'uses' => 'UserController@getPoisAssociates']);
Route::get('deleteAssociation', ['middleware' => 'resetLastActive', 'uses' => 'UserController@deleteAssociation']);
Route::get('deleteCaseAssociation', ['middleware' => 'resetLastActive', 'uses' => 'UserController@deleteCaseAssociation']);
Route::get('getCasePoisAssociates/{id}', ['middleware' => 'resetLastActive', 'uses' => 'UserController@getCasePoisAssociates']);
Route::get('getPoiCasesAssociates/{id}', ['middleware' => 'resetLastActive', 'uses' => 'UserController@getPoiCasesAssociates']);
Route::get('getCaseSearch', ['middleware' => 'resetLastActive', 'uses' => 'UserController@getCaseSearch']);
Route::get('getUsers', ['middleware' => 'auth', 'uses' => 'UserController@getUsers']);
Route::get('getAddressBookUsers', ['middleware' => 'auth', 'uses' => 'AddressBookController@getAddressBookUsers']);
Route::get('add-user', function () {
    return view('users.registration');
});
Route::get('user-profile', function () {
    return view('users.profile');
});
Route::post('editProfilePic', ['middleware' => 'resetLastActive', 'uses' => 'UserController@UpdateUserProfile']);
Route::get('edit-profile', function () {
    return view('users.editProfile');
});
Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
Route::get('users/{id}', ['middleware' => 'resetLastActive', 'uses' => 'UserController@edit']);
Route::post('updateUser', ['middleware' => 'resetLastActive', 'uses' => 'UserController@update']);
Route::get('getHouseHolder', ['middleware' => 'resetLastActive', 'uses' => 'UserController@getHouseHolder']);//getPoi
Route::get('getPoi', ['middleware' => 'resetLastActive', 'uses' => 'UserController@getPoi']);//getPoi
Route::post('filterUsersReports', ['middleware' => 'resetLastActive', 'uses' => 'UserController@show']);
Route::get('getFieldWorker', ['middleware' => 'resetLastActive', 'uses' => 'UserController@getFieldWorker']);
Route::get('list-poi-users', ['middleware' => 'resetLastActive', function () {
    return view('users.poi');
}]);
Route::get('poi-list', ['middleware' => 'resetLastActive', 'uses' => 'UserController@list_poi']);
Route::get('add-poi-user', ['middleware' => 'resetLastActive', function () {
    return view('users.poiregistration');
}]);
Route::get('edit-poi-user/{id}', ['middleware' => 'resetLastActive', 'uses' => 'UserController@edit_poi']);
Route::get('view-poi-associates/{id}', ['middleware' => 'resetLastActive', 'uses' => 'UserController@view_poi_associates']);
Route::get('view-case-poi-associates/{id}', ['middleware' => 'resetLastActive', 'uses' => 'UserController@view_case_poi_associates']);
Route::get('view-poi-cases-associates/{id}', ['middleware' => 'resetLastActive', 'uses' => 'UserController@view_poi_cases_associates']);
Route::post('save_poi', ['middleware' => 'resetLastActive', 'uses' => 'UserController@save_poi']);
Route::post('edit_poi', ['middleware' => 'resetLastActive', 'uses' => 'UserController@edit_poi_save']);
/*
|--------------------------------------------------------------------------
| END USERS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('getOfficer/{id}', ['middleware' => 'resetLastActive', 'uses' => 'InvestigationOfficerController@show']);
Route::get('getReporter/{id}', function ($id) {
    $officer = \App\Reporter::select('id', 'name', 'cellphone', 'email')
        ->where('id', '=', $id)
        ->get();

    return $officer;
});
/*
|--------------------------------------------------------------------------
| DOCUMENTS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('documents-list', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@index']);
Route::get('list-documents', ['middleware' => 'auth', function () {
    return view('documents.list');
}]);
Route::get('list-filemanager', ['middleware' => 'auth', function () {
    return view('documents.file-manager');
}]);
Route::get('documentLog-list', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@documentLogIndex']);
Route::get('list-documentLog', ['middleware' => 'auth', function () {
    return view('documents.list-document-log');
}]);
Route::get('list-folder/{id}', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@folder_document']);
Route::get('show_repository', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@show_repository']);
Route::get('addfolder/{id?}', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@addFolder']);
Route::get('addSubFolder/{id}/{lavel?}', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@addSubFolder']);
Route::get('folder-documents/{id}/{type?}', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@folder_document']);
Route::get('addDocumentfile/{id}/{lavel?}', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@addDocumentfile']);
Route::post('addDocument', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@store']);
Route::post('saveEditFolder', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@saveEditFolder']);
Route::post('saveDocumentfile', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@saveDocumentfile']);
Route::post('updateDocument', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@update']);
Route::get('documents/{id}', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@edit']);
Route::get('documentDelete/{id}', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@documentDelete']);
Route::get('downloadsDoc/{id}', ['middleware' => 'auth', 'uses' => 'DocumentRepositoryController@downloadsDoc']);
/*
|--------------------------------------------------------------------------
| END DOCUMENTS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| DEPARTMENTS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('erro', function () {
    return view('messages.erro');
});
Route::get('list-departments/{id_company?}', ['middleware' => 'UsersMilldware', function ($id_company = null) {
    return view('departments.list')->with(compact("id_company"));
}]);
Route::get('departments-list/{id_company?}', ['middleware' => 'UsersMilldware', 'uses' => 'DepartmentController@index']);
Route::get('departments/{id}', ['middleware' => 'UsersMilldware', 'uses' => 'DepartmentController@edit']);
Route::post('updateDepartment', ['middleware' => 'UsersMilldware', 'uses' => 'DepartmentController@update']);
Route::post('addDepartment', ['middleware' => 'UsersMilldware', 'uses' => 'DepartmentController@store']);
/*
|--------------------------------------------------------------------------
| END DEPARTMENTS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| MEETINGS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-meetings', ['middleware' => 'resetLastActive', function () {
    return view('meetings.list');
}]);
Route::get('meetings-list', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@index']);
Route::get('meetings-attendees-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@indexAttendee']);
Route::get('meetings-files-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@indexFiles']);
Route::get('meetings/{id}', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@edit']);
Route::post('updateMeeting', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@update']);
Route::post('addMeetingMinutesFile', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@uploadMeetingMinutes']);
Route::post('addMeeting', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@store']);
Route::post('addMeetingAttendee', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@storeAttendee']);
Route::post('removeMeetingAttendee', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@removeAttendee']);
Route::post('inviteMeetingAttendee', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@inviteAttendee']);
Route::post('markMeetingAttendee', ['middleware' => 'resetLastActive', 'uses' => 'MeetingsController@markAttendee']);
/*
|--------------------------------------------------------------------------
| END MEETINGS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| VENUES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::post('addVenue', ['middleware' => 'resetLastActive', 'uses' => 'VenuesController@store']);
/*
|--------------------------------------------------------------------------
| END VENUES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| MEETING FACILITATORS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('getMeetingFacilitators', ['middleware' => 'resetLastActive', 'uses' => 'AddressBookController@show']);
/*
|--------------------------------------------------------------------------
| END MEETING FACILITATORS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| STATUSES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-statuses', ['middleware' => 'resetLastActive', function () {
    return view('statuses.list');
}]);
Route::get('statuses-list', ['middleware' => 'resetLastActive', 'uses' => 'CasesStatusesController@index']);
Route::get('statuses/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesStatusesController@edit']);
Route::post('updateCaseStatus', ['middleware' => 'resetLastActive', 'uses' => 'CasesStatusesController@update']);
Route::post('addCaseStatus', ['middleware' => 'resetLastActive', 'uses' => 'CasesStatusesController@store']);
/*
|--------------------------------------------------------------------------
| END STATUSES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| PRIORITIES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-priorities', ['middleware' => 'resetLastActive', function () {
    return view('priorities.list');
}]);
Route::get('priorities-list', ['middleware' => 'resetLastActive', 'uses' => 'CasesPrioritiesController@index']);
Route::get('priorities/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesPrioritiesController@edit']);
Route::post('updateCasePriority', ['middleware' => 'resetLastActive', 'uses' => 'CasesPrioritiesController@update']);
Route::post('addCasePriority', ['middleware' => 'resetLastActive', 'uses' => 'CasesPrioritiesController@store']);
/*
|--------------------------------------------------------------------------
| END PRIORITIES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| PROVINCES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-provinces', ['middleware' => 'resetLastActive', function () {
    return view('provinces.list');
}]);
Route::get('provinces-list', ['middleware' => 'resetLastActive', 'uses' => 'ProvincesController@index']);
Route::get('provinces/{id}', ['middleware' => 'resetLastActive', 'uses' => 'ProvincesController@edit']);
Route::post('updateProvince', ['middleware' => 'resetLastActive', 'uses' => 'ProvincesController@update']);
Route::post('addProvince', ['middleware' => 'resetLastActive', 'uses' => 'ProvincesController@store']);
/*
|--------------------------------------------------------------------------
| END PROVINCES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| DISTRICS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-districts/{province}', ['middleware' => 'resetLastActive', function ($province) {
    $provinceObj = Province::find($province);

    return view('districts.list', compact('provinceObj'));
}]);
Route::get('districts-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'DistricsController@index']);
Route::get('districts/{id}', ['middleware' => 'resetLastActive', 'uses' => 'DistricsController@edit']);
Route::post('updateDistrict', ['middleware' => 'resetLastActive', 'uses' => 'DistricsController@update']);
Route::post('addDistrict', ['middleware' => 'resetLastActive', 'uses' => 'DistricsController@store']);
/*
|--------------------------------------------------------------------------
| END DISTRICS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| MUNICIPALITIES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-municipalities/{district}', ['middleware' => 'resetLastActive', function ($district) {
    $districtObj = District::find($district);
    $provinceObj = Province::find($districtObj->province);

    return view('municipalities.list', compact('districtObj', 'provinceObj'));
}]);
Route::get('municipalities-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'MunicipalitiesController@index']);
Route::get('municipalities/{id}', ['middleware' => 'resetLastActive', 'uses' => 'MunicipalitiesController@edit']);
Route::post('updateMunicipality', ['middleware' => 'resetLastActive', 'uses' => 'MunicipalitiesController@update']);
Route::post('addMunicipality', ['middleware' => 'resetLastActive', 'uses' => 'MunicipalitiesController@store']);
/*
|--------------------------------------------------------------------------
| END MUNICIPALITIES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| WARDS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-wards/{municipality}', ['middleware' => 'resetLastActive', function ($municipality) {
    $municipalityObj = Municipality::find($municipality);
    $districtObj     = District::find($municipalityObj->district);
    $provinceObj     = Province::find($districtObj->province);

    return view('wards.list', compact('districtObj', 'municipalityObj', 'provinceObj'));
}]);
Route::get('wards-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'WardsController@index']);
Route::get('wards/{id}', ['middleware' => 'resetLastActive', 'uses' => 'WardsController@edit']);
Route::post('updateWard', ['middleware' => 'resetLastActive', 'uses' => 'WardsController@update']);
Route::post('addWard', ['middleware' => 'resetLastActive', 'uses' => 'WardsController@store']);
/*
|--------------------------------------------------------------------------
| END WARDS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| CATEGORIES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-categories/{department}', ['middleware' => 'resetLastActive', function ($department) {
    $deptObj = Department::find($department);

    return view('categories.list', compact('deptObj'));
}]);
Route::get('categories/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CategoriesController@edit']);
Route::get('categories-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CategoriesController@index']);
Route::post('updateCategory', ['middleware' => 'resetLastActive', 'uses' => 'CategoriesController@update']);
Route::post('addCategory', ['middleware' => 'resetLastActive', 'uses' => 'CategoriesController@store']);
/*
|--------------------------------------------------------------------------
| END CATEGORIES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| SUB-CATEGORIES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-sub-categories/{category}', ['middleware' => 'auth', function ($category) {
    $catObj   = CaseType::find($category);
    $deptName = Department::find($catObj->department);

    return view('subcategories.list', compact('catObj', 'deptName'));
}]);
Route::get('subcategories/{id}', ['middleware' => 'resetLastActive', 'uses' => 'SubCategoriesController@edit']);
Route::get('sub-categories-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'SubCategoriesController@index']);
Route::post('updateSubCategory', ['middleware' => 'resetLastActive', 'uses' => 'SubCategoriesController@update']);
Route::post('addSubCategory', ['middleware' => 'resetLastActive', 'uses' => 'SubCategoriesController@store']);
/*
|--------------------------------------------------------------------------
| END SUB-CATEGORIES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| SUB-SUB-CATEGORIES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-sub-sub-categories/{sub_category}', ['middleware' => 'resetLastActive', function ($sub_category) {
    $subCatObj = CaseSubType::find($sub_category);
    $catObj    = CaseType::find($subCatObj->case_type);
    $deptObj   = Department::find($catObj->department);

    return view('subsubcategories.list', compact('subCatObj', 'deptObj', 'catObj'));
}]);
Route::get('sub-sub-categories-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'SubSubCategoriesController@index']);
Route::get('subsubcategories/{id}', ['middleware' => 'resetLastActive', 'uses' => 'SubSubCategoriesController@edit']);
Route::post('addSubSubCategory', ['middleware' => 'resetLastActive', 'uses' => 'SubSubCategoriesController@store']);
Route::post('updateSubSubCategory', ['middleware' => 'resetLastActive', 'uses' => 'SubSubCategoriesController@update']);
/*
|--------------------------------------------------------------------------
| END SUB-SUB-CATEGORIES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| CASES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('casetest/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@viewcase']);
Route::get('cases-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@index']);
Route::get('case/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@viewcase']);
//Route::get('cases-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@viewcase']);
Route::get('case/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@edit']);
Route::get('workflows-list-case/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@workflow']);
Route::post('escalateCase', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@escalate']);
Route::post('allocateCase', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@allocate']);
Route::post('addCasePoi', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@addCasePoi']);
Route::post('addAssociatePoi', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@addAssociatePoi']);
Route::post('addCaseAssociatePoi', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@addCaseAssociatePoi']);
Route::post('addCaseAssociatePoiCase', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@addCaseAssociatePoiCase']);
Route::post('createCase', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@create']);
Route::post('createCaseAgent', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@createCaseAgent']);
Route::get('acceptCase/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@acceptCase']);
Route::get('addCaseForm', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@captureCase']);
Route::get('closeCase/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@closeCase']);
Route::post('requestCaseClosure', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@requestCaseClosure']);
Route::get('request-cases-closure-list', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@requestCaseClosureList']);
Route::get('resolved-cases-list', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@resolvedCasesList']);
Route::get('pending-referral-cases-list', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@pendingReferralCasesList']);
Route::get('all-cases-list', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@allCasesList']);
Route::post('captureCaseUpdate', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@captureCaseUpdate']);
Route::post('captureCaseUpdateH', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@captureCaseUpdateH']);
Route::get('relatedCases-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@relatedCases']);
Route::get('getCases', ['middleware' => 'auth', 'uses' => 'CasesController@getCases']);
//Route::get('closedCases', ['middleware' => 'auth', 'uses' => 'CasesController@closedCases']);
//Route::get('pendingCases', ['middleware' => 'auth', 'uses' => 'CasesController@pendingCases']);
///Route::get('pendingClosureCases', ['middleware' => 'auth', 'uses' => 'CasesController@pendingClosureCases']);
Route::post('updateCase', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@updateCase']);
Route::get('allCases', ['middleware' => 'auth', 'uses' => 'CasesController@allCases']);
Route::get('pendingClosureCases', function () {
    return view('cases.pendingClosureCases');
});
Route::get('users', function () {
    return view('users.editusers');
});
Route::get('pendingCases', function () {
    return view('cases.pendingCases');
});
Route::get('closedCases', function () {
    return view('cases.closedCases');
});
//Route::get('allocatedCases', ['middleware' => 'auth', 'uses' => 'CasesController@allocatedCases']);
Route::get('allocatedCases', function () {
    return view('cases.allocatedCases');
});
/*
|--------------------------------------------------------------------------
| END CASES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| ADDRESSBOOK ROUTING
|--------------------------------------------------------------------------
|
*/
//Route::get('addressbook-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'AddressBookController@index']);
//Route::get('addressbook-list', ['uses' => 'AddressBookController@index']);
Route::get('addressbookList/{id}', 'AddressBookController@getProfilePerUser');
Route::post('updateAddressbook', 'AddressBookController@update')->name("updateAddressbook");
Route::get('CreateContact', 'AddressBookController@Create');
Route::post('addContact', ['middleware' => 'resetLastActive', 'uses' => 'AddressBookController@store']);
Route::get('getContacts', ['middleware' => 'resetLastActive', 'uses' => 'AddressBookController@show']);
Route::get('getPoisContacts', ['middleware' => 'resetLastActive', 'uses' => 'UserController@searchPOI']);
Route::get('addressBookView', ['middleware' => 'resetLastActive', 'uses' => 'AddressBookController@globalIndex']);
Route::get('addressbook-list', ['uses' => 'AddressBookController@test']);
Route::get('getContactProfile/{id}', ['uses' => 'AddressBookController@getProfilePerUser']);
Route::get('global-list', ['uses' => 'AddressBookController@test']);
Route::get('addToPrivate', ['uses' => 'AddressBookController@addToPrivate']);
Route::get('userprofileGlobal/{id}', 'AddressBookController@userprofileGlobal');
Route::get('userprofilePrivate/{id}', 'AddressBookController@userprofilePrivate');
Route::get('deleteuserprofilePrivate/{id}', 'AddressBookController@deleteuser');
/*
|--------------------------------------------------------------------------
| END ADDRESSBOOK ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| RELATIONSHIP ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| POSITIONS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-relationships', ['middleware' => 'resetLastActive', function () {
    return view('relationships.list');
}]);
Route::get('relationships-list', ['middleware' => 'resetLastActive', 'uses' => 'RelationshipController@index']);
Route::get('relationships/{id}', ['middleware' => 'resetLastActive', 'uses' => 'RelationshipController@edit']);
Route::post('updateRelationship', ['middleware' => 'resetLastActive', 'uses' => 'RelationshipController@update']);
Route::post('addRelationship', ['middleware' => 'resetLastActive', 'uses' => 'RelationshipController@store']);
/*
|--------------------------------------------------------------------------
| END POSITIONS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| END RELATIONSHIP ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| RESPONDERS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('getsubSubResponders/{id}', ['middleware' => 'resetLastActive', 'uses' => 'RespondersController@subSubResponder']);
Route::post('addSubSubCategoryResponder', ['middleware' => 'resetLastActive', 'uses' => 'RespondersController@storeSubSubResponder']);
Route::get('getSubResponders/{id}', ['middleware' => 'resetLastActive', 'uses' => 'RespondersController@subResponder']);
Route::post('addSubCategoryResponder', ['middleware' => 'resetLastActive', 'uses' => 'RespondersController@storeSubResponder']);
Route::get('caseResponders-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'RespondersController@index']);
Route::get('allCaseResponders-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'RespondersController@indexResponders']);
Route::get('getResponders/{id}', ['middleware' => 'resetLastActive', 'uses' => 'RespondersController@responder']);
Route::post('addCategoryResponder', ['middleware' => 'resetLastActive', 'uses' => 'RespondersController@storeResponder']);
/*
|--------------------------------------------------------------------------
| END RESPONDERS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| WORKFLOWS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('workflows-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'WorkflowsController@index']);
Route::get('saveWorkFlowOrder', ['middleware' => 'resetLastActive', 'uses' => 'WorkflowsController@saveWorkFlowOrder']);
Route::post('AddWorkF', ['middleware' => 'resetLastActive', 'uses' => 'WorkflowsController@store']);
Route::post('removeWorkFlow', ['middleware' => 'resetLastActive', 'uses' => 'WorkflowsController@removeWorkFlow']);
/*
|--------------------------------------------------------------------------
| END WORKFLOWS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| CASE NOTES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('caseNotes-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CaseNotesController@index']);
Route::get('poi-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CasesController@list_case_poi']);
Route::post('addCaseNote', ['middleware' => 'resetLastActive', 'uses' => 'CaseNotesController@store']);
/*
|--------------------------------------------------------------------------
| END CASE NOTES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| CASE FILES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::post('addCaseFile', ['middleware' => 'resetLastActive', 'uses' => 'CaseFilesController@store']);
Route::get('fileDescription/{id}/{name}', ['middleware' => 'resetLastActive', 'uses' => 'CaseFilesController@index']);
/*
|--------------------------------------------------------------------------
| END CASE FILES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| CASE ACTIVITIES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('caseActivities-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CaseActivitiesController@index']);
/*
|--------------------------------------------------------------------------
| END CASE ACTIVITIES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| POSITIONS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-positions', ['middleware' => 'UsersMilldware', function () {
    return view('positions.list');
}]);
Route::get('positions-list', ['middleware' => 'resetLastActive', 'uses' => 'PositionsController@index']);
Route::get('positions/{id}', ['middleware' => 'resetLastActive', 'uses' => 'PositionsController@edit']);
Route::post('updatePosition', ['middleware' => 'resetLastActive', 'uses' => 'PositionsController@update']);
Route::post('addPosition', ['middleware' => 'resetLastActive', 'uses' => 'PositionsController@store']);
Route::get('getPositions', ['middleware' => 'resetLastActive', 'uses' => 'PositionsController@show']);
/*
|--------------------------------------------------------------------------
| END POSITIONS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| CALENDAR ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('calendar/events', ['middleware' => 'auth', 'uses' => 'CalendarEventsController@index']);
Route::get('calendar/events/create', ['middleware' => 'auth', 'uses' => 'CalendarEventsController@openCreateEventView']);
Route::post('calendar/events/createEvent', ['middleware' => 'auth', 'uses' => 'CalendarEventsController@store']);
Route::get('calendar/events/getEvents', ['middleware' => 'auth', 'uses' => 'CalendarEventsController@getEvents']);
Route::get('calendar/events/getEvent/{id}', ['middleware' => 'auth', 'uses' => 'CalendarEventsController@show']);
Route::get('calendar/events/deleteEvent/{id}', ['middleware' => 'auth', 'uses' => 'CalendarEventsController@destroy']);
Route::get('calendar/events/getEventPerType/{id}', ['middleware' => 'auth', 'uses' => 'CalendarEventsController@getEventPerType']);
Route::get('getCalendarsPerGroup/{id}', ['middleware' => 'auth', 'uses' => 'CalendarEventsController@getCalendarsPerGroup']);
Route::resource('calendar', 'CalendarController@index');
Route::resource('calendar', 'CalendarController@update');
Route::resource('calendar', 'CalendarController@update');
Route::get('calendar/create/{calendarGroup}', 'CalendarController@create');
Route::post('calendars/create', 'CalendarController@store');
Route::get('calendar/show/{calendarGroup}', 'CalendarController@show');
Route::resource('calendar-group', 'CalendarGroupsController');
/*
|--------------------------------------------------------------------------
| END CALENDAR ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| CALENDAR EVENT TYPES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('calendar/events/event-types', ['middleware' => 'auth', 'uses' => 'CalendarEventTypesController@index']);
Route::post('calendar/event-types/create', ['middleware' => 'auth', 'uses' => 'CalendarEventTypesController@store']);
/*
|--------------------------------------------------------------------------
| END CALENDAR  EVENT TYPES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| CASE OWNERS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('caseOwner/{user}/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CaseOwnerController@index']);
/*
|--------------------------------------------------------------------------
| CASE OWNERS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
|  PASSWORD  ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('resend_password/{id}', 'UserController@resendPassword');
// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
/*
|--------------------------------------------------------------------------
|  END PASSWORD  ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| REPORTS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
Route::get('reports', ['middleware' => 'resetLastActive', function () {
    return view('reports.list');
}]);
*/
Route::get('reports-list', ['middleware' => 'resetLastActive', 'uses' => 'ReportsController@index']);
Route::post('filterReports', ['middleware' => 'resetLastActive', 'uses' => 'ReportsController@show']);
/*
|--------------------------------------------------------------------------
| END REPORTS ROUTING
|--------------------------------------------------------------------------
|
*/
$router->resource('users', 'UserController');
$router->resource('groups', 'RolesController');
Route::get('/api/dropdown/{to}/{from}', function ($to, $from) {
    $name = Input::get('option');
    if ($from == 'province') {
        $object = Province::where('slug', '=', $name)->first();
    }
    if ($from == 'district') {
        $object = District::where('slug', '=', $name)->first();
    }
    if ($from == 'municipality') {
        $object  = Municipality::where('slug', '=', $name)->first();
        $listing = DB::table($to)->where($from, $object->id)->lists('name', 'slug');
    }
    else {
        $listing = DB::table($to)->where($from, $object->id)->orderBy('name', 'ASC')->lists('name', 'slug');
    }

    return $listing;
});
Route::get('/api/dropdownDepartment/{to}/{from}', function ($to, $from) {
    $name = Input::get('option');
    if ($from == 'department') {
        $object  = Department::where('slug', '=', $name)->first();
        $listing = DB::table('categories')
            ->where('department', '=', $object->id)
            ->orderBy('name', 'ASC')
            ->lists('name', 'slug');
    }
    if ($from == 'category') {
        $object  = Category::where('slug', '=', $name)->first();
        $listing = DB::table('sub_categories')
            ->where('category', '=', $object->id)
            ->orderBy('name', 'ASC')
            ->lists('name', 'slug');
    }
    if ($from == 'sub_category') {
        $object  = SubCategory::where('slug', '=', $name)->first();
        $listing = DB::table('sub_sub_categories')
            ->where('sub_category', '=', $object->id)
            ->orderBy('name', 'ASC')
            ->lists('name', 'slug');
    }

    return $listing;
});
Route::get('/api/dropdownCaseType/{to}/{from}', function ($to, $from) {
    $id = Input::get('option');
    if ($from == 'case_type') {
        $object  = CaseType::where('id', '=', $id)->first();
        $listing = DB::table('cases_sub_types')
            ->where('case_type', '=', $object->id)
            ->orderBy('name', 'ASC')
            ->lists('name', 'id');
    }

    return $listing;
});
Route::get('/api/dropdownCategory/{to}/{from}', function ($to, $from) {
    $name = Input::get('option');
    if ($from == 'category') {
        $object = Category::where('slug', '=', $name)->first();
    }
    else {
        $object = SubCategory::where('slug', '=', $name)->first();
    }
    if ($from == 'category') {
        $listing = DB::table('sub-categories')
            ->where('category', '=', $object->id)
            ->orderBy('name', 'ASC')
            ->lists('name', 'slug');
    }
    else {
        $listing = DB::table('sub-sub-categories')
            ->where('sub_category', '=', $object->id)
            ->orderBy('name', 'ASC')
            ->lists('name', 'slug');
    }

    return $listing;
});
/*Route::get('/api/dropdown/{table}', function ($table) {
	$txtDebug = __CLASS__."->".__FUNCTION__."(\$table) \$table - {$table}";
	$parent  = 0;
	$listing = \DB::table($table);//->orderBy('name', 'ASC');
	if ($table == "cases_types") {
		$parent = array_key_exists("department", $_REQUEST) ? $_REQUEST['department'] : 0;
		//if ($parent)
		$listing->where("department",$parent);
	} else if ($table == "departments") {
		$parent = array_key_exists("company", $_REQUEST) ? $_REQUEST['company'] : 0;
		//if ($parent)
		$listing->where("company",$parent);
	}
	$txtDebug .= "\n  \$parent - {$parent}";
	$txtDebug .= "\n  \$listing SQL - ".print_r($listing->toSql(),1).", bindings - ".print_r($listing->getBindings(),1);
	$txtDebug .= "\n  \$listing - ".print_r($listing->get(),1);

	die("<pre>{$txtDebug}</pre>");
	return $listing->lists('name', 'id');
});*/
Route::get('/api/dropdown/{table}', function ($table) {
    $txtDebug = __CLASS__."->".__FUNCTION__."(\$table) \$table - {$table}";
    $thing = array_key_exists("thing", $_REQUEST) ? $_REQUEST['thing'] : 0;;
    $listing = \DB::table($table);//->orderBy('name', 'ASC');
    if ($table == "cases_types") {
        //if ($parent)
        $listing->where("department",$thing);
    } else if ($table == "departments") {
        //if ($parent)
        $listing->where("company",$thing);
    } else if ($table == "cases_sub_types") {
        //if ($parent)
        $listing->where("case_type",$thing);
    }
    $txtDebug .= "\n  \$parent - {$thing}";
    $txtDebug .= "\n  \$listing SQL - ".print_r($listing->toSql(),1).", bindings - ".print_r($listing->getBindings(),1);
    $txtDebug .= "\n  \$listing - ".print_r($listing->get(),1);

    //die("<pre>{$txtDebug}</pre>");
    return $listing->lists('name', 'id');
});
Route::post('postChat', ['middleware' => 'auth', 'uses' => 'ChatController@postChat']);
Event::listen('auth.login', function () {
    $user               = User::find(\Auth::user()->id);
    $user->availability = 1;
    $user->last_login   = new DateTime;
    $user->save();
});
Event::listen('auth.logout', function () {
    $user               = User::find(\Auth::user()->id);
    $user->availability = 0;
    $user->last_logout  = new DateTime;
    $user->save();
});
Route::get('getLoggedInUsers', function () {
    $allUsers = User::where('id', '<>', \Auth::user()->id)->orderBy('availability', 'desc')->get();
    $html     = "";
    foreach ($allUsers as $user) {
        $availability = ($user->availability == 1) ? "<i class='fa fa-circle-o status m-r-5'></i>" : "<i class='fa fa-circle-o offline m-r-5'></i>";
        $html .= "<div class='media'>";
        $html .= "<a href='#' onClick='chatStart(this)' class='chatWith' data-userid = '$user->id' data-names = '$user->name $user->surname'> <img class='pull-left' src='img/profile-pics/7.png' width='30' alt=''></a>";
        $html .= "<div class='media-body'>";
        $html .= "<span class='t-overflow p-t-5'>$user->name  $user->surname $availability</span>";
        $html .= "</div>";
        $html .= "</div>";
    }

    return $html;
});
/*
|--------------------------------------------------------------------------
| CASE MESSAGE ROUTING
|--------------------------------------------------------------------------
|
*/
Route::post('addCaseMessage', ['middleware' => 'resetLastActive', 'uses' => 'MessageController@store']);
Route::post('sendCaseMessage', ['middleware' => 'resetLastActive', 'uses' => 'MessageController@storeEmail']);
Route::get('/getOfflineMessage', function () {
    $offlineMessages = Message::where('to', '=', \Auth::user()->id)
        ->where('online', '=', 0)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    $html = "";
    foreach ($offlineMessages as $message) {
        $user = User::where('id', '=', $message->from)->first();
        $read = ($message->read == 0) ? "<span class='label label-danger'>New</span>" : "";
        $html .= "<div class='media'>";
        $html .= "<div class='pull-left'>";
        $html .= "<a href='#' onClick='chatStart(this)'> <img class='pull-left' src='img/profile-pics/7.png' width='30' alt=''></a>";
        $html .= "</div>";
        $html .= "<div class='media-body'>";
        $html .= "<small class='text-muted'>$user->name  $user->surname - $message->created_at</small> $read<br>";
        $html .= "<a class='t-overflow' href='message-detail/$message->id'>$message->message .Ref:Case ID $message->caseId</a>";
        $html .= "</div>";
        $html .= "</div>";
    }

    return $html;
});
Route::get('message-detail/{id}', 'MessageController@edit');
Route::get('all-messages', 'MessageController@index');
/*
|--------------------------------------------------------------------------
| END CASE MESSAGE ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| AFFILIATIONS ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('middle', function () {
    echo "hello";
})->middleware('adminmiddlewar');
Route::get('list-affiliations', ['middleware' => 'UsersMilldware', function () {
    return view('affiliations.list');
}]);
Route::get('list-affiliation-positions/{affiliation}', ['middleware' => 'UsersMilldware', function ($affiliation) {
    $affiliationObj     = Affiliation::find($affiliation);
    $afflpos            = AffiliationPositions::where('affiliation', $affiliation)->first();
    $id                 = $affiliation;
    $created            = $afflpos->created_at;
    $users              = User::where('id', $afflpos->created_by)->first();
    $created_by_name    = $users->name;
    $created_by_surname = $users->surname;
    $position      = Position::where('id', $afflpos->positions)->first();
    $position_name = $position->name;

    return view('affiliations.positions', compact('affiliationObj', 'id', 'created', 'created_by_name', 'created_by_surname', 'position_name'));
}]);
Route::get('affiliations-list', ['middleware' => 'resetLastActive', 'uses' => 'AffiliationsController@index']);
Route::get('affiliations/{id}', ['middleware' => 'resetLastActive', 'uses' => 'AffiliationsController@edit']);
Route::get('affiliation-positions/{id}', ['middleware' => 'resetLastActive', 'uses' => 'AffiliationsController@getAffiliationPositions']);
Route::post('updateAffiliation', ['middleware' => 'resetLastActive', 'uses' => 'AffiliationsController@update']);
Route::post('addAffiliation', ['middleware' => 'resetLastActive', 'uses' => 'AffiliationsController@store']);
Route::post('addAffiliationPosition', ['middleware' => 'resetLastActive', 'uses' => 'AffiliationsController@addAffiliationPosition']);
/*
|--------------------------------------------------------------------------
| END PRIORITIES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('list-permissions', ['middleware' => 'resetLastActive', function () {
    return view('permissions.list');
}]);
//Route::get('permissions-list', ['middleware' => 'resetLastActive', 'uses' => 'PermissionController@index']);
Route::get('permissions/{id}', ['middleware' => 'resetLastActive', 'uses' => 'PermissionController@edit']);
Route::post('updatePermission', ['middleware' => 'resetLastActive', 'uses' => 'PermissionController@update']);
Route::get('permissions-list/{id?}', ['middleware' => 'resetLastActive', 'uses' => 'PermissionController@listPermissions']);
Route::get('getPermissions', ['middleware' => 'resetLastActive', 'uses' => 'PermissionController@show']);
Route::post('addGroupPermission', ['middleware' => 'resetLastActive', 'uses' => 'PermissionController@storeGroupPermissions']);
Route::post('removeGroupPermission', ['middleware' => 'resetLastActive', 'uses' => 'PermissionController@removeGroupPermission']);
Route::post('updateGroupPermissions', ['middleware' => 'resetLastActive', 'uses' => 'PermissionController@updateGroupPermissions']);
Route::get('list-permissions-per-group/{group}', ['middleware' => 'resetLastActive', function ($group) {
    //$deptObj = Department::find($department);
    return view('permissions.group', compact('group', $group));
}]);
Route::get('group-users-list/{id}', ['middleware' => 'resetLastActive', 'uses' => 'PermissionController@group_users_list']);
Route::get('map', ['middleware' => 'resetLastActive', 'uses' => 'MapController@index']);
Route::get('poimap/{id}', ['middleware' => 'resetLastActive', 'uses' => 'UserController@poimap']);
Route::post('session/ajaxCheck', ['uses' => 'SessionController@ajaxCheck', 'as' => 'session.ajax.check']);
Route::post('resetSession', ['uses' => 'SessionController@resetSession', 'as' => 'resetSession']);
Route::get('list-forms/{id?}', ['middleware' => 'resetLastActive', 'uses' => 'FormsController@list_forms']);
Route::get('forms-list', ['middleware' => 'resetLastActive', 'uses' => 'FormsController@index']);
Route::get('forms/{id}', ['middleware' => 'resetLastActive', 'uses' => 'FormsController@edit']);
Route::post('addForm', ['middleware' => 'resetLastActive', 'uses' => 'FormsController@store']);
Route::post('assignForm', ['middleware' => 'resetLastActive', 'uses' => 'FormsController@assign']);
Route::post('deleteForm', ['middleware' => 'resetLastActive', 'uses' => 'FormsController@delete']);
Route::post('updateForm', ['middleware' => 'resetLastActive', 'uses' => 'FormsController@update']);
Route::get('forms/database/tables', ['middleware' => 'resetLastActive', 'uses' => 'DatabaseController@getTables']);
Route::get('forms/database/tables/{name}', ['middleware' => 'resetLastActive', 'uses' => 'DatabaseController@getTable']);
Route::get('forms/database/tables/{name}/{form_id}', ['middleware' => 'resetLastActive', 'uses' => 'DatabaseController@getTable']);
Route::get('forms/database/data/{form_id}', ['middleware' => 'resetLastActive', 'uses' => 'DatabaseController@getData']);
Route::controller('list-formsdata', 'FormsDataController', array('getData' => 'formsdata.data', 'anyIndexx' => "list-formss"));
Route::get('forms/data/{id}/{form_id?}', ['middleware' => 'resetLastActive', 'uses' => 'FormsDataController@edit']);
Route::post('updateFormData', ['middleware' => 'resetLastActive', 'uses' => 'FormsDataController@update']);
/*
|--------------------------------------------------------------------------
| TASK  ROUTING
|--------------------------------------------------------------------------
|
*/
Route::resource('tasks', 'TasksController');
Route::get('getTasks', 'TasksController@getTasks');
Route::get('getAssignedByMeTasks', 'TasksController@getAssignedByMeTasks');
Route::get('tasks/update/{id}', 'TasksController@update');
Route::get('tasks/acceptTask/{id}', 'TasksController@acceptTask');
Route::get('tasks/rejectTask/{id}', 'TasksController@rejectTask');
Route::get('tasks/edit/{id}', 'TasksController@edit');
Route::post('tasks/updateTask', 'TasksController@updateTask');
Route::post('tasks/updateTaskDates', 'TasksController@updateTaskDates');
Route::get('linkNewTask/{id}', 'TasksController@create');
Route::get('linkExistingTask/{id}', 'TasksController@linkExistingTask');
Route::post('tasks/addTaskRelationship', 'TasksController@addTaskRelationship');
Route::get('getSearchTasks', ['middleware' => 'auth', 'uses' => 'TasksController@getSearchTasks']);
Route::post('caseTasks', 'TasksController@storeCaseTask');
Route::get('getCaseTasks/{id}', 'TasksController@getCaseTasks');
Route::get('CaseProfile/{id}', 'TasksController@showCaseProfile');
Route::post('dateChangeRequest', 'TasksController@storeDateChangeRequest');
Route::get('dateChangeRequest/{id}', 'TasksController@showDateRequest');
Route::get('ChangeRequest/{id}', 'TasksController@showRequestedDates');
/*
|--------------------------------------------------------------------------
| END TASKS ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| TASK CATEGORIES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::get('tasks-categories', 'TaskCategoriesController@index');
Route::post('add-task-category', 'TaskCategoriesController@store');
Route::get('delete-task-category/{id}', 'TaskCategoriesController@destroy');
Route::get('edit-task-category/', 'TaskCategoriesController@edit');
/*
|--------------------------------------------------------------------------
| END TASK CATEGORIES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| TASK NOTES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::resource('task-notes', 'TaskNoteController');
/*
|--------------------------------------------------------------------------
| END TASK NOTES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| TASK FILES ROUTING
|--------------------------------------------------------------------------
|
*/
Route::resource('taskfile', 'TaskFileController');
Route::get('task-file/{id}', 'TaskFileController@create');
/*
|--------------------------------------------------------------------------
| END TASK FILES ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| TASK ACTIVITY ROUTING
|--------------------------------------------------------------------------
|
*/
Route::resource('task-activity', 'TaskActivityController');
/*
|--------------------------------------------------------------------------
| END TASK ACTIVITY ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| TASK REMINDER ROUTING
|--------------------------------------------------------------------------
|
*/
Route::resource('task-reminder', 'TaskRemindersController');
Route::post('task-reminders', 'TaskRemindersController@store');
/*
|--------------------------------------------------------------------------
| END TASK REMINDER ROUTING
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| MAP ROUTING
|--------------------------------------------------------------------------
|
*/
//Route::get('map', function() { return view('map.map'); } );
Route::get('maps', 'MapsController@Getmaps');
Route::get('map2', function () {
    return view('cornford.map2');
});
Route::post('search', 'MapsController@search');
Route::post('searchCase', 'MapsController@searchCase');
Route::post('createMapCase', 'MapsController@storeCase');
Route::post('createMapCase', 'MapsController@storeCase');
/*
|--------------------------------------------------------------------------
| END MAP ROUTING
|--------------------------------------------------------------------------
|
*/
// VD BEGIN: Companies
Route::get('list-companies', ['middleware' => 'resetLastActive', function () {
    return view('companies.list');
}]);
Route::get('companies-list', ['middleware' => 'resetLastActive', 'uses' => 'CompanyController@index']);
Route::get('companies/{id}', ['middleware' => 'resetLastActive', 'uses' => 'CompanyController@edit']);
Route::post('updateCompany', ['middleware' => 'resetLastActive', 'uses' => 'CompanyController@update']);
// VD END: Companies
Route::any("logPIR", function () {
    $txtDebug = "logPIR";
    $idPIR    = (array_key_exists("id", $_REQUEST) && $_REQUEST['id']) ? $_REQUEST['id'] : -1;
    //$idPIR = rand(63800, 63810);
    //$idPIR = 63808;
    if ($idPIR == -1) return Response::json(array('status' => 0, 'message' => "Event ID not specified"));
    $msg  = array_key_exists("msg", $_REQUEST) ? $_REQUEST['msg'] : "";
    $msg  = "PIR: Event ID - {$idPIR}\n{$msg}";
    $attr = array('user' => 0, 'status' => 1, 'source' => 5, 'description' => $msg, 'gps_lat' => 0, 'gps_lng' => 0);
    //$attr['id'] = 63807;
    //$case = CaseReport::where("id",54);
    $exists = CaseReport::where("description", "like", "%PIR: Event ID - {$idPIR}%")->count() == 0 ? false : true;
    $txtDebug .= "\n  exists - {$exists}";//.print_r($case->toArray(),1);
    $resp = array('status' => 0, 'message' => "Trying to create case for PIR");
    if ($exists) {
        $resp = array('status' => 0, 'message' => "Exists");
    }
    else {
        $newCase = New CaseReport($attr);
        $newCase->setAttribute("department", 1);
        $newCase->setAttribute("case_type", 5);
        $newCase->setAttribute("case_sub_type", 22001);
        $txtDebug .= "\n  newCase - " . print_r($newCase->toArray(), 1);
        try {
            $newCase->save();
            $attrOwner            = array('case_id' => -1, 'user' => 10, 'type' => 5);
            $attrOwner['case_id'] = $newCase->id;
            \DB::table('cases_owners')->insert($attrOwner);
            $txtDebug .= "\n  Success saving";
            $resp = array('status' => 1, 'message' => "Created case for PIR");
        }
        catch (Exception $ex) {
            $txtDebug .= "\n  Error saving";
            $txtDebug .= "\n  " . $ex->getMessage();
            $resp = array('status' => 0, 'message' => $ex->getMessage());
        }
    }

    //$txtDebug .= "\n  case - {$case->count()}";//.print_r($case->toArray(),1);
    return Response::json($resp);
    die("<pre>{$txtDebug}</pre>");
});
Route::group(['prefix' => "api"], function () {
    Route::any("switchseen", "CasesSeenController@switchSeen");
});

/*-------------------------------------------------------------------
DRONES ROUTING
---------------------------------------------------------------------
*/


Route::group(array('prefix' => 'api/v1'), function()
{    /*|--------------------------------------------------------------------------|
    DRONE ROUTING
    |--------------------------------------------------------------------------|*/

    Route::get('userDepartment','DroneRequestController@userDepartment');
    Route::get('showDroneRequest/{id}','DroneRequestController@showFirst');
    Route::resource('drone', 'DroneRequestController');
    Route::post('firstDroneApproval/{id}', 'DroneRequestController@FirstApprove');
    Route::post('finalDroneApproval/{id}', 'DroneRequestController@Approve');
    Route::post('rejectDroneRequest/{id}', 'DroneRequestController@Reject');
    Route::get('droneSubType/{id}','DroneSubTypesController@droneSubTypes');
    Route::get('droneServiceType/{id}','DroneSubTypesController@droneServiceType');
    Route::get('droneSubServiceType/{id}','DroneSubTypesController@droneSubServiceType');
    Route::resource('drone', 'DroneRequestController');

    /*|--------------------------------------------------------------------------|
    END DRONE ROUTING
    |--------------------------------------------------------------------------|*/

    /*|--------------------------------------------------------------------------|
     DRONE TYPES AND SUB TYPES ROUTING
    |--------------------------------------------------
    ------------------------|*/


    Route::resource('drone-type','DroneTypesController');
    Route::resource('drone-sub-type','DroneSubTypesController');




    /*|--------------------------------------------------------------------------|
    END DRONE TYPES AND SUB TYPES ROUTING
    |--------------------------------------------------------------------------|*/

    //Route::get('userDepartment','DronesController@userDepartment');
});

Route::get('DroneList','DroneRequestController@getList');
Route::get('requestForm','DroneTypesController@index');
Route::get('test/{id}','DroneRequestController@test');
Route::get('getDroneRequests/{id}','DroneRequestController@getPerUser');
 Route::get('casetest/droneSubType/{id}','DroneSubTypesController@droneSubTypes');