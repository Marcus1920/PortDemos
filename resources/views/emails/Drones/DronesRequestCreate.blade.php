<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en"><head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<<<<<<< HEAD
    <title>Email</title></head>
<body style="background-color: silver">
<div style="width: 720px;height: 60px; background-color:rgb(142,215,215); margin: 20px auto; text-align: center; font-size: 52px; font-weight: bold">
    SIYALEADER
</div>
<center>
<div style="width: 700px; height: 400px; background-color: white; margin: -20px auto; padding: 10px">
    <p>Hi {{ $name }}</p>
    <p>{{ $text }}</p>
    <p style="font-size: 20px"><b><u>Case Details</u></b></p>
    <table border="1">
        <tr>
            <th>Case number</th>
            <th>Case status</th>
            <th>Case logged date</th>
            <th>Case duration</th>
        </tr>
        <tr align="center">
            <td>{{ $caseNumber }}</td>
            <td>{{ $status }}</td>
            <td>{{ $dateCreated }}</td>
            <td>{{ $caseDuration }}</td>
        </tr>
    </table>
    <p style="font-size: 20px"><b><u>Drone Details</u></b></p>
    <table border="1">
        <tr>
            <th>Requested by</th>
            <th>Drone type</th>
            <th>Drone sub type</th>
            <th>Department requesting services</th>
        </tr>
        <tr align="center">
            <td>{{ $creator }}</td>
            <td>{{ $droneType }}</td>
            <td>{{ $droneSubType }}</td>
            <td>{{ $department }}</td>
        </tr>
    </table>
    <p style="float: left"><b>Thank You</b></p>
    <p style="margin-left: 300px;"><b>Follow us</b></p>
    <p style="margin-top:-10px;float: left">Regards</p>
    <br/>
    <p style="float: left">{{ $creator }}</p>
    <img src="public/img/siyaleader.png " style="float: right; width:60px; margin-top: -50px; margin-right: 40px" alt="">
</div>
</center>
=======
    <title>Email</title>
    <style type="text/css">
        .button:hover{ background-color: #0066FF;}
    </style>
</head>

<body style="margin:0; margin-top:30px; margin-bottom:30px; padding:0; width:100%; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; background-color: #F4F5F7;">

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border:0; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; background-color: #F4F5F7;">
    <tbody>
    <tr>
        <td align="center" style="border-collapse: collapse;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                <tbody>
                <tr>
                    <td width="100%" height="30"></td>
                </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" width="560" style="border:0; border-collapse:collapse; background-color:#ffffff; border-radius:6px;">
                <tbody>
                <tr>
                    <td style="border-collapse:collapse; vertical-align:middle; text-align center; padding:20px;">

                        <!-- Headline Header -->
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                            <tbody>
                            <tr><!-- spacing top -->
                                <td width="100%" height="20"></td>
                            </tr>

                            <tr><!-- title -->
                                <td width="100%" style="font-family: helvetica, Arial, sans-serif; font-size: 18px; letter-spacing: 0px; text-align: center; color:#060606;">
                                    <h5>DRONE REQUEST EMAIL</h5>
                                </td>
                            </tr>

                            <tr><!-- spacing bottom -->
                                <td width="100%" height="18"></td>
                            </tr>

                            <tr>
                                <td width="100%" style="font-family: helvetica, Arial, sans-serif;padding-left: 20px; font-size: 16px; letter-spacing: 0px; color:#2E363F;">
                                    Hi {{ $name }}

                                </td>
                            </tr>
                            <tr><!-- spacing bottom -->
                                <td width="100%" height="18"></td>
                            </tr>

                            <tr>
                                <td width="100%"   style="font-family:helvetica, Arial, sans-serif; padding:0 20px 0 20px; font-size: 13px; text-align: left; color:#B1ADAD; line-height: 24px;">

                                    <strong>{{$messageBody}}</strong>
                                </td>
                            </tr>

                            <tr>
                                <td width="100%" style="font-family:helvetica, Arial, sans-serif; font-size: 14px; text-align: left; color:#87919F; line-height: 24px;">

                                </td>
                            </tr>
                            <tr>
                                <td width="100%" height="15"></td>
                            </tr>

                            <tr>
                                <td width="100%" height="15"></td>
                            </tr>
                            <tr>
                                <td width="100%" style="font-family:helvetica, Arial, sans-serif; padding-left: 20px; font-size: 13px; text-align: center; color:#2E363F; line-height: 24px;">
                                   <a href="{{ env('LIVE_URL') }}"  class="button" style=" background-color: #F55125;padding: 6px 9px;display: inline-block;text-decoration: none;color: #FFFFFF;border-radius: 1px;"><strong>Click here to login</strong></a>

                                </td>
                            </tr>

                            <tr>
                                <td width="100%" style="font-family:helvetica, Arial, sans-serif; font-size: 14px;  padding-left: 20px; text-align: left; color:#2E363F; line-height: 10px;">
                                    <p >Kindly Regards</p>
                                    <p>Siyaleader Investments.</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                            <tbody>
                            <tr>
                                <td width="100%" height="20"></td>
                            </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
                </tbody>
            </table>

            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                <tbody>
                <tr>
                    <td width="100%" height="30"></td>
                </tr>
                </tbody>
            </table>

            <table cellpadding="0" cellspacing="0" border="0" width="560" style="border:0; border-collapse:collapse; background-color:#ffffff; border-radius:6px;">
                <tbody>
                <tr>
                    <td style="border-collapse:collapse; vertical-align:middle; text-align center; padding:20px;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                            <tbody>
                            <tr><!-- logo -->
                                <td width="100%" style="font-family: helvetica, Arial, sans-serif; font-size: 18px; letter-spacing: 0px; text-align: center;">
                                    <a href="#" style="text-decoration: none;">
                                        <img src="{{ asset('img/siyaleader_light_bg_100.png') }}" width='90px' alt="Siyaleader"  style ="color:#2E363F;"/>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

                <tbody>
                <tr>
                    <td width="100%" height="30"></td>
                </tr>
                </tbody>
            </table>

        </td>
    </tr>
    </tbody>
</table>
>>>>>>> 13b6b65d75999837c4a9772d2885561e3e101e63
</body>
</html>
