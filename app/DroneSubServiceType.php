<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DroneSubServiceType extends Model
{
    protected $table ="drone_sub_sub_sub_types";
    public function droneServiceType()
    {
        return $this->belongsTo(DroneServiceType::class,'drone_sub_sub_type_id','id');
    }


}
