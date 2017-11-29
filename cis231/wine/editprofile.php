<?php require_once('logincheck.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE `user` SET passwd=SHA1(%s), firstName=%s, lastName=%s, email=%s, secretQ=%s, secretA=%s WHERE userID=%s",
                       GetSQLValueString($_POST['passwd'], "text"),
                       GetSQLValueString($_POST['firstName'], "text"),
                       GetSQLValueString($_POST['lastName'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['secretQ'], "text"),
                       GetSQLValueString($_POST['secretA'], "text"),
                       GetSQLValueString($_POST['userID'], "text"));

  mysql_select_db($database_School, $School);
  $Result1 = mysql_query($updateSQL, $School) or die(mysql_error());

  $updateGoTo = "profileupdated.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_School, $School);
$query_Recordset1 = "SELECT userID, firstName, lastName, email, secretQ, secretA FROM `user`";
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Profile</title>
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Username:</td>
      <td><?php echo $row_Recordset1['userID']; ?></td>
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
      <td><input type="text" name="firstName" value="<?php echo htmlentities($row_Recordset1['firstName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Last Name:</td>
      <td><input type="text" name="lastName" value="<?php echo htmlentities($row_Recordset1['lastName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="email" value="<?php echo htmlentities($row_Recordset1['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Secret Question:</td>
      <td><input type="text" name="secretQ" value="<?php echo htmlentities($row_Recordset1['secretQ'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Secret Answer:</td>
      <td><input type="text" name="secretA" value="<?php echo htmlentities($row_Recordset1['secretA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update My Profile" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="userID" value="<?php echo $row_Recordset1['userID']; ?>" />
</form>
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
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
