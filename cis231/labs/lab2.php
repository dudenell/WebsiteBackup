<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pizza Order Details</title>
</head>

<body>
<!--Start of error checking -->

<?php
if($_POST['name'] == NULL || $_POST['quantity'] == NULL || !is_numeric($_POST['quantity']))
{
?>
<h1>Incomplete data</h1>
<p>Please return to the <a href="lab2.html">form</a> and fill out completely</p>
<?php 
}
else
{ 
?>

<!--End of error checking -->

<h1>Thanks for the order, <?php echo $_POST['name'] ?>!</h1>
<?php 
$pizzacost = 8;
if(isset($_POST['meatlovers']))
{
$pizzacost = $pizzacost + 3;
}
if(isset($_POST['cheese']))
{
$pizzacost = $pizzacost + 1.5;
}
$total = $pizzacost * $_POST['quantity'];
if($_POST['method'] == "delivered")
{
$total = $total + 2;
}
?>
<p>Your total bill for pizza is: $<?php echo number_format($total, 2) ?> </p>
<!--Start of error checking -->

<?php
}
?>

<!--End of error checking -->
</body>
</html>
