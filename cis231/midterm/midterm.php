<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Rental Order Confirm</title>
</head>

<body>
<?php 

//Get the variables
$customer =$_POST['fullname'];
$age =$_POST['age'];
$days =$_POST['days'];
$car =$_POST['car_type'];
$carcostextra = 0;

if(isset($_POST['gps'])){
	$carcostextra = $carcostextra + 100;
}

if(isset($_POST['extradriver'])){
	$extradriver = $days * 25;
	$carcostextra = $carcostextra + $extradriver;
}


if ($_POST['fullname'] == NULL or $_POST['days'] == NULL or $_POST['age'] == NULL ){
	echo "<h1>Please go back and fill out all fields</h1>";
}

elseif  ($age > 24)
{

$carcostdays = $days * 19;
$carcostcar = $days * $car;
$carcost = $carcostdays + $carcostcar + $carcostextra;
$carcosttotal = $carcost * 1.08;

		
echo "<h1>Thanks for your order $customer </h1>";
echo "<h1>Total number of days: $days </h1>";
echo "<h1>Extra costs: $carcostextra</h1>";
echo "<h1>Your total cost before tax: $carcost</h1>";
echo "<h1>Your total cost after tax: $carcosttotal </h1>";
}

else{
	echo "<h1>Sorry $customer, you are too young to rent a car, you must be older</h1>";
}


?>
</body>
</html>