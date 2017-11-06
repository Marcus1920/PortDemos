<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="format-detection" content="telephone=no">
    <meta charset="UTF-8">
    <meta name="description" content="Siyaleader Durban University of Technology">
    <meta name="keywords" content="Siyaleader,Durban University of Technology, HIV/AIDS">
    <link rel="icon" type="image/x-icon" sizes="16x16" href="{{ asset('/img/SiteBadge3.png') }}">


    <title>Transnet  Ports</title>


    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <!-- CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/generics.css') }}" rel="stylesheet">



</head>
<body id="skin-blur-ocean" style="background-color: #5c788f">

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
<section id="login" style="margin: 0; padding: 0;">
    <header>
    	<!--<div style="background-color:red">
    		<div style="background-color: red; float:left; height: auto; text-align:right; width:  100%">
    			<div style="background-color: #fff; float:left; height: 75px; margin-top: -118px; text-align:right; width:  100%">&nbsp;</div>
    			<img src="{{ asset('/img/login_logo.png') }}" style="float: none" />
    		</div>
    	</div>
    	<div style="background-color:red">
    		<div style="background-color: #fff; float:left; height: 75px; margin-top: -118px; text-align:right; width:  100%">&nbsp;</div>
    	</div>
    	-->
    	<table border="0" style="height: 118px;width:100%;">
    		<tr style="height: 75px; background-color: #fff;">
    			<td style="">&nbsp;</td>
    			<td rowspan="2" style="background-color: #3c4e5d;width: 170px;"><img src="{{ asset('/img/login_logo.png') }}" style="float: none" /></td>
    		</tr>
    		<tr style="background-color:#3c4e5d">
    			<td>
    				<h2 style="margin: 0;padding: 0;text-align: left; padding-left: 0.75em;">Login</h2>
    			</td>
    		</tr>
    	</table>
    	
    	<!--
    	<table border="0" style="height: 118px;width:100%; background-repeat:no-repeat; background-position:right;">
    		<tr style="height: 30px; background-color: #fff;">
    			<td width="500">&nbsp;</td><td rowspan="2"></td>
    			<td rowspan="2" width="170" align="right"><img src="{{ asset('/img/login_logo.png') }}" style="float: none" /></td>
    		</tr>
    		<tr bgcolor="#000000">
    			<td height="50">&nbsp;</td>
    		</tr>
    	</table>
    	-->
    	
    	<!--<table border="0" style="height: 118px;width:100%; background-repeat:no-repeat; background-position:right;">
    		<tr style="height: 30px; background-color: #fff;">
    			<td width="500">&nbsp;</td><td rowspan="2"></td>
    			<td rowspan="2" width="170" align="right"><img src="{{ asset('/img/login_logo.png') }}" style="float: none" /></td>
    		</tr>
    		<tr bgcolor="#000000">
    			<td height="50">&nbsp;</td>
    		</tr>
    	</table>-->

    	<!--<table border="1" style="height: 118px;width:100%; background-repeat:no-repeat; background-position:right; background-image:url({{ asset('/img/login_logo.png') }});">
    		<tr style="height: 30px; background-color: #fff;"><td style="width:100%">&nbsp;</td></tr>
    		<tr><td>&nbsp;</td></tr>
    	</table>
    	-->

    </header>

    <div class="row" style="padding: 0">
        <div class="col-lg-4">

            <form class="box tile animated active" id="box-login" role="form" method="POST" action="{{ url('/auth/login') }}">
                <!--<h2 class="m-t-0 m-b-15">Login</h2>-->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" class="login-control m-b-10" placeholder="Cellphone number" name="cellphone">
                <input type="password" class="login-control" placeholder="Password" name="password">
                <div class="checkbox m-b-20">
                    <label>
                        <input type="checkbox" name="remember" id="rememberMeCheck">
                        Remember Me
                    </label>
                </div>
                <button class="btn btn-default btn-sm m-r-5" type="submit">Sign In</button>

                <small>

                    <a class="box-switcher" data-switch="box-reset" href="">Forgot/Change Password?</a>
                </small>
            </form>

            <form class="box animated tile" id="box-reset" method="POST" action="{{ url('/password/email') }}">
                {!! csrf_field() !!}
                <h2 class="m-t-0 m-b-15">Reset Password</h2>
                <p></p>
                <input type="email" class="login-control m-b-20" name="email" placeholder="Email Address">

                <button class="btn btn-default btn-sm m-r-5" type="submit">Send Password Reset Link</button>

                <small><a class="box-switcher" data-switch="box-login" href="">Already have an Account?</a></small>
            </form>
        </div>

        <!--<div class="col-lg-4">
			<BR>
            <img class="" src="{{ asset('/img/transnet_transp_light_bg_small.png') }}" width="260" height="260" alt="">
        </div>-->
    </div>

    <div class="clearfix"></div>

    <!-- Login -->

</section>

<!-- Javascript Libraries -->
<!-- jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script> <!-- jQuery Library -->

<!-- Bootstrap -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<!--  Form Related -->
{{--<script src="{{ asset('js/icheck.js') }}"></script> <!-- Custom Checkbox + Radio -->--}}

<!-- All JS functions -->
<script src="{{ asset('js/functions.js') }}"></script>
</body>
</html>
