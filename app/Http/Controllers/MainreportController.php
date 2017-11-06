<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Charts;
use  App\User;
use  App\CaseReport;
use App\CaseActivity;
use App\CaseOwner;


class MainreportController extends Controller
{

  public function index()
     {


      $chartssz =   Charts::multi('areaspline', 'highcharts')

     ->title('My nice chart')
     ->colors(['#ff0000', '#ffffff'])
     ->labels(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday', 'Sunday'])
     ->dataset('John', [3, 4, 3, 5, 4, 10, 12])

     ->dataset('Jane',  [1, 3, 4, 3, 3, 5, 4]);

       $chartss= Charts::create('geo', 'highcharts')
             ->title('Port Geo Cha')
             ->elementLabel('My nice label')
             ->labels(['AF', 'CONGO', 'RU'])
             ->colors(['#C5CAE9', '#283593'])

             ->values([5,10,20])
             ->dimensions(1000,500)
             ->responsive(true);
   //    $chart =   Charts::database(User::all(), 'bar', 'highcharts')

      $chartssz =   Charts::database(CaseActivity::all(), 'bar', 'highcharts')->dateColumn('created_at')
          //  $chart = Charts::multi('bar', 'highcharts')
          // Setup the chart settings
          ->title("Case Activity")
          // A dimension of 0 means it will take 100% of the space
          ->dimensions(0, 400) // Width x Height
          // This defines a preset of colors already done:)

          ->elementLabel("Total")
          ->dimensions(1000, 500)
          ->responsive(true)
          ->groupBy('note');

       $chartss= Charts::database(CaseOwner::all(), 'line', 'highcharts')->dateColumn('created_at')
           ->title('Case Owners')
           ->elementLabel('Total')
//           ->labels(['First', 'Second', 'Third'])
//           ->values([5,10,20])
           ->dimensions(1000,500)
           ->responsive(true)
           ->groupBy('user');
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
               //  $chart = Charts::multi('bar', 'highcharts')
               // Setup the chart settings
               ->title("Case Status")
               // A dimension of 0 means it will take 100% of the space
               ->dimensions(0, 400) // Width x Height
               // This defines a preset of colors already done:)

               ->elementLabel("Total")
               ->dimensions(1000, 500)
               ->responsive(true)



              ->groupBy('status',null,[0 => 'Pending closure cases',1 => 'Pending allocation cases', 2 => 'Pending-closure', 3 => 'Resolved cases', 4 => 'Allocated/Reffered cases', 5 => 'Preliminary' , 6 => 'Confirmed', 7 =>'allocated']);


              $charts = Charts::database(CaseReport::all(), 'donut', 'highcharts')->dateColumn('created_at')
                     //  $chart = Charts::multi('bar', 'highcharts')
                     // Setup the chart settings
                     ->title("Case Priority ")
                     // A dimension of 0 means it will take 100% of the space
                     ->dimensions(0, 400) // Width x Height
                     // This defines a preset of colors already done:)

                     ->elementLabel("Total")
                     ->dimensions(1000, 500)
                     ->responsive(true)

                    ->groupBy('priority',null,[0 => 'Normal', 1 => 'Urgent', 2 => 'Critical',3 => 'Test']);
             ///  ->labels(['One', 'Two', 'Three']);




      return view('Reports.index', ['chart' => $chart  ,'chartss' => $chartss  ,'chartssz' => $chartssz], ['charts' => $charts] );
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
         //
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
