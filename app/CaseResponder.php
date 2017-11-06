<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CaseResponder extends Eloquent
{

    protected $table    = 'responders';

    public function responderTypeFunc() {

        return $this->hasOne('App\ResponderType','id','responder_type');
    }

    public function user() {

        return $this->hasOne('App\User','id','responder');
    }


}
