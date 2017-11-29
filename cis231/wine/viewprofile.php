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

$colname_Recordset1 = "-1";
if (isset($_SESSION['userID'])) {
  $colname_Recordset1 = $_SESSION['userID'];
}
mysql_select_db($database_School, $School);
$query_Recordset1 = sprintf("SELECT userID, firstName, lastName, email, MONTHNAME(lastLogin), DAY(lastLogin), YEAR(lastLogin) FROM `user` WHERE userID = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_SESSION['userID'])) {
  $colname_Recordset2 = $_SESSION['userID'];
}
mysql_select_db($database_School, $School);
$query_Recordset2 = sprintf("SELECT locationID, locationName, locationWebsite, MONTHNAME(locationLastUpdated), DAY(locationLastUpdated), YEAR(locationLastUpdated) FROM location WHERE userID = %s", GetSQLValueString($colname_Recordset2, "text"));
$Recordset2 = mysql_query($query_Recordset2, $School) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "-1";
if (isset($_SESSION['userID'])) {
  $colname_Recordset3 = $_SESSION['userID'];
}
mysql_select_db($database_School, $School);
$query_Recordset3 = sprintf("SELECT wine.wineID, wine.wineName, location.locationName, wine.catName, winetaste.tasteName,  MONTHNAME(wine.lastUpdated), DAY(wine.lastUpdated), YEAR(wine.lastUpdated)  FROM wine INNER JOIN location ON wine.locationID = location.locationID INNER JOIN winetaste ON wine.tasteID = winetaste.tasteID WHERE wine.userID = %s ORDER BY wine.lastUpdated DESC", GetSQLValueString($colname_Recordset3, "text"));
$Recordset3 = mysql_query($query_Recordset3, $School) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_SESSION['userID'])) {
  $colname_Recordset4 = $_SESSION['userID'];
}
mysql_select_db($database_School, $School);
$query_Recordset4 = sprintf("SELECT commentID, commentTitle, commentText, rating FROM comments WHERE userID = %s", GetSQLValueString($colname_Recordset4, "text"));
$Recordset4 = mysql_query($query_Recordset4, $School) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_School, $School);
$query_Recordset5 = "SELECT tasteID, tasteName FROM winetaste";
$Recordset5 = mysql_query($query_Recordset5, $School) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Profile</title>
<link href="viewprofile.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<h1>My Information</h1>
<p><a href="editprofile.php">Edit my profile</a></p>
<table id="viewprotable">
  <tr>
    <td id="padding">Username</td>
    <td id="padding">First Name</td>
    <td id="padding">Last Name</td>
    <td id="padding">Email</td>
    <td id="padding">Last Login</td>
  </tr>
  <?php do { ?>
    <tr>
      <td id="padding"><?php echo $row_Recordset1['userID']; ?></td>
      <td id="padding"><?php echo $row_Recordset1['firstName']; ?></td>
      <td id="padding"><?php echo $row_Recordset1['lastName']; ?></td>
      <td id="padding"><?php echo $row_Recordset1['email']; ?></td>
      <td id="padding"><?php echo $row_Recordset1['MONTHNAME(lastLogin)']; ?> <?php echo $row_Recordset1['DAY(lastLogin)']; ?>, <?php echo $row_Recordset1['YEAR(lastLogin)']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>

<h1>My Wineries</h1>
<table id="viewprotable">
  <tr>
    <td id="padding">Winery Name</td>
    <td id="padding">Website</td>
    <td id="padding">Last Updated</td>
    <td id="padding">Edit Winery</td>
  </tr>
  <?php do { ?>
    <tr>
      <td id="padding"><a href="winery.php?locationID=<?php echo $row_Recordset2['locationID']; ?>"><?php echo $row_Recordset2['locationName']; ?></a></td>
      <td id="padding"><a href="<?php echo $row_Recordset2['locationWebsite']; ?>"><?php echo $row_Recordset2['locationWebsite']; ?></a></td>
      <td id="padding"><?php echo $row_Recordset2['MONTHNAME(locationLastUpdated)']; ?> <?php echo $row_Recordset2['DAY(locationLastUpdated)']; ?>, <?php echo $row_Recordset2['YEAR(locationLastUpdated)']; ?></td>
      <td id="padding"><a href="editwinery.php?locationID=<?php echo $row_Recordset2['locationID']; ?>">Edit <?php echo $row_Recordset2['locationName']; ?></a>
    </tr>
    <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
</table>
<h1>My Added Wines</h1>
<table id="viewprotable" >
  <tr>
    <td id="padding">Wine Name</td>
    <td id="padding">Winery</td>
    <td id="padding">Category</td>
    <td id="padding">Sweetness</td>
    <td id="padding">Last Updated</td>
    <td id="padding">Edit Wine</td>
  </tr>
  <?php do { ?>
    <tr>
      <td id="padding"><a href="wine.php?wineID=<?php echo $row_Recordset3['wineID']; ?>"><?php echo $row_Recordset3['wineName']; ?></a></td>
      <td id="padding"><?php echo $row_Recordset3['locationName']; ?></td>
      <td id="padding"><?php echo $row_Recordset3['catName']; ?></td>
      <td id="padding"><?php echo $row_Recordset3['tasteName']; ?></td>
      <td id="padding"><?php echo $row_Recordset3['MONTHNAME(wine.lastUpdated)']; ?> <?php echo $row_Recordset3['DAY(wine.lastUpdated)']; ?>, <?php echo $row_Recordset3['YEAR(wine.lastUpdated)']; ?></td>
      <td id='padding'><a href="editwine.php?wineID=<?php echo $row_Recordset3['wineID']; ?>">Edit <?php echo $row_Recordset3['wineName']; ?>
    </tr>
    <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
</table>
<h1>My Comments</h1>
<table id="viewprotable" >
  <tr>
    <td id="padding">Comment Title</td>
    <td id="padding">Comment Text</td>
    <td id="padding">Rating</td>
    <td id="padding">View / Delete Comment</td>
  </tr>
  <?php do { ?>
    <tr>
      <td id="padding"><?php echo $row_Recordset4['commentTitle']; ?></td>
      <td id="padding"><?php echo $row_Recordset4['commentText']; ?></td>
      <td id="padding"><?php echo $row_Recordset4['rating']; ?></td>
      <td id="padding"><a href="viewcomment.php?commentID=<?php echo $row_Recordset4['commentID']; ?>">View Comment</a></td>
    </tr>
    <?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); ?>
</table>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);
?>
