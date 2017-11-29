<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Room Confirmation</title>
</head>

<body>
<?php

//Get the variables
$fullname =$_POST['fullname'];
$nights =$_POST['nights'];
$rooms =$_POST['rooms'];
$smoking =$_POST['smoking'];
$roomextra = 0;

if(isset($_POST['pet'])){
	$roomextra = $roomextra + 200;
}

if(isset($_POST['breakfast'])){
	$breakfast = $nights * 25;
	$roomextra = $roomextra + $breakfast;
}

if ($_POST['fullname'] == NULL or $_POST['nights'] == NULL){
	echo "<h1>Please go back and fill out all fields</h1>";
}
else {
	$roomcost = $rooms * $nights;
	$roomcost = $roomcost + $smoking;
	$total = $roomcost + $roomextra;
	echo "<h1>Thanks for your stay $fullname </h1>";
	echo "<h1>Total number of nights: $nights </h1>";
	echo "<h1>Extra costs: $roomextra</h1>";
	echo "<h1>Total: $total</h1>";
	if(isset($_POST['pet'])){
		echo "<h1>We enjoy having pets, thanks for bringing fluffy!</h1>";
		}
	else{
		echo "<h1>We enjoy having pets, please consider bringing fluffy next time!</h1>";
	}
	if(isset($_POST['breakfast'])){
		echo "<h1>Our breakfast is the best!</h1>";
	}
}
?>
</body>
</html>