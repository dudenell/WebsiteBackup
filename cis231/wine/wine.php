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
		$wineID = $_SESSION['wineID'];
  $insertSQL = sprintf("INSERT INTO comments (commentTitle, commentText, rating, userID, wineID, commentAdded) VALUES (%s, %s, %s, '$uid', '$wineID', CURRENT_TIMESTAMP)",
                       GetSQLValueString($_POST['commentTitle'], "text"),
                       GetSQLValueString($_POST['commentText'], "text"),
                       GetSQLValueString($_POST['rating'], "int"));

  mysql_select_db($database_School, $School);
  $Result1 = mysql_query($insertSQL, $School) or die(mysql_error());
}

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['wineID'])) {
	$_SESSION['wineID'] = $_GET['wineID'];
  $colname_Recordset1 = $_GET['wineID'];
}
mysql_select_db($database_School, $School);
$query_Recordset1 = sprintf("SELECT wine.wineID, wine.wineName, wine.wineDesc, wine.userID, location.locationName, location.locationID, catName, winetaste.tasteName, MONTHNAME(lastUpdated),  DAY(lastUpdated), YEAR(lastUpdated) FROM wine INNER JOIN location on wine.locationID = location.locationID INNER JOIN winetaste ON wine.tasteID = winetaste.tasteID WHERE wineID = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_GET['wineID'])) {
	$_SESSION['wineID'] = $_GET['wineID'];
  $colname_Recordset2 = $_GET['wineID'];
}
mysql_select_db($database_School, $School);
$query_Recordset2 = sprintf("SELECT commentTitle, commentText, MONTHNAME(commentAdded), DAY(commentAdded), YEAR(commentAdded), rating, userID FROM comments WHERE wineID = %s ORDER BY commentAdded DESC", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $School) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row_Recordset1['wineName']; ?></title>
<link href="wine.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<h1><?php echo $row_Recordset1['wineName']; ?></h1>
<p id="lastupdated">Made by: <a href="winery.php?locationID=<?php echo $row_Recordset1['locationID']; ?>"><?php echo $row_Recordset1['locationName']; ?></a></p>
<?php if ($row_Recordset1['userID'] == $_SESSION['userID']){
	?>
<p id="edit"><a href="editwine.php?wineID=<?php echo $row_Recordset1['wineID']; ?>">Edit Wine</a></p>    
<?php    
}

?>

<p id="lastupdated">Last Updated: <?php echo $row_Recordset1['MONTHNAME(lastUpdated)']; ?> <?php echo $row_Recordset1['DAY(lastUpdated)']; ?> <?php echo $row_Recordset1['YEAR(lastUpdated)'];?></p>
<div id="width">
  <p id="indent"><?php echo $row_Recordset1['wineDesc']; ?></p>
  <h2>Wine Characteristics</h2>
  <p>Wine Taste: <?php echo $row_Recordset1['tasteName']; ?></p>
  <p>Wine Category: <?php echo $row_Recordset1['catName']; ?></p>
</div>
<?php
if($totalRows_Recordset2 == 0)
{
echo "<h2>There are no comments for this wine yet</h2>";
}
else
{
?>
<h2>Comments</h2>
<table border="1">
  <tr>
    <td>User</td>
    <td>Comment</td>
    <td>Rating</td>
  </tr>
  <?php do { ?>
    <tr>
      <td>User: <?php echo $row_Recordset2['userID']; ?><br />
        <?php echo $row_Recordset2['MONTHNAME(commentAdded)']; ?> <?php echo $row_Recordset2['DAY(commentAdded)']; ?> <?php echo $row_Recordset2['YEAR(commentAdded)']; ?></td>
      <td>Title: <?php echo $row_Recordset2['commentTitle']; ?><br />
        Context: <?php echo $row_Recordset2['commentText']; ?></td>
      <td><?php echo $row_Recordset2['rating']; ?></td>
    </tr>
    <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
</table>
<?php
}
?>
<h2>Add Comment</h2>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Title:</td>
      <td><input type="text" name="commentTitle" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Comment:</td>
      <td><textarea name="commentText" cols="50" rows="5"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Rating:</td>
      <td><select name="rating" id="rating">
          <option value="5">5</option>
          <option value="4">4</option>
          <option value="3">3</option>
          <option value="2">2</option>
          <option value="1">1</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Add Comment" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
