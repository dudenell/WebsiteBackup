<html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Order Confirmation</title>
<link href="cis231.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
if( $_POST['name'] == "" || $_POST['email'] == "" || $_POST['quantity'] == "" || !isset($_POST['seats']) || !is_numeric($_POST['quantity'])) 
{

echo "<h1>You have missing or incorrect data. Go back to the form.</h1>";
}
else
{
?> 
<h1>Thanks for the order, <?php echo $_POST['name']; ?></h1>

<?php
if($_POST['seats'] == "mvp")
{
$seatcost = 300;
}
elseif($_POST['seats'] == "field")
{
$seatcost = 100;
}
else
{
$seatcost = 28;
}
$ticketcost = $_POST['quantity'] * $seatcost;
if(isset($_POST['boxoffice']))
{
$ticketcost = $ticketcost + 12;
}
?>
<p>
You have ordered 
<?php echo $_POST['quantity']." ". $_POST['seats']." seats at a cost of $".$ticketcost; ?>. Thank you.</p>
<p>
<?php
if(isset($_POST['boxoffice']))
{ echo "Pick them up at the box office";
}
else
{
echo "They will be emailed to you";
}
?>
</p>
<?php
}
?>
</body>
</html>