<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Religion  extends Eloquent
{


    protected $table    = 'religions';
    protected $fillable = ['name','updated_by','slug','active'];


}
