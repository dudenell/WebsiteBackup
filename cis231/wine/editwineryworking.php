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
  $updateSQL = sprintf("UPDATE location SET locationName=%s, locationDescription=%s, locationWebsite=%s WHERE locationID=%s",
                       GetSQLValueString($_POST['locationName'], "text"),
                       GetSQLValueString($_POST['locationDescription'], "text"),
                       GetSQLValueString($_POST['locationWebsite'], "text"),
                       GetSQLValueString($_POST['locationID'], "int"));

  mysql_select_db($database_School, $School);
  $Result1 = mysql_query($updateSQL, $School) or die(mysql_error());

  $updateGoTo = "locationupdated.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$colname_Recordset1 = "-1";
if (isset($_GET['locationID'])) {
	$_SESSION['locationID'] = $_GET['locationID'];
  $colname_Recordset1 = $_GET['locationID'];
}
mysql_select_db($database_School, $School);
$query_Recordset1 = sprintf("SELECT locationID, locationName, locationIMG, locationDescription, locationWebsite, locationAddress, locationCity, locationState, locationZip, locationLastUpdated, userID FROM location WHERE locationID = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Winery</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">LocationID:</td>
      <td><?php echo $row_Recordset1['locationID']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">LocationName:</td>
      <td><input type="text" name="locationName" value="<?php echo htmlentities($row_Recordset1['locationName'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">LocationDescription:</td>
      <td><textarea name="locationDescription" cols="50" rows="5"><?php echo htmlentities($row_Recordset1['locationDescription'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">LocationWebsite:</td>
      <td><input type="text" name="locationWebsite" value="<?php echo htmlentities($row_Recordset1['locationWebsite'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="locationID" value="<?php echo $row_Recordset1['locationID']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);


?>
