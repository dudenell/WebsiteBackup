<?php
//Start session
session_start();
//Check whether the session variable
//userID is present or not
if(!isset($_SESSION['userID']) || (trim($_SESSION['userID'])=="")) {
header("Location: index.php");
exit();
}
?>