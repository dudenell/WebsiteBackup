<?php require_once('Connections/School.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['userID'])) {
  $loginUsername=$_POST['userID'];
  $_SESSION['userID'] = $_POST['userID'];
  $password=$_POST['passwd'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "sessioncreate.php";
  $MM_redirectLoginFailed = "loginerror.html";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_School, $School);
  
$LoginRS__query=sprintf("SELECT userID, passwd FROM user WHERE userID=%s AND passwd=SHA1(%s)",
GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
   
  $LoginRS = mysql_query($LoginRS__query, $School) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home Page</title>
<link href="index.css" rel="stylesheet" type="text/css">
</head>

<body>
<table>
	<tr>
    	<td>
        	Wine Ad here
        </td>	
    	<td>
			<h1>The Winery Directory</h1>
            <img src="images/row-of-wine-bottles-xl.jpg" alt="logo">
        </td>
    	<td width=17%>
<form ACTION="<?php echo $loginFormAction; ?>" id="form1" name="loginform" method="POST" >
<p>
<h2>Login</h2>
<label>Username: 
<input name="userID" type="text" id="userID" size="15" maxlength="15" />
</label>
</p>
<p>
<label>Password: 
<input type="password" name="passwd" id="passwd" size="15" maxlength="15"/>
</label>
</p>
<p>

<input type="submit" name="button" id="button" value="Login" />
</p>
</form>
<p><a href="register.php">Or register</a>
		</td>
	</tr>
</table>
<h2>Latest updated wineries</h2>
<?php
mysql_connect("localhost", "djcarr", "160950");
mysql_select_db("carr_db");
$result = mysql_query("SELECT locationName, locationDescription, locationWebsite FROM location ORDER BY locationLastUpdated DESC LIMIT 2");
?>
<table id="winery">
  <?php
while($row = mysql_fetch_array($result))
{
?>
  <tr>
    <td><?php echo $row[0]; ?></td>
    <td width="70%"><?php echo $row[1]; ?></td>
    <td><a href="<?php echo $row[2]; ?>"><?php echo $row[2]; ?></a></td>
  </tr>
  <?php
}
?>
</table>

<h2>Latest updated wines</h2>
<?php
mysql_connect("localhost", "djcarr", "160950");
mysql_select_db("carr_db");
$result = mysql_query("SELECT wine.wineName, wine.wineDesc, location.locationName FROM wine INNER JOIN location ON wine.locationID = location.locationID LIMIT 2");
?>
<table id="winery">
<?php
while($row = mysql_fetch_array($result))
{
?>
<tr>
	<td><?php echo $row[0]; ?></td>
	<td width="70%"><?php echo $row[1]; ?></td>
	<td><?php echo $row[2]; ?></td>
</tr>
<?php
}
?>
</table>
<div id="footer">
	<p>This page was created by Daniel Carr for CIS 231</p>
</div>
</body>
</html>