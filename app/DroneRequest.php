<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DroneRequest extends Model
{
    public function User()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function DroneType()
    {
        return $this->belongsTo(DroneType::class,'drone_type_id','id');
    }

    public function DroneSubType()
    {
        return $this->belongsTo(DroneSubType::class,'sub_drone_type_id','id');
    }

    public function DroneCaseStatus()
    {
        return $this->belongsTo(DroneApprovalStatus::class,'drone_case_status','id');
    }

    public function Department()
    {
        return $this->belongsTo(Department::class,'department','id');
    }

    public function RejectReason()
    {
        return $this->belongsTo(DroneRejectReason::class,'reject_reason','id');
    }


}
