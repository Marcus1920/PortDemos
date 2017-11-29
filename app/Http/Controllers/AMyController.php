<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\amineDepartmentModel;
use App\Department;
use App\AmineCase;
use App\ CaseStatus;
use Charts;
use Carbon\Carbon;
use App\Http\Requests\valRequest;

class AMyController extends Controller
{
    //Retrieving data from database to a view
    public function index()
    {
         $department_list  = DB::table('departments')->orderBy('name','ASC')->get();
         $cases_statuses   = DB::table('cases_statuses')->orderBy('name','ASC')->get();
         $municipalit_list = DB::table('municipalities')->orderBy('name','ASC')->get();
         $categories       = DB::table('sub_categories')->orderBy('name','ASC')->get();               
         return view('amyView.report', compact('cases_statuses','department_list','municipalit_list','categories'));
    }
    //Retrieving data from database to java script
     public function departments()
    {
         $department_list  = DB::table('departments')->get();
        
         return $department_list;
    }
    //Retrieving data from database to java script
    public function municipality()
    {
        $municipalit_list = DB::table('municipalities')->get();
        
         return $municipalit_list;
    }
    //Example
    public function depart()
    {
        $departments = DB::table('cases_statuses')->get();
        
        return view('amyView.myview', compact('departments','i'));
    }
    //Example of retrieving  data from a view 
    public function trying(Request $request)
    {
        print_r($request->name);
    }

    //Storing data selectd from the view
    public function store(Request $request)
    {
        $this->validate(request(),[
          'start' => 'required',
          'end' => 'required',
          'graph' => 'required',
          'rep_ov' => 'required',
          'case_repost' => 'required',
          'responder' => 'required',
          'categories' => 'required',
        ]);
        $municipality    = $request['selectedPrecict'];
        $department      = $request['selectedDepartment'];
        $report_status   = $request['case_repost'];
        $type_graph      = $request['graph'];
        $report_overview = $request['rep_ov'];
        $reponder        = $request['responder'];
        $category        = $request['categories'];
       
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
        $pie_chart ;

        //totaL number of cases 1
        foreach ($report_overview as $key) 
        {
            //total number of cases
            if($key == "total-case" )
            {
                $data = AmineCase::join('municipalities','municipalities.id' ,'=', 'cases.municipality')
                ->join('departments', 'departments.id','=','cases.department')
                ->select('cases.id','cases.description')
                ->whereIn('municipalities.name',$municipality)
                ->whereIn('departments.name',$department)              
                ->get();
                $total_cases = count($data);
                // return $total_cases;
            }
            // total number of open and closed cases
            if($key == "total-open")
            {
                $data = AmineCase::join('municipalities','municipalities.id' ,'=', 'cases.municipality')
                ->join('departments', 'departments.id','=','cases.department')
                ->select('cases.id')
                ->whereIn('municipalities.name',$municipality)
                ->whereIn('departments.name',$department)
                ->where('cases.closed_at','NOT LIKE','%0000-00-00%')
                ->where('cases.active','=','1')
                ->get();
                 $total_case_open = count($data);
                // return $total_case_open;
            }
            //longest days to close a case
            if($key == "longest-case")
            {
               $data = AmineCase::join('municipalities','municipalities.id','=','cases.municipality')
               ->join('departments', 'departments.id','=','cases.department')
               ->select('cases.description as case', DB::raw('DATEDIFF(cases.closed_at,cases.created_at) as days'))
               ->whereIn('municipalities.name',$municipality)
               ->whereIn('departments.name',$department)
               ->where ('cases.created_at' , '>=' , $start)
               ->where ('cases.closed_at' , '<=' , $end)
               ->get();
               if($data->pluck('days')->max() == ""){
                    $logest_case=0;
                }
            }
            //shortest days to close a case
            if($key == "short-case")
            {
                $data2 = AmineCase::join('municipalities','municipalities.id','=','cases.municipality')
                ->join('departments','departments.id','=','cases.department')
                ->select(DB::raw('min(DATEDIFF(cases.closed_at,cases.created_at)) as min'))
                ->whereIn('departments.name',$department)
                ->whereIn('municipalities.name',$municipality)
                ->where ('cases.created_at' , '>=' , $start)
                ->where ('cases.closed_at' , '<=' , $end)
                ->get();
                if( $data2->pluck('min')->min() == " ")
                 {
                     $shortest_case =0;
                 }
            }
            // average days to close case
            if($key == "avg-case")
            {
                $data = AmineCase::join('municipalities','municipalities.id','=','cases.municipality')
                ->join('departments','departments.id','=','cases.department')
                ->select('cases.id', DB::raw('DATEDIFF(cases.closed_at,cases.created_at) as days'))
               ->whereIn('municipalities.name',$municipality)
               ->whereIn('departments.name',$department)
               ->where ('cases.created_at' , '>=' , $start)
               ->where ('cases.closed_at' , '<=' , $end)->get();

               $data2 = AmineCase::join('municipalities','municipalities.id','=','cases.municipality')
               ->join('departments','departments.id','=','cases.department')
               ->select(DB::raw('min(DATEDIFF(cases.closed_at,cases.created_at)) as min'))
               ->whereIn('municipalities.name',$municipality)
               ->whereIn('departments.name',$department)
               ->where ('cases.created_at' , '>=' , $start)
               ->where ('cases.closed_at' , '<=' , $end)->get();

                $min = $data2->pluck('min')->min();
                $max = $data->pluck('days')->max();
                $length = $max + $min;
                $average_case  = $length/2;
            }
        }      
        foreach ($type_graph as  $value) 
        {
          if($value == "bar")
            {
                $bar_chart = Charts::create('bar', 'highcharts')
                ->title('Number of Cases and Days')
                ->labels(['Number of Cases','Open And Closed Cases','Longest Case','Shortest','Average Case'])
                ->values([$total_cases,$total_case_open,$logest_case,$shortest_case,$average_case])
                ->dimensions(500,350)
                ->responsive(false);
               
            }
          if($value == "line")
            {
                $line_chart = Charts::create('line', 'highcharts')
                ->title('Number of Cases and Days')
                ->labels(['Number of Cases','Open And Closed Cases','Longest Case','Shortest','Average Case'])
                ->values([$total_cases,$total_case_open,$logest_case,$shortest_case,$average_case])
                ->dimensions(500,350)
                ->responsive(false);          
            }         
          if($value == "pie")
            {
                $pie_chart = Charts::create('pie', 'highcharts')
                ->title('Number of Cases and Days')
                ->labels(['Number of Cases','Open And Closed Cases','Longest Case','Shortest','Average Case'])
                ->values([$total_cases,$total_case_open,$logest_case,$shortest_case,$average_case])
                ->dimensions(500,350)
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
        return view('amyView.myview',compact('line_chart','bar_chart','pie_chart'));       
    }
}
