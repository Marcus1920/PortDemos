<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\User;

class addressbook extends Eloquent
{


    protected $table    = 'addressbook';
    protected $fillable = ['user_id','created_by'];


    public function User()
    {
        return $this->belongsTo(User::class);

    }


}
