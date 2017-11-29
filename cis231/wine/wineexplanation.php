<?php require_once('logincheck.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wine Explanation</title>
<link href="wineexplain.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php require dirname(__FILE__).'/header.php' ?>
<h1>An explaination of wines</h1>
<div id="width">
<p>There are various ways to explain wines and hundreds of categories. When looking at wines between different wineries, they may taste similar but in fact be made very differently. Here's a chart of categories and some of the wines that come off those categories.</p></div>
<IMG class="center" src="images/winechart.png" alt="Wine Chart"/>
<br />
<h2>Using this website, we list our wines by the 5 main categories </h2>
<?php
	mysql_connect("localhost", "djcarr", "160950");
	mysql_select_db("carr_db");
	$result = mysql_query("SELECT catName, catDesc FROM category");
?>
<table id="tableborder">
<?php
	while($row = mysql_fetch_array($result))
	{
	?>
        <tr>
          <td><?php echo $row[0]; ?> - </td>
          <td><?php echo $row[1]; ?></td>
        </tr>
	<?php
	}
	?>
</table>

<h2>From there we break down the wine by it's level of sweetneess</h2>
<?php
	mysql_connect("localhost", "djcarr", "160950");
	mysql_select_db("carr_db");
	$result = mysql_query("SELECT tasteName, tasteDes FROM winetaste");
?>
<table id="tableborder">
<?php
	while($row = mysql_fetch_array($result))
	{
	?>
        <tr>
          <td width="110px"><?php echo $row[0]; ?> - </td>
          <td><?php echo $row[1]; ?></td>
        </tr>
	<?php
	}
	?>
</table>
</body>
</html>