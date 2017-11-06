<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  protected $fillable = array('*');

  public $timestamps = true;
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];




    public  function tasks(){

        return $this->hasMany(Task::class,'id','task_id');

    }

    public function users()

    {

        return $this->hasMany(TaskNote::class);

    }

    public function taskActivities()

    {

        return $this->hasMany(TaskActivity::class);

    }

         public function addressBook()
    {
        return $this->hasMany(addressbook::class,'id','user_id');
    }
}
