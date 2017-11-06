<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Department;

class DroneType extends Model
{
    public function Department()
    {
        return $this->belongsTo(Department::class,'department','id');
    }

}
