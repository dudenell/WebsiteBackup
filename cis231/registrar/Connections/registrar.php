<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_registrar = "localhost";
$database_registrar = "registrar_db";
$username_registrar = "student";
$password_registrar = "student";
$registrar = mysql_connect($hostname_registrar, $username_registrar, $password_registrar) or trigger_error(mysql_error(),E_USER_ERROR); 
?>