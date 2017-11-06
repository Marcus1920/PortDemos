@extends("master")

@section("content")
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (Session::has('status'))
        <div class="alert alert-info">{{ Session::get('status') }}</div>
    @endif
        <section id="login">
            <header>
                <h1></h1>
                <p></p>
            </header>

            <div class="clearfix"></div>

            <!-- Login -->
            <form class="box tile animated active" id="box-login" role="form" method="POST" action="{{ url('/auth/login') }}">
                <h2 class="m-t-0 m-b-15">Login</h2>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" class="login-control m-b-10" placeholder="Cellphone number" name="cellphone">
                <input type="password" class="login-control" placeholder="Password" name="password">
                <div class="checkbox m-b-20">
                    <label>
                        <input type="checkbox">
                        Remember Me
                    </label>
                </div>
                <button class="btn btn-sm m-r-5" type="submit">Sign In</button>

                <small>

                    <a class="box-switcher" data-switch="box-reset" href="">Forgot/Change Password?</a>
                </small>
            </form>

            <!-- Register -->
            <form class="box animated tile" id="box-register" role="form" method="POST" action="{{ url('/auth/register') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h2 class="m-t-0 m-b-15">Register</h2>
                <input type="text" class="login-control m-b-10" placeholder="Full Name" name="name">
                <input type="text" class="login-control m-b-10" placeholder="Username" name="surname">
                <input type="email" class="login-control m-b-10" placeholder="Email Address" name="email">
                <input type="password" class="login-control m-b-10" placeholder="Password" name="password">
                <input type="password" class="login-control m-b-20" placeholder="Confirm Password" name="password_confirmation">

                <button class="btn btn-sm m-r-5" type="submit">Register</button>

                <small><a class="box-switcher" data-switch="box-login" href="">Already have an Account?</a></small>
            </form>

            <!-- Forgot Password -->
            <form class="box animated tile" id="box-reset" method="POST" action="{{ url('/password/email') }}">
                {!! csrf_field() !!}
                <h2 class="m-t-0 m-b-15">Reset Password</h2>
                <p></p>
                <input type="email" class="login-control m-b-20" name="email" placeholder="Email Address">

                <button class="btn btn-sm m-r-5" type="submit">Send Password Reset Link</button>

                <small><a class="box-switcher" data-switch="box-login" href="">Already have an Account?</a></small>
            </form>
        </section>
        <div style="float:auto; text-align:center;">

       		     <img  src="{{ asset('/img/zzzz.png') }}">
       		     </div>
@endsection