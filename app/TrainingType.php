<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TrainingType extends Eloquent
{


    protected $table    = 'training_types';
    protected $fillable = ['name','municipality','slug','active'];


}
