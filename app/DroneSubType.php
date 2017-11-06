<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DroneType;

class DroneSubType extends Model
{
    public function DroneType()
    {
        return $this->belongsTo(DroneType::class,'drone_type_id','id');
    }
}
