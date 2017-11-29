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

mysql_select_db($database_School, $School);
$query_Recordset1 = "SELECT wine.wineID, wine.wineName, wine.wineDesc, location.locationName, location.locationID, wine.catName, winetaste.tasteName, MONTHNAME(wine.lastUpdated), DAY(wine.lastUpdated), YEAR(wine.lastUpdated) FROM wine INNER JOIN location on wine.locationID = location.locationID INNER JOIN winetaste ON wine.tasteID = winetaste.tasteID ORDER BY wineName ASC";
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wine List</title>
<link href="winelist.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<h1>Wine List</h1>
<table id='winerylist'>
  <tr>
    <td id="border">Wine Name</td>
    <td id="border">Description</td>
    <td id="border">Winery</td>
    <td id="border">Category</td>
    <td id="border">Taste</td>
    <td id="border">Last Updated</td>
  </tr>
  <?php do { ?>
    <tr>
      <td id="border"><a href="wine.php?wineID=<?php echo $row_Recordset1['wineID']; ?>"><?php echo $row_Recordset1['wineName']; ?></a></td>
      <td id="border"><?php echo $row_Recordset1['wineDesc']; ?></td>
      <td id="border"><a href="winery.php?locationID=<?php echo $row_Recordset1['locationID']; ?>"><?php echo $row_Recordset1['locationName']; ?></td>
      <td id="border"><?php echo $row_Recordset1['catName']; ?></td>
      <td id="border"><?php echo $row_Recordset1['tasteName']; ?></td>
      <td id="border"><?php echo $row_Recordset1['MONTHNAME(wine.lastUpdated)']; ?> <?php echo $row_Recordset1['DAY(wine.lastUpdated)']; ?>, <?php echo $row_Recordset1['YEAR(wine.lastUpdated)']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
