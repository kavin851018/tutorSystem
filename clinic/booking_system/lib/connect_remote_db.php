<?php
/*
Connect to the remote mysql server (140.117.44.50)

Input: none
Output:
	$conn(resource): database connection.
*/
function connect_fixed_remote_db_()
{
	$RemoteServer = "140.117.44.50";
	$RemoteServerPassword = "LiveABC@nsysu";
	$RemoteServerDB = "gept_utf8_db";
	$conn = mysql_connect($RemoteServer, 'root', $RemoteServerPassword) or die(mysql_error());
	mysql_select_db($RemoteServerDB, $conn) or die(mysql_error());
	return $conn;
}
?>