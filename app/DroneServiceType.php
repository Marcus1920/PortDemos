<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DroneServiceType extends Model
{
    protected  $table = "drone_sub_sub_types";

    public function droneSubType()
    {
        return $this->belongsTo(DroneSubType::class,'drone_sub_type_id','id');
    }
    public function droneSubServiceType()
    {
        return $this->hasMany(DroneSubServiceType::class);
    }

}
