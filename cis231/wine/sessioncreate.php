<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Session Create</title>
</head>

<body>
<?php
session_start();
ini_set('display_errors', 'on');

mysql_connect("localhost", "djcarr", "160950");
mysql_select_db("carr_db");

$uid = $_SESSION['userID'];
$result = mysql_query("SELECT firstName, DAYNAME(lastLogin), MONTHNAME(lastLogin), DAY(lastLogin), YEAR(lastLogin) FROM user where userID = '$uid'");

$row = mysql_fetch_array($result);
$_SESSION['firstName'] = $row[0];

if($row[1] == NULL){
	$_SESSION['lastLogin'] = NULL;
}
else{
$_SESSION['lastLogin'] = $row[1].", ". $row[2]." ".$row[3].", ".$row[4] ; 
}
mysql_query("UPDATE user SET lastLogin = NOW() WHERE userID = '$uid'");

header("Location: main.php");
?>

</body>
</html>