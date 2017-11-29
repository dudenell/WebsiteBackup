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
	$insertSQL = sprintf("INSERT INTO wine (wineName, wineDesc, userID, locationID, catName, tasteID, lastUpdated) VALUES (%s, %s, '$uid', %s, %s, %s, CURRENT_TIMESTAMP)",
                       GetSQLValueString($_POST['wineName'], "text"),
                       GetSQLValueString($_POST['wineDesc'], "text"),
					   GetSQLValueString($_POST['locationID'], "int"),
					   GetSQLValueString($_POST['catName'], "text"),
					   GetSQLValueString($_POST['tasteID'], "int"));

  mysql_select_db($database_School, $School);
  $Result1 = mysql_query($insertSQL, $School) or die(mysql_error());
  header('Location: wineadded.php');
}

mysql_select_db($database_School, $School);
$query_Recordset1 = "SELECT locationID, locationName FROM location";
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_School, $School);
$query_Recordset2 = "SELECT catName FROM category";
$Recordset2 = mysql_query($query_Recordset2, $School) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_School, $School);
$query_Recordset3 = "SELECT tasteID, tasteName FROM winetaste";
$Recordset3 = mysql_query($query_Recordset3, $School) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Wine</title>
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Wine Name:</td>
      <td><input type="text" name="wineName" value="" size="30" maxlenth="30" title="Please enter a wine name!" required autofocus /></td>
    </tr>
    <tr valign="baseline">
		<td nowrap="nowrap" align="right" valign="top">Description:</td>
		<td><textarea name="wineDesc" cols="40" rows="5" maxlenght="1000" title="Please include a short description" required></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Location:</td>
      <td><select name="locationID" id="locationID">
      <?php
		do { 
		?>
		<option value="<?php echo $row_Recordset1['locationID']?>"><?php echo $row_Recordset1['locationName']?></option>
		<?php
			} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
			$rows = mysql_num_rows($Recordset1);
			if($rows > 0) {
				mysql_data_seek($Recordset1, 0);
				$row_Recordset1 = mysql_fetch_assoc($Recordset1);
			}
		?>
        
		</select></td></tr>
        
		<tr valign="baseline">
		<td nowrap="nowrap" align="right">Category:</td>
              <td><select name="catName" id="catName">
      <?php
		do { 
		?>
		<option value="<?php echo $row_Recordset2['catName']?>"><?php echo $row_Recordset2['catName']?></option>
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
      <td nowrap="nowrap" align="right">Taste:</td>
      <td><select name="tasteID" id="tasteID">
      <?php
		do { 
		?>
		<option value="<?php echo $row_Recordset3['tasteID']?>"><?php echo $row_Recordset3['tasteName']?></option>
		<?php
			} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
			$rows = mysql_num_rows($Recordset3);
			if($rows > 0) {
				mysql_data_seek($Recordset3, 0);
				$row_Recordset3 = mysql_fetch_assoc($Recordset3);
			}
		?>
        
		</select></td></tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Add Wine" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
