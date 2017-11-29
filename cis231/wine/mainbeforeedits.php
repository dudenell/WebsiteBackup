<?php require_once('logincheck.php'); ?>
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
			echo "<p>Welcome, new user!</p>";
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
<?php
	mysql_connect("localhost", "djcarr", "160950");
	mysql_select_db("carr_db");
	$result = mysql_query("SELECT locationName, locationDescription, locationWebsite FROM location ORDER BY locationLastUpdated DESC LIMIT 2");
?>
<table id="winery">
  <?php
	while($row = mysql_fetch_array($result))
	{
	?>
  <tr>
    <td><?php echo $row[0]; ?></td>
    <td width="70%"><?php echo $row[1]; ?></td>
    <td><a href="<?php echo $row[2]; ?>"><?php echo $row[2]; ?></a></td>
  </tr>
  <?php
	}
	?>
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
          <td><a href="<?php echo $row[2]; ?>"><?php echo $row[2]; ?></a></td>
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