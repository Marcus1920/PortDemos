<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmineCase extends Model
{
   protected $table    = 'cases';
   public function cases_statuses()
    {
    	return $this->hasMany(CaseStatus::class,'id');
    }
}
