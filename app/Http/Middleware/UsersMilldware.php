<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class UsersMilldware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::check()  && Auth::User()->role == 1)
    {

       return $next($request);
       //// return redirect('/home');


    }


    else
    {

       // $mesage  =   '<h1>  Home    </h1>' ;


          return redirect('/erro');

    }



    }
}
