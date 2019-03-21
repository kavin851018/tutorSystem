<?php
// This file is used to check if the login user is valid.
session_start();
@$id = $_SESSION['id'];
@$passwd = $_SESSION['passwd'];

if( isset($id) && $id != "" && isset($passwd) && $passwd != "")
{
	include 'connect_db.php';
	$sql = "Select * From user Where id='" . $id . "' AND passwd='" . $passwd . "'";
	$valid = mysql_num_rows(mysql_query($sql, $conn));
	mysql_close($conn);
}
else
	header('Location: ' . $target);

if(!$valid)
	header('Location: ' . $target);
?>
