<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Course Search Result</title>
</head>

<body>
<?php
mysql_connect("localhost", "student", "student");
mysql_select_db("registrar_db");
$deptID = $_POST['deptID'];
$result = mysql_query("SELECT dept, course_num, title FROM courses join departments on courses.deptID = departments.deptID where courses.deptID = $deptID");
?> 
<h1> Course Search Result</h1>
<table width="100%" border="3" cellpadding="1" cellspacing="1">
<tr>
<td width="25%">Course </td>
<td width="75%">Course Title</td>
</tr>
<?php 
while($row = mysql_fetch_array($result))
{
?>
<tr>
<td><?php echo $row[0]; ?> <?php echo $row[1]; ?></td>
<td><?php echo $row[2]; ?></td>
</tr>
<?php 
}
?>
</table>
</body>
</html>