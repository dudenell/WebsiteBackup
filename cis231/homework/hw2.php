<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Details</title>
</head>

<body>
<h1>Order Details</h1>
<?php
$firstname = $_POST['firstname'];
$quantityset = $_POST['quantity'];
$sport = $_POST['sport'];
$gender = $_POST['gender'];
$taxrate = .08;
$cost = 4.95;
$shipping = 5.99;

if(($firstname)== NULL){
	echo "<p>Please go back and enter your first name</p>";
}
elseif(($sport)== NULL){
	echo "<p>Please go back and select the sport</p>";
}
elseif(($gender)== NULL){
	echo "<p>Please go back and select Gender</p>";
}
elseif(($quantityset)== NULL){
	echo "<p>Please go back and select the quantity</p>";
}
elseif(($sport) == "football" && ($gender) == "women")
{
	echo "<p>You can't like football and be a female!</p>";
}
elseif(($sport) == "gymnastics" && ($gender) == "men"){
	echo "<p>You can't like gymnastics and be a man!</p>";
}
else 
	{
	echo "<h2>Your Details are as follows</h2>";
	echo "<p>Name: $firstname</p>";
	echo "<p>Quantity: $quantityset</p>";
	echo "<p>Gender: $gender</p>";
	echo "<p>Sport: $sport</p>";
	//calculate cost before shipping and tax
	//$netcost = $_POST['quantity'] * $cost;
	//This didn't work...
	$netcost = $quantityset * $cost;
	$netcost = number_format($netcost, 2);
	echo "<p>Cost before shipping: $$netcost</p>";
	//add tax
	$totaltax = $taxrate * $netcost;
	$totaltax = round($totaltax, 2);
	$totaltax = number_format($totaltax, 2);
	echo "<p>Total Tax: $$totaltax</p>";
	round($totaltax, 2);
	
	$total = $totaltax + $shipping + $netcost;
	echo "<p>Shipping: $$shipping + Tax: $$totaltax + Net Cost: $$netcost";
	echo "<p>Total $$total</p>";
	}
?>
</body>
</html>