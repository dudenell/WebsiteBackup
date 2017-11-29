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
if (isset($_GET['commentID'])) {
  $colname_Recordset1 = $_GET['commentID'];
}
mysql_select_db($database_School, $School);
$query_Recordset1 = sprintf("SELECT commentID, commentTitle, commentText, MONTHNAME(commentAdded), DAY(commentAdded), YEAR(commentAdded), rating, wineID, locationID FROM comments WHERE commentID = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Comment</title>
<link href="viewcomment.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<br />
<table id="viewcomment">
  <tr>
    <td id="padding">Comment Title</td>
    <td id="padding">Text</td>
    <td id="padding">Added</td>
    <td id="padding">Rating</td>
      <?php 
	  if ($row_Recordset1['wineID'] == NULL){
		 echo'<td id="padding">Winery</td>';
	  }
	  else {
		 echo'<td id="padding">Wine</td>';
		
	  }
	  ?>
      <td id="padding">Delete Comment</td>
  </tr>
  <?php do { ?>
    <tr>
      <td id="padding"><?php echo $row_Recordset1['commentTitle']; ?></td>
      <td id="padding"><?php echo $row_Recordset1['commentText']; ?></td>
      <td id="padding"><?php echo $row_Recordset1['MONTHNAME(commentAdded)']; ?> <?php echo $row_Recordset1['DAY(commentAdded)']; ?>, <?php echo $row_Recordset1['YEAR(commentAdded)']; ?></td>
      <td id="padding"><?php echo $row_Recordset1['rating']; ?></td>
      <?php 
	  if ($row_Recordset1['wineID'] == NULL){?>
      
<td id="padding"><a href="winery.php?locationID=<?php echo $row_Recordset1['locationID']; ?>">View Winery</a></td>
	 <?php }
	  else {?>
		<td id="padding"><a href="wine.php?wineID=<?php echo $row_Recordset1['wineID']; ?>">View Wine</a></td>
		  <?php
	  }
	  ?>
      <td id="padding"><a href="deletecomment.php?commentID=<?php echo $row_Recordset1['commentID']; ?>">Delete this comment</a></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
