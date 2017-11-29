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
	$locationID = $_SESSION['locationID'];
  $insertSQL = sprintf("INSERT INTO comments (commentTitle, commentText, rating, userID, locationID, commentAdded) VALUES (%s, %s, %s, '$uid', '$locationID', CURRENT_TIMESTAMP )",
                       GetSQLValueString($_POST['commentTitle'], "text"),
                       GetSQLValueString($_POST['commentText'], "text"),
                       GetSQLValueString($_POST['rating'], "int"));


  mysql_select_db($database_School, $School);
  $Result1 = mysql_query($insertSQL, $School) or die(mysql_error());
}

$colname_Recordset1 = "-1";
if (isset($_GET['locationID'])) {
	$_SESSION['locationID'] = $_GET['locationID'];
  $colname_Recordset1 = $_GET['locationID'];
}

mysql_select_db($database_School, $School);
$query_Recordset1 = sprintf("SELECT locationID, locationName, locationDescription, locationWebsite, locationAddress, locationCity, locationState, locationZip, MONTHNAME(locationLastUpdated), DAY(locationLastUpdated), YEAR(locationLastUpdated), userID FROM location WHERE locationID = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);



$colname_Recordset3 = "-1";
if (isset($_GET['locationID'])) {
	$_SESSION['locationID'] = $_GET['locationID'];
  $colname_Recordset3 = $_GET['locationID'];
}
mysql_select_db($database_School, $School);
$query_Recordset3 = sprintf("SELECT wine.wineName, wine.wineDesc, wine.catName, winetaste.tasteName FROM wine INNER JOIN winetaste on wine.tasteID = winetaste.tasteID WHERE locationID = %s", GetSQLValueString($colname_Recordset3, "int"));
$Recordset3 = mysql_query($query_Recordset3, $School) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset2 = "-1";
if (isset($_GET['locationID'])) {
	$_SESSION['locationID'] = $_GET['locationID'];
  $colname_Recordset2 = $_GET['locationID'];
}
mysql_select_db($database_School, $School);
$query_Recordset2 = sprintf("SELECT commentTitle, commentText, YEAR(commentAdded), DAY(commentAdded), MONTHNAME(commentAdded), rating, userID FROM comments WHERE locationID = %s ORDER BY commentAdded DESC", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $School) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row_Recordset1['locationName']; ?></title>
<link href="winery.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<h1><?php echo $row_Recordset1['locationName']; ?></h1>

<?php if ($row_Recordset1['userID'] == $_SESSION['userID']){
	?>
<p id="edit"><a href="editwinery.php?locationID=<?php echo $row_Recordset1['locationID']; ?>">Edit Winery</a></p>    
<?php    
}

?>



<p id="lastupdated">Last Updated: <?php echo $row_Recordset1['MONTHNAME(locationLastUpdated)']; ?> <?php echo $row_Recordset1['DAY(locationLastUpdated)']; ?> <?php echo $row_Recordset1['YEAR(locationLastUpdated)'];?></p>
<div id="width">
  <p id="indent"><?php echo $row_Recordset1['locationDescription']; ?></p>
  <p>Website: <a href="<?php echo $row_Recordset1['locationWebsite']; ?>"><?php echo $row_Recordset1['locationWebsite']; ?></a></p>
  <p id="address">Address: <?php echo $row_Recordset1['locationName']; ?></p>
  <p id="addressindent"><?php echo $row_Recordset1['locationAddress']; ?></p>
  <p id="addressindent"><?php echo $row_Recordset1['locationCity']; ?>, <?php echo $row_Recordset1['locationState']; ?> <?php echo $row_Recordset1['locationZip']; ?> </p>
</div>
</div>
<h2>Wines at location</h2>
<table border="1">
  <tr>
    <td>Wine Name</td>
    <td>Description</td>
    <td>Category</td>
    <td>Taste</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset3['wineName']; ?></td>
      <td><?php echo $row_Recordset3['wineDesc']; ?></td>
      <td><?php echo $row_Recordset3['catName']; ?></td>
      <td><?php echo $row_Recordset3['tasteName']; ?></td>
    </tr>
    <?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)); ?>
</table>
<?php
if($totalRows_Recordset2 == 0)
{
echo "<h2>There are no comments for this winery yet</h2>";
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
<h2>Add a comment</h2>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Title:</td>
      <td><input type="text" name="commentTitle" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Text:</td>
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


mysql_free_result($Recordset3);

mysql_free_result($Recordset2);
?>
