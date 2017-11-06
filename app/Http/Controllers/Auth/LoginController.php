<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use  Sentinel  ;
use Response ;
use Activation;
use App\User;
use Mail ;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\checkThrottlingException;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */


    /**
     * Create a new controller instance.
     *
     * @return void
     */


public function dosignup(Request  $request)
{



          /*  $v = Validator::make($request->all(), [
              'first_name' =>'required|alpha' ,
              'email' =>'required|email|unique:users,email' ,
              'last_name' =>'required|alpha' ,
              'password' =>'required' ,
              'password_confirmation' => 'required|same:password',
              'cellphone' =>'required|numeric|min:10|unique:users,cellphone'
               ]);

               if ($v->fails())
               {
                   return redirect()->back()->withErrors($v->errors());
               }*/

            ///   else {

           $User     = Sentinel::registerAndActivate( Input::all());

        //    $User     = Sentinel::register(Input::all());



        //    $activation   =  Activation::create($User);

           $role     = Sentinel::findRoleBySlug('user');

            $role->users()->attach($User) ;

      ///      $this->Sendemai($User ,$activation->code ) ;

            return   "ok";
       //}
}

private  function  Sendemai($user , $code)
{

Mail::send('email.activation',[
'user'  => $user  ,
'code'  => $code


  ] , function($message) use  ($user) {

  $message->to   ($user ->email) ;
  $message->subject  (" hello "  . $user ->first_name ,

"Activate  your  account . " ) ;

  }) ;



}


public function FunctionName($value='')
{
  # code...
}


public function logout()
{
   Sentinel::logout() ;
 return   redirect('login');


}

	public function doLogin(Request $request)
{

 try {



    } catch (checkThrottlingException $e) {

      $delay = $e->getDelay() ;

      dd($delay) ;
  // return   redirect('auth/login')->with('status' , 'Login  fails  check ll your credentials' ,$delay );
    //  return   redirect('auth/login');

    }


                $v = Validator::make($request->all(), [
                   'cellphone'    => 'required', // make sure the email is an actual email
                   'password' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
                   ]);


                   if ($v->fails())
                   {
                       return redirect()->back()->withErrors($v->errors());
                   }

                   else {

                     $credentials = [
                         'cellphone'    => Input::get('cellphone'),
                         'password' =>Input::get('password'),
                     ];

                     Sentinel::authenticate($credentials);


              try {

              if ( Sentinel::authenticate($credentials)) {

                $slug   =  Sentinel::getUser()->roles()->first()->slug;


                  return   redirect('auth/login')->with('status' , 'wowowow');

                # code...
              }
              else {



                  return   redirect('auth/login')->with('status' , 'Login  fails  check ll your credentials');
              }
              } catch (checkThrottlingException   $e) {

                $delay = $e->getDelay() ;

                return   redirect('auth/login');

              }






   }

  }
}
