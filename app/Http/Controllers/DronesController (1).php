<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DronesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function create()
    {
        return view('drones.droneRequest');

    }


    public function store(Request $request)
    {

    }


    public function userDepartment()
    {

        $searchString           = \Input::get('q');
        $userDepartment          = \DB::table('departments')
            ->whereRaw(
                "CONCAT(`departments`.`id`, ' ', `departments`.`name`) LIKE '%{$searchString}%'")
            ->select(
                array

                (
                    'departments.id as id',
                    'departments.name as name',
                )
            )

            ->get();

        $data = array();

        foreach ($userDepartment as $department) {

            $data[] = array(

                "id"     => "{$department->id}",
                "name"   => "Department ID: {$department->id} >  Name: {$department->name}",
            );
        }

        return $data;

    }


    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {
        //
    }
}
