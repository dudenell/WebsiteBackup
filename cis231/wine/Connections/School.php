<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_School = "localhost";
$database_School = "carr_db";
$username_School = "djcarr";
$password_School = "xYcdHlw9mr7b00IoZ10A*O@&W";
$School = mysql_pconnect($hostname_School, $username_School, $password_School) or trigger_error(mysql_error(),E_USER_ERROR); 
?>