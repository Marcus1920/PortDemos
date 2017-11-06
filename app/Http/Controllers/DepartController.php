<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Department;
use App\CaseType;
use App\CaseSubType;
use App\User;
use App\UserNew;
class DepartController extends Controller
{


  private $CaseType;


     public function __construct(CaseType $CaseType)
     {

         $this->CaseType = $CaseType;

     }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */


	  public   function  mobiledepartement ()

	 {

		 $mobiledepartement   =   Department::all() ;

		 return  Response()->json($mobiledepartement);

	 }


	 public   function  mobilecategories ()

	 {

		 $mobiecategories   =   CaseType::all() ;

		 return  Response()->json($mobiecategories);

	 }


	 public   function  mobilesubcategories ()

	 {

		 $mobieSubCategories   =   CaseSubType::all() ;

		 return  Response()->json($mobieSubCategories);

	 }

	  public   function  mobilesusubbcategories ()

	 {

		 $mobilesusubbcategories   =   CaseSubType::all() ;

		 return  Response()->json($mobilesusubbcategories);

	 }



        public function index()
    {
      $headers  = apache_request_headers();
        $response = array();

      $toke  = "12";

            if ($toke=="12") {

                    $categories          = $this->CaseType->groupBy('name')->get();
                    $subCategories       = array();
                    foreach ($categories as $categorys) {

                        $subCategories['id']     = $categorys['id'];
                        $subCategories['name']   = $categorys['name'];
                        $otherSubCats           = CaseType::where('name','=',$categorys['name'])
                                                                        ->select('id')
                                                                        ->get();


                        $subCatsIds = array();

                        if (sizeof($otherSubCats) >= 1 ) {


                            foreach ($otherSubCats as $value) {

                                $subCatsIds[] = $value->id;

                            }


                        }

                        $subCats                 = CaseSubType::whereIn('case_type',$subCatsIds)->get();
                        $tmpArrayAll             = [];

                        foreach ($subCats as $subCat) {

                            $tmpArray['cat_id'] = $categorys['id'];
                            $tmpArray['id']     = $subCat['id'];
                            $tmpArray['name']   = $subCat['name'];


                            $otherSubSubCats    = CaseSubType::where('name','=', $subCat['name'])
                                                                        ->select('id')
                                                                        ->get();


                            $subSubCatsIds = array();

                            if (sizeof($otherSubSubCats) >= 1 ) {


                                foreach ($otherSubSubCats as $value) {

                                    $subSubCatsIds[] = $value->id;

                                }


                            }




                        }
                        $subCategories['subs'] = $tmpArrayAll;
                        $tmp[]                 = $subCategories;
                    }

                    $response ['categories'] = $tmp;
                //    $response['error'] = FALSE;
                    return \Response::json($response,200);
            }
            else {
                $response['message'] = 'Access Denied. Invalid Api key';;
                $response['error'] = TRUE;
                return \Response::json($response,401);
        }


}



}
