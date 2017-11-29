<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dan's Music Survey</title>
</head>
<body>
<h1>Survey Results</h1>
<?php
$name = $_POST['name'];
$age = $_POST['agegroup'];
$music = $_POST['music'];
if(($name)== NULL){
	echo "<p>Please go back and enter your first name</p>";
}
elseif(($age)== NULL){
	echo "<p>Please go back and select your age</p>";
}
elseif(($music)== NULL){
	echo "<p>Please go back and select your favorite music</p>";
}
else
{
	echo "<p>What a coincidence $name, I am also a $age and $music is also my favorite 		type of music!</p>
<p>Thanks for taking the survey!</p>
<p>Dan</p>";
}
?>
</body>
</html>