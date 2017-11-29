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

$maxRows_Recordset1 = 2;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_School, $School);
$query_Recordset1 = "SELECT locationID, locationName, locationDescription, locationWebsite FROM location ORDER BY locationLastUpdated DESC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Home Page</title>
<link href="index.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<table>
  <tr>
    <td> Wine Ad here </td>
    <td><h1>The Winery Directory</h1>
      <img src="images/row-of-wine-bottles-xl.jpg" alt="logo"></td>
    <td width=17%><h2>Welcome <?php echo $_SESSION['firstName']; ?>!</h2>
      <?php 
		if($_SESSION['lastLogin'] == NULL)
		{ 
			echo "<p>This is your first login!</p>";
		}
		else
		{
			?>
      			<p>Last log in <?php echo($_SESSION['lastLogin']); ?></p>
			<?php
			}
			?> 
	</td>
  </tr>
</table>
<h2>Latest updated wineries</h2>
<table id="winery">
  <?php do { ?>
    <tr>
      
      <td><a href="winery.php?locationID=<?php echo $row_Recordset1['locationID']; ?>"><?php echo $row_Recordset1['locationName']; ?></a></td>
      <td width="70%"><?php echo $row_Recordset1['locationDescription']; ?></td>
      <td><a href="<?php echo $row_Recordset1['locationWebsite']; ?>"><?php echo $row_Recordset1['locationWebsite']; ?></a></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
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
<?php
mysql_free_result($Recordset1);
?>
