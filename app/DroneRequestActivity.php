<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DroneRequestActivity extends Model
{

    public function DroneRequest()
    {
        return $this->belongsTo(DroneRequest::class,'drone_request_id','id');
    }

    public function User()
    {
        return $this->belongsTo(User::class,'user','id');
    }

}
