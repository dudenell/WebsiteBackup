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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $uid = $_SESSION['userID'];	
  $insertSQL = sprintf("INSERT INTO location (locationName, locationDescription, locationWebsite, locationAddress, locationCity, locationState, locationZip, locationLastUpdated, userID) VALUES (%s, %s, %s, %s, %s, %s, %s, CURRENT_TIMESTAMP,'$uid')",
                       GetSQLValueString($_POST['locationName'], "text"),
                       GetSQLValueString($_POST['locationDescription'], "text"),
                       GetSQLValueString($_POST['locationWebsite'], "text"),
                       GetSQLValueString($_POST['locationAddress'], "text"),
                       GetSQLValueString($_POST['locationCity'], "text"),
                       GetSQLValueString($_POST['locationState'], "text"),
                       GetSQLValueString($_POST['locationZip'], "int"));

  mysql_select_db($database_School, $School);
  $Result1 = mysql_query($insertSQL, $School) or die(mysql_error());
  header('Location: locationadded.php');
}

mysql_select_db($database_School, $School);
$query_Recordset1 = "SELECT * FROM location";
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add a new winery</title>
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Winery Name:</td>
      <td><input type="text" name="locationName" value="" size="32" maxlenght="100" title="Please enter a location name!" required autofocus/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Description:</td>
      <td><textarea name="locationDescription" cols="40" rows="5" maxlenght="2500" title="Please include a short description" required></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Website:</td>
      <td><input type="text" name="locationWebsite" value="" size="32" maxlenght="60"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Address:</td>
      <td><input type="text" name="locationAddress" value="" size="32" maxlenght="100"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">City:</td>
      <td><input type="text" name="locationCity" value="" size="32" maxlenght="60" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">State:</td>
      <td><input type="text" name="locationState" value="" size="2" maxlenght="2"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Zip:</td>
      <td><input type="text" name="locationZip" value="" size="5" maxlenght="5"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Add Winery" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
