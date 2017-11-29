<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search for Courses</title>
</head>

<body>
<?php
mysql_connect("localhost", "student", "student");
mysql_select_db("registrar_db");
$result = mysql_query("SELECT deptID, dept, deptname FROM departments");
?>
<form id="form1" name="form1" method="post" action="lab6results.php">
  <h1>Search For Courses</h1>
  <p>Departments
    <select name="deptID" id="deptID">
      <?php 
while($row = mysql_fetch_array($result))
{
?>
      <option value="<?php echo $row[0]; ?>"><?php echo $row[2]; ?> - <?php echo $row[1]; ?></option>
      <?php
}
?>
    </select>
  </p>
  <p>
    <input type="submit" name="button" id="button" value="Search for courses" />
    <input type="reset" name="button2" id="button2" value="Restart Search" />
  </p>
</form>
</body>
</html>