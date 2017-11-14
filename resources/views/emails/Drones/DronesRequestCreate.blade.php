<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en"><head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
</body>
</html>
