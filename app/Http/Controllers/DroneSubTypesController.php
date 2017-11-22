<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\DroneSubType;
use App\DroneServiceType;
use App\DroneSubServiceType;
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
    public function droneServiceType($id)
    {
        $droneServiceTypes = DroneServiceType::with('droneSubType')->where('drone_sub_type_id',$id)->get();
        return $droneServiceTypes;
    }
    public function droneSubServiceType($id)
    {
        $droneServiceTypes = DroneSubServiceType::with('droneServiceType')->where('drone_sub_sub_type_id',$id)->get();
        return $droneServiceTypes;
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
