<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class QualificationType extends Eloquent
{


    protected $table    = 'qualification_types';
    protected $fillable = ['name','slug','active'];


}
