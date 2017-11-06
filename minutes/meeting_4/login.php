


<?php
session_start();
$error='';
if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Username or Password is invalid";
}
else
{

$username   =$_POST['username'];
$password   =$_POST['password'];
$connection = mysql_connect("localhost", "www", "");
$username   = stripslashes($username);
$password   = stripslashes($password);
$username   = mysql_real_escape_string($username);
$password   = mysql_real_escape_string($password);
$db         = mysql_select_db("siyaleader_dbnports_live", $connection);
$query      = mysql_query("select * from imb_oss_users where Password='$password' AND Cell1='$username'", $connection);
$rows       = mysql_num_rows($query);
while($row = mysql_fetch_row($query))
{
    $firstName = $row[3];
    $surName   = $row[4];
}
if ($rows == 1) {
    $_SESSION['login_user'] = $username;
    $_SESSION['firstName']  = $firstName;
    $_SESSION['lastName']   = $surName;
    header("location: map.php");
    die();
} else {

    $error = "Username or Password is invalid";
}
mysql_close($connection);
}
}
?>

