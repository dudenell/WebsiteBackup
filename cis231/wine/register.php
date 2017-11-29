<?php session_start(); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$_SESSION['userID'] = $_POST['userID'];	
  $insertSQL = sprintf("INSERT INTO `user` (userID, passwd, firstName, lastName, email, secretQ, secretA, dateJoined) VALUES (%s, SHA1(%s), %s, %s, %s, %s, %s, CURRENT_TIMESTAMP)",
                       GetSQLValueString($_POST['userID'], "text"),
                       GetSQLValueString($_POST['passwd'], "text"),
                       GetSQLValueString($_POST['firstName'], "text"),
                       GetSQLValueString($_POST['lastName'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['secretQ'], "text"),
                       GetSQLValueString($_POST['secretA'], "text"));

  mysql_select_db($database_School, $School);
  $Result1 = mysql_query($insertSQL, $School) or die(mysql_error());

  $insertGoTo = "sessioncreate.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">User name:</td>
      <td><input type="text" name="userID" value="" size="15" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,15}$" title="userID must be between 4 and 15 characters, start with a letter, and contain only letters and numbers " maxlenght="15" required autofocus/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Password:</td>
      <td><input type="password" name="passwd" value="" size="15" pattern="^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{6,15}$" title="The password must be between 6 and 12 characters, and include at least 1 upper case letter, 1 lowercase letter, 1 number and 1 of the special characters ! @ # $ & *" maxlenght="15" required/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Reenter Password:</td>
      <td><input type="password" name="passwd2" value="" size="15" maxlenght="15" required /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">First Name:</td>
      <td><input type="text" name="firstName" value="" size="10" maxlenght="10" required /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Last Name:</td>
      <td><input type="text" name="lastName" value="" size="15" maxlenght="15" required /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="email" value="" size="30" maxlenght="30" required /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Secret Question (for password resets):</td>
      <td><input type="text" name="secretQ" value="" size="50" maxlenght="150" required /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Secret Question Answer:</td>
      <td><input type="text" name="secretA" value="" size="50" maxlenght="150" required /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <script>
var userPasswd2 = document.getElementById('userPasswd2');
var userPasswd = document.getElementById('userPasswd');

var checkPasswordValidity = function() {
if (userPasswd.value != userPasswd2.value) {
userPasswd.setCustomValidity('Passwords must match.');
} else {
userPasswd.setCustomValidity('');
} 
};
userPasswd.addEventListener('change', checkPasswordValidity, false);
userPasswd2.addEventListener('change', checkPasswordValidity, false);
</script>
</form>
</body>
</html>