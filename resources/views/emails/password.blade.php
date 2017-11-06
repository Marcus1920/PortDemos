<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>


    <link rel="stylesheet" href="css/simple.css">


</head>
<body>
<table class="body-wrap">
    <tr>
        <td class="container">


            <table>
                <tr>
                    <td align="center" class="masthead">


                        {{--<a href="http://www.google.com"><img src="SiteBadge3.png" alt="Loading..."/></a>--}}
                        {{--<img src="<php echo $message->public_path('img/SiteBadge3.png') ?>" alt=""/>--}}
                      <img src="{{ $message->embed(public_path('img/SiteBadge3.png')) }}" alt="loading....."/>

                    </td>
                </tr>
                <tr>
                    <td class="content">



                        <p></p>

                        <table>
                            <tr>
                                <td align="left">
                                    <p>
                                    <p>Request to reset password link </p>
                                    <a href=" {{ env('LIVE_URL') }}/password/reset/{{ $token }}">Click here to reset your password</a>
                                    </p>
                                </td>
                            </tr>
                        </table>



                        <p><em>Kind Regards<br>Ubulwembu</em></p>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td class="container">

            <!-- Message start -->
            <table>
                <tr>
                    <td class="content footer" align="center">
                        <p><a href="#">Siyaleader</a>, 43 Turners Avenue, Berea,Durban, 4001</p>
                        <p><a href="mailto:">information@siyaleader.net</a> | <a href="#">www.siyaleader.net</a></p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>