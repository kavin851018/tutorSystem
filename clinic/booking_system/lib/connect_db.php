<?php
/*
Connect to the local mysql server (140.117.44.50)

Input:
	$db: database name which the user wants to connect.
Output:
	$conn(resource): database connection.
*/
function connect_db($db)
{
	$Server = "localhost";
	$Password = "Zephyr_mysql_serveR";
	$conn = mysql_connect($Server, 'root', $Password) or die(mysql_error());
	mysql_select_db($db, $conn) or die(mysql_error());
	return $conn;
}
?>