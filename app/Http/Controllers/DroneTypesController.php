<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DroneType;
use App\DroneSubType;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DroneTypesController extends Controller
{

    public function index()
    {
        $droneTypes=DroneType::with('Department')->get();
        return view('drones.droneRequest',compact('droneTypes'));
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

    }
}
