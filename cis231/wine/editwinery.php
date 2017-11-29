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
  $updateSQL = sprintf("UPDATE location SET locationDescription=%s, locationWebsite=%s, locationAddress=%s, locationCity=%s, locationState=%s, locationZip=%s, locationLastUpdated=CURRENT_TIMESTAMP WHERE locationID=%s",
                       GetSQLValueString($_POST['locationDescription'], "text"),
                       GetSQLValueString($_POST['locationWebsite'], "text"),
                       GetSQLValueString($_POST['locationAddress'], "text"),
                       GetSQLValueString($_POST['locationCity'], "text"),
                       GetSQLValueString($_POST['locationState'], "text"),
                       GetSQLValueString($_POST['locationZip'], "int"),
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
<title>Edit <?php echo $row_Recordset1['locationName']; ?></title>
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Winery Name:</td>
      <td><?php echo $row_Recordset1['locationName']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Description:</td>
      <td><textarea name="locationDescription" cols="50" rows="5" maxlength="2500" title="Please include a short description" required="required" autofocus="autofocus"><?php echo htmlentities($row_Recordset1['locationDescription'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Website:</td>
      <td><input type="text" name="locationWebsite" value="<?php echo htmlentities($row_Recordset1['locationWebsite'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="60" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Address:</td>
      <td><input type="text" name="locationAddress" value="<?php echo htmlentities($row_Recordset1['locationAddress'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="100" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">City:</td>
      <td><input type="text" name="locationCity" value="<?php echo htmlentities($row_Recordset1['locationCity'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="60" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">State:</td>
      <td><input type="text" name="locationState" value="<?php echo htmlentities($row_Recordset1['locationState'], ENT_COMPAT, 'utf-8'); ?>" size="2" maxlength="2" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Zip:</td>
      <td><input type="text" name="locationZip" value="<?php echo htmlentities($row_Recordset1['locationZip'], ENT_COMPAT, 'utf-8'); ?>" size="5" maxlength="5" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update Winery" /></td>
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
