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
$query_Recordset1 = "SELECT catName, catDesc FROM category";
$Recordset1 = mysql_query($query_Recordset1, $School) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_School, $School);
$query_Recordset2 = "SELECT tasteID, tasteName, tasteDes FROM winetaste";
$Recordset2 = mysql_query($query_Recordset2, $School) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<?php require_once('logincheck.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search by Wine</title>
<link href="search.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<h1>Search Page</h1>
<h2>Search for wine by category</h2>

<form name="form" id="form">
  <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">

          <?php
		do { 
		?>
		<option value="searchcat.php?catName=<?php echo $row_Recordset1['catName']?>"><?php echo $row_Recordset1['catName']?></option>
		<?php
			} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
			$rows = mysql_num_rows($Recordset1);
			if($rows > 0) {
				mysql_data_seek($Recordset1, 0);
				$row_Recordset1 = mysql_fetch_assoc($Recordset1);
			}
		?>
    
  </select>
</form>


<h2>Search for wine by taste</h2>
<form name="form" id="form">
  <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">

          <?php
		do { 
		?>
		<option value="searchtaste.php?tasteID=<?php echo $row_Recordset2['tasteID']?>"><?php echo $row_Recordset2['tasteName']?></option>
		<?php
			} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
			$rows = mysql_num_rows($Recordset2);
			if($rows > 0) {
				mysql_data_seek($Recordset2, 0);
				$row_Recordset2 = mysql_fetch_assoc($Recordset2);
			}
		?>
    
  </select>
</form>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

?>
