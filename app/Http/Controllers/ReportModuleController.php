<?php

namespace App\Http\Controllers;


use App\CaseType;
use App\CaseReport;
use App\Reporter;
use App\userPermission;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Department;
use App\AmineCase;
use App\Company;
use App\User;
use App\ CaseStatus;
use Charts;
use Carbon\Carbon;
use App\Http\Requests\valRequest;

class ReportModuleController extends Controller
{
    //Retrieving data from database to a view
    public function index()
    {
        $department_list = DB::table('departments')->orderBy('name', 'ASC')->get();
        $cases_statuses = DB::table('cases_statuses')->orderBy('name', 'ASC')->get();
        $municipalit_list = DB::table('companies')->orderBy('name', 'ASC')->get();
        $categories = DB::table('categories')->orderBy('name', 'ASC')->get();
        return view('reportModule.reportModule', compact('cases_statuses', 'department_list', 'municipalit_list', 'categories'));
    }

    public function departments()
    {
        $department_list = DB::table('departments')->get();
        return $department_list;
    }

    public function municipality()
    {
        $municipalit_list = DB::table('municipalities')->get();
        return $municipalit_list;
    }

    public function depart()
    {
        $departments = DB::table('cases_statuses')->get();
        return view('reportModule.reportChart', compact('departments', 'i'));
    }

    //Example of retrieving  data from a view
    public function trying(Request $request)
    {
        print_r($request->name);
    }

    //Storing data selectd from the view
    public function store(Request $request)
    {
        $this->validate(request(), [
            'start' => 'required',
            'end' => 'required',
            'graph' => 'required',
            'rep_ov' => 'required',
            'case_repost' => 'required',
            'responder' => 'required',
            'categories' => 'required',
        ]);

        $municipality = $request['selectedPrecict'];
        $department = $request['selectedDepartment'];
        $report_status = $request['case_repost'];
        $type_graph = $request['graph'];
        $report_overview = $request['rep_ov'];
        $reponder = $request['responder'];
        $category = $request['categories'];

        $start = Carbon::parse($request['start']);
        $end = Carbon::parse($request['end']);
        $min;
        $max;
        $total_cases = 0;
        $total_case_open = 0;
        $logest_case = 0;
        $shortest_case = 0;
        $average_case = 0;
        $bar_chart = null;
        $line_chart = null;
        $pie_chart = null;

        //totaL number of cases 1
        foreach ($report_overview as $key) {

            //total number of cases
            if ($key == "total-case") {
                $data = AmineCase::join('municipalities', 'municipalities.id', '=', 'cases.municipality')
                    ->join('departments', 'departments.id', '=', 'cases.department')
                    ->select('cases.id', 'cases.description')
                    ->whereIn('municipalities.name', $municipality)
                    ->whereIn('departments.name', $department)
                    ->get();
                $total_cases = count($data);
                return $total_cases;
            }
            // total number of open and closed cases
            if ($key == "total-open") {
                $data = AmineCase::join('municipalities', 'municipalities.id', '=', 'cases.municipality')
                    ->join('departments', 'departments.id', '=', 'cases.department')
                    ->select('cases.id')
                    ->whereIn('municipalities.name', $municipality)
                    ->whereIn('departments.name', $department)
                    ->where('cases.closed_at', 'NOT LIKE', '%0000-00-00%')
                    ->where('cases.active', '=', '1')
                    ->get();
                $total_case_open = count($data);
                // return $total_case_open;
            }
            //longest days to close a case
            if ($key == "longest-case") {
                $data = AmineCase::join('municipalities', 'municipalities.id', '=', 'cases.municipality')
                    ->join('departments', 'departments.id', '=', 'cases.department')
                    ->select('cases.description as case', DB::raw('DATEDIFF(cases.closed_at,cases.created_at) as days'))
                    ->whereIn('municipalities.name', $municipality)
                    ->whereIn('departments.name', $department)
                    ->where('cases.created_at', '>=', $start)
                    ->where('cases.closed_at', '<=', $end)
                    ->get();
                $logest_case = $data->pluck('days')->max();
                // return $logest_case;
            }
            //shortest days to close a case
            if ($key == "short-case") {
                $data2 = AmineCase::join('municipalities', 'municipalities.id', '=', 'cases.municipality')
                    ->join('departments', 'departments.id', '=', 'cases.department')
                    ->select(DB::raw('min(DATEDIFF(cases.closed_at,cases.created_at)) as min'))
                    ->whereIn('departments.name', $department)
                    ->whereIn('municipalities.name', $municipality)
                    ->where('cases.created_at', '>=', $start)
                    ->where('cases.closed_at', '<=', $end)
                    ->get();
                $shortest_case = $data2->pluck('min')->min();
                // return $shortest_case;
            }
            // average days to close case
            if ($key == "avg-case") {
                $data = AmineCase::join('municipalities', 'municipalities.id', '=', 'cases.municipality')
                    ->join('departments', 'departments.id', '=', 'cases.department')
                    ->select('cases.id', DB::raw('DATEDIFF(cases.closed_at,cases.created_at) as days'))
                    ->whereIn('municipalities.name', $municipality)
                    ->whereIn('departments.name', $department)
                    ->where('cases.created_at', '>=', $start)
                    ->where('cases.closed_at', '<=', $end)->get();

                $data2 = AmineCase::join('municipalities', 'municipalities.id', '=', 'cases.municipality')
                    ->join('departments', 'departments.id', '=', 'cases.department')
                    ->select(DB::raw('min(DATEDIFF(cases.closed_at,cases.created_at)) as min'))
                    ->whereIn('municipalities.name', $municipality)
                    ->whereIn('departments.name', $department)
                    ->where('cases.created_at', '>=', $start)
                    ->where('cases.closed_at', '<=', $end)->get();

                $min = $data2->pluck('min')->min();
                $max = $data->pluck('days')->max();
                $length = $max + $min;
                $average_case = $length / 2;
                // return $average_case;
            }
        }

        foreach ($type_graph as $value) {
            if ($value == "bar") {
                $bar_chart = Charts::create('bar', 'highcharts')
                    ->title('Number of Cases and Days')
                    ->labels(['Number of Cases', 'Open And Closed Cases', 'Longest Case', 'Shortest', 'Average Case'])
                    ->values([$total_cases, $total_case_open, $logest_case, $shortest_case, $average_case])
                    ->dimensions(500, 350)
                    ->responsive(false);
            }
            if ($value == "line") {
                $line_chart = Charts::create('line', 'highcharts')
                    ->title('Number of Cases and Days')
                    ->labels(['Number of Cases', 'Open And Closed Cases', 'Longest Case', 'Shortest', 'Average Case'])
                    ->values([$total_cases, $total_case_open, $logest_case, $shortest_case, $average_case])
                    ->dimensions(500, 350)
                    ->responsive(false);
            }
            if ($value == "pie") {
                $pie_chart = Charts::create('pie', 'highcharts')
                    ->title('Number of Cases and Days')
                    ->labels(['Number of Cases', 'Open And Closed Cases', 'Longest Case', 'Shortest', 'Average Case'])
                    ->values([$total_cases, $total_case_open, $logest_case, $shortest_case, $average_case])
                    ->dimensions(500, 350)
                    ->responsive(false);
            }
            // if($value == "column")
            //   {
            //       $chart = Charts::create('column', 'highcharts')
            //       ->title('Number of Cases and Days')
            //       ->labels(['Number of Cases','Open And Closed Cases','Longest Case','Shortest','Average Case'])
            //       ->values([$total_cases,$total_case_open,$logest_case,$shortest_case,$average_case])
            //       ->dimensions(400,500)
            //       ->responsive(false);
            //       return view('amyView.myview',['chart' => $chart]);
            //   }
        }
        return view('reportModule.reportChart', compact('line_chart', 'bar_chart', 'pie_chart'));
    }
    public function reportsDemo()
    {
        $companies = Company::orderBy('name')->get();
        $statuses = CaseStatus::orderBy('name')->get();
        $reporters = Reporter::orderBy('name')->get();
        return view('reports.generateReport', compact('companies', 'statuses','reporters'));
    }
    public function generateReport(Request $request)
    {
//        $request->fromDate;
//        $request->toDate;
//        $request->company;
//        $request->department;
//        $request->category;
//        $request->status;
//        $reporter->reporter;
//        $request->graph;
//        $request->statuses;
//        $request->overviewReport;

        //return $request->all();

        $this->validate(request(),
            [
            'fromDate' => 'required',
            'toDate' => 'required',
            'company' => 'required',
            'department' => 'required',
            'category' => 'required',
            'reporter' => 'required',
            'graphs' => 'required'
            ]);

        $companyDetails =    Company::where('id', $request->company)->first();
       //$reporterId    =     Reporter::where('id',$request->reporter)->value('id');

        $dptDetails =        Department::where('name', $request->department)->first();
        $catDetails =        CaseType::where('name', $request->category)->first();

        $queryCases =        CaseReport::where('id_company', $request->company)
                                ->where('department', $dptDetails->id)
                                ->where('case_type', $catDetails->id)
                                ->whereBetween('created_at', [$request->fromDate, $request->toDate])
                                ->where('reporter',$request->reporter )
                                ->get();
        //return $queryCases;
        if(strlen($queryCases)>2)
        {
            if($request->overviewReport == 'totalCases')
            {
                foreach ($queryCases as $casePerStatus)
                {
                    if ($casePerStatus->status == 1)
                    {
                        $newCases = CaseReport::where('id_company', $request->company)
                            ->where('department', $dptDetails->id)
                            ->where('case_type', $catDetails->id)
                            ->whereBetween('created_at', [$request->fromDate, $request->toDate])
                            ->where('reporter',  $request->reporter )
                            ->where('status', 1)
                            ->get();
                        $one = count($newCases);
                    }
                    if ($casePerStatus->status == 2) {
                        $newCases = CaseReport::where('id_company', $request->company)
                            ->where('department', $dptDetails->id)
                            ->where('case_type', $catDetails->id)
                            ->whereBetween('created_at', [$request->fromDate, $request->toDate])
                            ->where('reporter', $request->reporter)
                            ->where('status', 2)
                            ->get();

                        $two = count($newCases);
                    }
                    if ($casePerStatus->status == 3) {
                        $newCases = CaseReport::where('id_company', $request->company)
                            ->where('department', $dptDetails->id)
                            ->where('case_type', $catDetails->id)
                            ->whereBetween('created_at', [$request->fromDate, $request->toDate])
                            ->where('reporter', $request->reporter)
                            ->where('status', 3)
                            ->get();
                        $three = count($newCases);
                    }
                    if ($casePerStatus->status ==4 )
                    {
                        $newCases = CaseReport::where('id_company', $request->company)
                            ->where('department', $dptDetails->id)
                            ->where('case_type', $catDetails->id)
                            ->whereBetween('created_at', [$request->fromDate, $request->toDate])
                            ->where('reporter', $request->reporter)
                            ->where('status', 4)
                            ->get();
                        $four = count($newCases);
                    }
                    if ($casePerStatus->status == 5)
                    {
                        $newCases = CaseReport::where('id_company', $request->company)
                            ->where('department', $dptDetails->id)
                            ->where('case_type', $catDetails->id)
                            ->whereBetween('created_at', [$request->fromDate, $request->toDate])
                            ->where('reporter', $request->reporter)
                            ->where('status', 5)
                            ->get();
                        $five = count($newCases);
                    }
                    if ($casePerStatus->status ==6)
                    {
                        $newCases = CaseReport::where('id_company', $request->company)
                            ->where('department', $dptDetails->id)
                            ->where('case_type', $catDetails->id)
                            ->whereBetween('created_at', [$request->fromDate, $request->toDate])
                            ->where('reporter', $request->reporter)
                            ->where('status', 6)
                            ->get();
                        $six = count($newCases);
                    }
                    if ($casePerStatus->status ==7)
                    {
                        $newCases = CaseReport::where('id_company', $request->company)
                            ->where('department', $dptDetails->id)
                            ->where('case_type', $catDetails->id)
                            ->whereBetween('created_at', [$request->fromDate, $request->toDate])
                            ->where('reporter', $request->reporter)
                            ->where('status', 7)
                            ->get();
                        $seven = count($newCases);
                    }

                }

                foreach($request->graphs as $value)
                {
                    if ($value == "bar")
                    {
                        $bar_chart = Charts::create('bar', 'highcharts')
                            ->title($companyDetails->name."(".$dptDetails->name.")"." "."["." ".$request->fromDate." ". "to"." ".$request->toDate."]")
                            ->labels(['Pending', 'Pending Closure', 'Resolved', 'Referred', 'Preliminary','Confirmed','Allocated'])
                            ->values([$one, $two, $three, $four, $five,$six,$seven])
                            ->elementLabel("Total")
                            ->dimensions(1000, 500)
                            ->responsive(true);
                    }
                    if ($value == "line")
                    {
                        $line_chart = Charts::create('line', 'highcharts')
                            ->title($companyDetails->name."(".$dptDetails->name.")"." "."["." ".$request->fromDate." ". "to"." ".$request->toDate."]")
                            ->labels(['Pending', 'Pending Closure', 'Resolved', 'Referred', 'Preliminary','Confirmed','Allocated'])
                            ->values([$one, $two, $three, $four, $five,$six,$seven])
                            ->elementLabel("Total")
                            ->dimensions(1000, 500)
                            ->responsive(true);
                    }
                    if ($value == "pie")
                    {
                        $pie_chart = Charts::create('pie', 'highcharts')
                            ->title($companyDetails->name."(".$dptDetails->name.")"." "."["." ".$request->fromDate." ". "to"." ".$request->toDate."]")
                            ->labels(['Pending', 'Pending Closure', 'Resolved', 'Referred', 'Preliminary','Confirmed','Allocated'])
                            ->values([$one, $two, $three, $four, $five,$six,$seven])
                            ->elementLabel("Total")
                            ->dimensions(1000, 500)
                            ->responsive(true);
                    }
                    }

                return view('reportModule.reportChart', compact('line_chart', 'bar_chart', 'pie_chart'));

            }
            if($request->overviewReport == 'openClose')
            {
                foreach ($queryCases as $casePerStatus)
                {
                    //return $casePerStatus->status;
                    if($casePerStatus->status == 1)
                    {
                        $newCases = CaseReport::where('id_company', $request->company)
                            ->where('department', $dptDetails->id)
                            ->where('case_type', $catDetails->id)
                            ->whereBetween('created_at', [$request->fromDate, $request->toDate])
                            ->where('reporter', $request->reporter)
                            ->where('status', 1)
                            ->get();
                        $totalPendingCases = count($newCases);
                    }

                    if($casePerStatus->status == 3)
                    {
                        $newCases = CaseReport::where('id_company', $request->company)
                            ->where('department', $dptDetails->id)
                            ->where('case_type', $catDetails->id)
                            ->whereBetween('created_at', [$request->fromDate, $request->toDate])
                            ->where('reporter', $request->reporter)
                            ->where('status', 3)
                            ->get();

                        $totalResolvedCases = count($newCases);

                    }

                }
                foreach($request->graphs as $value)
                {
                    if ($value == "bar") {
                        $bar_chart = Charts::create('bar', 'highcharts')
                            ->title($companyDetails->name."(".$dptDetails->name.")"." "."["." ".$request->fromDate." ". "to"." ".$request->toDate."]")
                            ->labels(['Pending','Resolved'])
                            ->values([$totalPendingCases, $totalResolvedCases])
                            ->elementLabel("Total")
                            ->dimensions(1000, 500)
                            ->responsive(true);

                    }

                    if ($value == "line") {
                        $line_chart = Charts::create('line', 'highcharts')
                            ->title($companyDetails->name."(".$dptDetails->name.")"." "."["." ".$request->fromDate." ". "to"." ".$request->toDate."]")
                            ->labels(['Pending', 'Resolved'])
                            ->values([$totalPendingCases, $totalResolvedCases])
                            ->elementLabel("Total")
                            ->dimensions(1000, 500)
                            ->responsive(true);


                    }
                    if ($value == "pie") {
                        $pie_chart = Charts::create('pie', 'highcharts')
                            ->title($companyDetails->name."(".$dptDetails->name.")"." "."["." ".$request->fromDate." ". "to"." ".$request->toDate."]")
                            ->labels(['Pending', 'Resolved'])
                            ->values([$totalPendingCases, $totalResolvedCases])
                            ->elementLabel("Total")
                            ->dimensions(1000, 500)
                            ->responsive(true);
                    }

                }

                return view('reportModule.reportChart', compact('line_chart', 'bar_chart', 'pie_chart'));
            }
        }
        else
        {

            $notification = array(
                'message'=>' No data set for this select.Try again!',
                'alert-type'=>'danger'
            );

            return back()->with($notification);
        }
        //return $arrayElementTotal;

    }
}
