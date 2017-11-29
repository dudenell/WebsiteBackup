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
  $updateSQL = sprintf("UPDATE wine SET wineDesc=%s, catName=%s, tasteID=%s, lastUpdated=CURRENT_TIMESTAMP WHERE wineID=%s",
                       GetSQLValueString($_POST['wineDesc'], "text"),
                       GetSQLValueString($_POST['catName'], "text"),
                       GetSQLValueString($_POST['tasteID'], "int"),
                       GetSQLValueString($_POST['wineID'], "int"));

  mysql_select_db($database_School, $School);
  $Result1 = mysql_query($updateSQL, $School) or die(mysql_error());

  $updateGoTo = "wineupdated.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['wineID'])) {
	$_SESSION['wineID'] = $_GET['wineID'];
  $colname_Recordset1 = $_GET['wineID'];
}
mysql_select_db($database_School, $School);
$query_Recordset1 = sprintf("SELECT wineID, wineName, wineDesc, userID, locationID, catName, tasteID, lastUpdated FROM wine WHERE wineID = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_School, $School);
$query_Recordset2 = "SELECT tasteID, tasteName FROM winetaste";
$Recordset2 = mysql_query($query_Recordset2, $School) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_School, $School);
$query_Recordset3 = "SELECT catName FROM category";
$Recordset3 = mysql_query($query_Recordset3, $School) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit <?php echo $row_Recordset1['wineName']; ?></title>
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Wine Name:</td>
      <td><?php echo $row_Recordset1['wineName']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Description:</td>
      <td><textarea name="wineDesc" cols="50" rows="5" maxlength="1000" title="Please include a short description" required="required" autofocus="autofocus"><?php echo htmlentities($row_Recordset1['wineDesc'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Category:</td>
              <td><select name="catName" id="catName">
      <?php
		do { 
		?>
		<option value="<?php echo $row_Recordset3['catName']?>"><?php echo $row_Recordset3['catName']?></option>
		<?php
			} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
			$rows = mysql_num_rows($Recordset3);
			if($rows > 0) {
				mysql_data_seek($Recordset3, 0);
				$row_Recordset3 = mysql_fetch_assoc($Recordset3);
			}
		?>
        
		</select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Taste:</td>
      <td><select name="tasteID" id="tasteID">
      <?php
		do { 
		?>
		<option value="<?php echo $row_Recordset2['tasteID']?>"><?php echo $row_Recordset2['tasteName']?></option>
		<?php
			} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
			$rows = mysql_num_rows($Recordset2);
			if($rows > 0) {
				mysql_data_seek($Recordset2, 0);
				$row_Recordset2 = mysql_fetch_assoc($Recordset2);
			}
		?>
        
		</select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update Wine" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="wineID" value="<?php echo $row_Recordset1['wineID']; ?>" />
</form>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
