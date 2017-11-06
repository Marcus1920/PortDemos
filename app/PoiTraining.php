<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PoiTraining extends Eloquent
{
     protected $table    = 'poi_trainings';
     protected $fillable = ['name','id'];
}
