<?php
namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CaseReport;
use App\CaseOwner;
use Charts;
use  App\User;
use App\CaseActivity;
use function MongoDB\BSON\toJSON;

class HomeController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request) {
		$user = \Auth::user() ? \Auth::user()->role : 0;
		if (\Auth::check()) {
			switch ($user) {
				case   $user == 1:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->join('cases_sources', 'cases.source', '=', 'cases_sources.id')
						->join('cases_types', 'cases.case_type', '=', 'cases_types.id')
						->where('cases_statuses.name', '=', 'Allocated')
						->orWhere('cases_statuses.name', '=', 'Referred')->groupBy('cases.id')->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->join('cases_sources', 'cases.source', '=', 'cases_sources.id')
						->where('cases_statuses.name', '=', 'Pending Closure')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->join('cases_sources', 'cases.source', '=', 'cases_sources.id')
						->where('cases_statuses.name', '=', 'Resolved')
						->get();
					$numberPendingCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->join('cases_sources', 'cases.source', '=', 'cases_sources.id')
						->where('cases_statuses.name', '=', 'Pending')->get();
					break;
				case $user == 2:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '<>', 'Pending Closure')
						->where('cases_statuses.name', '<>', 'Resolved')
						->where('cases_statuses.name', '<>', 'Pending')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Pending Closure')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Resolved')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases.user', '=', \Auth::user()->id)
						->where('cases_statuses.name', '=', 'Pending')
						->get();
					break;
				case $user == 3:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '<>', 'Pending Closure')
						->where('cases_statuses.name', '<>', 'Resolved')
						->where('cases_statuses.name', '<>', 'Pending')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Pending Closure')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Resolved')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases.user', '=', \Auth::user()->id)
						->where('cases_statuses.name', '=', 'Pending')
						->get();
					break;
				case $user == 4:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '<>', 'Pending Closure')
						->where('cases_statuses.name', '<>', 'Resolved')
						->where('cases_statuses.name', '<>', 'Pending')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Pending Closure')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Resolved')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases.user', '=', \Auth::user()->id)
						->where('cases_statuses.name', '=', 'Pending')
						->get();
					break;
				case $user == 5:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '<>', 'Pending Closure')
						->where('cases_statuses.name', '<>', 'Resolved')
						->where('cases_statuses.name', '<>', 'Pending')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Pending Closure')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Resolved')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases.user', '=', \Auth::user()->id)
						->where('cases_statuses.name', '=', 'Pending')
						->get();
					break;
				case $user == 6:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '<>', 'Pending Closure')
						->where('cases_statuses.name', '<>', 'Resolved')
						->where('cases_statuses.name', '<>', 'Pending')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Pending Closure')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Resolved')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases.user', '=', \Auth::user()->id)
						->where('cases_statuses.name', '=', 'Pending')
						->get();
					break;
				case $user == 7:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '<>', 'Pending Closure')
						->where('cases_statuses.name', '<>', 'Resolved')
						->where('cases_statuses.name', '<>', 'Pending')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Pending Closure')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Resolved')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases.user', '=', \Auth::user()->id)
						->where('cases_statuses.name', '=', 'Pending')
						->get();
					break;
				case $user == 8:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '<>', 'Pending Closure')
						->where('cases_statuses.name', '<>', 'Resolved')
						->where('cases_statuses.name', '<>', 'Pending')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Pending Closure')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Resolved')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases.user', '=', \Auth::user()->id)
						->where('cases_statuses.name', '=', 'Pending')
						->get();
					break;
				case $user == 9:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '<>', 'Pending Closure')
						->where('cases_statuses.name', '<>', 'Resolved')
						->where('cases_statuses.name', '<>', 'Pending')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Pending Closure')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Resolved')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases.user', '=', \Auth::user()->id)
						->where('cases_statuses.name', '=', 'Pending')
						->get();
					break;
				case $user == 10:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '<>', 'Pending Closure')
						->where('cases_statuses.name', '<>', 'Resolved')
						->where('cases_statuses.name', '<>', 'Pending')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Pending Closure')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases_statuses.name', '=', 'Resolved')
						->where('cases.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingCases = \DB::table('cases')
						->join('cases_statuses', 'cases.status', '=', 'cases_statuses.id')
						->where('cases.user', '=', \Auth::user()->id)
						->where('cases_statuses.name', '=', 'Pending')
						->get();
					break;
				default:
					$numberReferredCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->where('cases.status', '<>', 'Pending Closure')
						->where('cases.status', '<>', 'Resolved')
						->where('cases_owners.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberPendingClosureCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->where('cases.status', '=', 'Pending Closure')
						->where('cases_owners.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
					$numberResolvedCases = \DB::table('cases')
						->join('cases_owners', 'cases.id', '=', 'cases_owners.case_id')
						->where('cases.status', '=', 'Resolved')
						->where('cases_owners.user', '=', \Auth::user()->id)
						->groupBy('cases.id')
						->get();
			}
			$userViewAllocatateReferredCasesPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 17)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userViewPendingAllocationCasesPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 18)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userViewPendingClosureCasesPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 19)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userViewResolvedCasesPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 20)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userCreateCasesPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 21)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userAllocateCasesPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 22)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userAcceptCasesPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 23)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userReferCasesPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 24)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userAddCasesNotesPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 25)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userAddCasesFilesPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 26)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userViewWorkFlowPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 27)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userCloseCasePermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 28)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userRequestCaseClosurePermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 29)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
			$userAddPoiPermission = \DB::table('group_permissions')
				->join('users_roles', 'group_permissions.group_id', '=', 'users_roles.id')
				->where('group_permissions.permission_id', '=', 30)
				->where('group_permissions.group_id', '=', \Auth::user()->role)
				->first();
//            $respomse   = array() ;
//
//            $cases_db =\DB::table('cases')
//                ->join('cases_statuses','cases_statuses.id','=','cases.status')
//                ->join('departments','departments.id','=','cases.department')
//                ->join('landingpagecharts','departments.id','=','landingpagecharts.department_id')
//                //->where('departments.id','=', 1)
//                // ->where('departments.name','=','Investigations')
//                ->select(
//                    \DB::raw("
//                                            landingpagecharts.strokeColor as strokeColor,
//                                            landingpagecharts.pointColor as pointColor,
//                                            landingpagecharts.pointStrokeColor as pointStrokeColor ,
//                                            landingpagecharts.pointHighlightFill as pointHighlightFill,
//                                            landingpagecharts.pointHighlightStroke as pointHighlightStroke,
//                                             landingpagecharts.data as data,
//                                            cases.id case_id,
//                                            cases_statuses.name as CaseStatus,
//                                            departments.name as label
//                                           "
//                    )
//                )
//                ->orderBy('label','ASC')
//                ->get(['name']);
//            foreach ($cases_db as $datavale) {
//
//                $label=$datavale->label;
//                $label_id = $datavale->case_id;
//
//
//                for($i=1; $i < 12 ; $i++) {
//                    $Investigations[]= \DB::table('cases')->whereMonth('created_at', '=', $i)
//                        ->where('department', '=', 1)->count();
//                   }
//                    $datavale->data=$Investigations;
//
//
//
//            }
//            $dip=\DB::table('departments')->first();
//            $name=$dip->name;
//
//            foreach ($cases_db as $datavale) {
//
//                $label=$datavale->label;
//                $label_id = $datavale->case_id;
//
//
//                for($i=1; $i < 12 ; $i++) {
//                    $Investigations[]= \DB::table('cases')->whereMonth('created_at', '=', $i)
//                        ->where('department', '=', 1)->count();
//                }
//                $datavale->data=$Investigations;
//
//
//            }
//                $chartssz=Charts::multi('areaspline', 'highcharts')
//                    ->elementLabel("total")
//                    ->Title( "Pending /Allocated Casses")
//                    ->colors(['#ff0000', '#3fff7f'])
//                    ->labels(['January', 'February', 'March', 'April', 'May','June', 'July','August','September','October','November','December'])
//
////                   ->dataset( $label,$Investigations)
//                    ->dataset('invest',[53,51,68,59,2,06,40,7,87,9,6,94])
//
//
//                   ->responsive(false)
//                ;
			$chartssz = Charts::multi('areaspline', 'highcharts')
				->title('My nice chart')
				->colors(['#ff0000', '#ffffff'])
				->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])
				->dataset('John', [3, 4, 3, 5, 4, 10, 12])
				->dataset('Jane', [1, 3, 4, 3, 3, 5, 4]);
			$chartss = Charts::create('geo', 'highcharts')
				->title('Port Geo Cha')
				->elementLabel('My nice label')
				->labels(['AF', 'CONGO', 'RU'])
				->colors(['#C5CAE9', '#283593'])
				->values([5, 10, 20])
				->dimensions(1000, 500)
				->responsive(true);
			//    $chart =   Charts::database(User::all(), 'bar', 'highcharts')
			$chartssz = Charts::multi('line', 'highcharts')
				->credits(false)
				//  $chart = Charts::multi('bar', 'highcharts')
				// Setup the chart settings
				->title("Pending Closure")
				->colors(['#ff0000', '#ffffff'])
				// A dimension of 0 means it will take 100% of the space
				->dimensions(0, 400)// Width x Height
				// This defines a preset of colors already done:)
				->colors(['#ff0000', '#00ff00', '#0000ff'])
				->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])
				->dataset('Investigation', [15, 24, 36, 44, 34, 78, 23])
				->dataset('Property', [10, 16, 24, 33, 24, 26, 57])
				->dataset('logistic', [15, 6, 64, 44, 65, 32, 43])
//
//                ->elementLabel("Total")
//                ->dimensions(1000, 500)
				->responsive(true);
//            $chartss= Charts::database(CaseOwner::all(), 'line', 'highcharts')->dateColumn('created_at')
//                ->title('Resolve Cases')
//                ->elementLabel('Total')
			//      ->labels(['First', 'Second', 'Third'])
//           ->values([5,10,20])
			$chartss = Charts::database(CaseReport::all(), 'line', 'highcharts')->dateColumn('created_at')
				->credits(false)
				->title('Resolved Cases')
				->elementLabel('Total')
				->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])
				->values([5, 10, 20, 56, 23, 65])
				->dimensions(1000, 500)
				->responsive(true);
//                ->groupBy('name');
			//    $chart =   Charts::database(User::all(), 'bar', 'highcharts')
//         $caseStatus=\DB::table('cases')
//             ->join('cases_statuses','cases.status','=','cases_statuses.id')
//             ->select(\DB::raw("
//             cases_statuses.name as status,
//             cases.id ,
//              cases.priority,
//              cases.department
//             "))->get();
//
//         dd($caseStatus);
			$chart = Charts::database(CaseReport::all(), 'bar', 'highcharts')->dateColumn('created_at')
				->credits(false)
				//  $chart = Charts::multi('bar', 'highcharts')
				// Setup the chart settings
				->title("Pending /Allocation Cases")
				->title("Case Status")
				// A dimension of 0 means it will take 100% of the space
				// This defines a preset of colors already done:)
				->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])
				->elementLabel("Total")
				->dimensions(1000, 500)
				->responsive(true)
				->groupBy('status', null, [0 => 'Pending closure', 1 => 'Pending', 2 => 'Pending-closure', 3 => 'Resolved', 4 => 'Referred', 5 => 'Preliminary', 6 => 'Confirmed', 7 => 'Allocated']);//->groupBy('status',null,[0 => 'logistic',1 => 'Property', 2 => '', 3 => 'investigation', 4 => 'Logistic', 5 => 'Preliminary' , 6 => 'Confirmed', 7 =>'allocated'])
			;
			$chartTasks = Charts::database(\App\Task::where('created_by', '=', \Auth::check() ? \Auth::id() : -1)->get(), 'donut', 'highcharts')->dateColumn('created_at');
			$chartTasks->title("Tasks");
			$chartTasks->groupBy("status_id", null, [1 => "New", 2 => "Closed", 3 => "Declined"]);
			$charts = Charts::database(CaseReport::all(), 'donut', 'highcharts')->dateColumn('created_at')
				//  $chart = Charts::multi('bar', 'highcharts')
				// Setup the chart settings
				->title("Pending /Allocation Cases")
				->credits(false)
				->title("Pending /Allocated Cases ")
				// A dimension of 0 means it will take 100% of the space
				->dimensions(0, 400)// Width x Height
				// This defines a preset of colors already done:)
				->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])
				->elementLabel("Total")
				->dimensions(1000, 500)
				->responsive(true)
				->groupBy('priority', null, [0 => 'Investigation', 1 => 'Property', 2 => 'Critical', 3 => 'Agriculture']);

			return view('home.home', compact('userAddPoiPermission', 'chart ', 'chartss', 'chart', 'chartssz', 'charts', 'userRequestCaseClosurePermission', 'userCloseCasePermission', 'userViewWorkFlowPermission', 'userAddCasesNotesPermission', 'userAddCasesFilesPermission', 'userReferCasesPermission', 'userAcceptCasesPermission', 'userAllocateCasesPermission', 'userCreateCasesPermission', 'userViewAllocatateReferredCasesPermission', 'userViewPendingAllocationCasesPermission', 'userViewPendingClosureCasesPermission', 'userViewResolvedCasesPermission', 'numberReferredCases', 'numberPendingClosureCases', 'numberResolvedCases', 'numberPendingCases', 'chartTasks'));
			/// ['chart' => $chart  ,'chartss' => $chartss  ,'chartssz' => $chartssz], ['charts' => $charts]
		}
		else {
			\Auth::logout();
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getcharts() {
		$respomse = array();
		$cases_db = \DB::table('cases')
			->join('cases_statuses', 'cases_statuses.id', '=', 'cases.status')
			->join('departments', 'departments.id', '=', 'cases.department')
			->join('landingpagecharts', 'departments.id', '=', 'landingpagecharts.department_id')
			//->where('departments.id','=', 1)
			// ->where('departments.name','=','Investigations')
			->select(
				\DB::raw("
                                            landingpagecharts.strokeColor as strokeColor,
                                            landingpagecharts.pointColor as pointColor,
                                            landingpagecharts.pointStrokeColor as pointStrokeColor ,
                                            landingpagecharts.pointHighlightFill as pointHighlightFill,
                                            landingpagecharts.pointHighlightStroke as pointHighlightStroke,
                                             landingpagecharts.data as data,
                                            cases.id case_id,
                                            cases_statuses.name as CaseStatus,
                                            departments.name as label
                                           "
				)
			)
			->orderBy('label', 'ASC')
			->get(['name']);
//            foreach ($cases_db as $datavale) {
//
//
//                $label_id = $datavale->case_id;
//
//                if($datavale->label == "Investigations") {
//                    $datavale->data=[6,54,30,54,90,1,9,0,32,6,82,60];
////                for($i=1; $i < 12 ; $i++) {
////                    $Investigations[]= \DB::table('cases')->whereMonth('created_at', '=', $i)
////                        ->where('department', '=', 1)->count();
////                   }
////                    $datavale->data=$Investigations;
//                }else{
//                    $datavale->data=[2,5,43,65,78,21,9,32,53,7,8,76];
//                }
//
//
//
//            }
//
//
//  return $cases_db;
////            $respomse['data'] =   $cases_db;
////            $respomse['erro'] =  true ;
	}

	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request $request
	 *
	 * @return Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request $request
	 * @param  int     $id
	 *
	 * @return Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id) {
		//
	}
}
