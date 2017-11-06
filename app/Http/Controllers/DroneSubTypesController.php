<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DroneSubType;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DroneSubTypesController extends Controller
{
    public function index()
    {
        $droneSubType = DroneSubType::with('DroneType')->get();

        return $droneSubType;
    }

    public function droneSubTypes($id)
    {
        $droneSubTypes = DroneSubType::with('DroneType')
            ->where('drone_type_id',$id)
            ->get();

        return $droneSubTypes;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
