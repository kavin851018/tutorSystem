<?php
// This file is used to delete the booked data.
$target = "login.htm";
include 'check_login.php';
if( $valid )
{
	$booked_date = $_SESSION['booked_date'];
	$location = $_SESSION['location'];
	$booked_order = $_SESSION['booked_order'];

	// Initial the session data;
	$_SESSION['booked_date'] = ""; unset($_SESSION['booked_date']);
	$_SESSION['location'] = ""; unset($_SESSION['location']);
	$_SESSION['booked_order'] = ""; unset($_SESSION['booked_order']);
		
	include 'connect_db.php';
	$sql = "Delete From booked Where booked_date='$booked_date' AND location='$location' AND booked_order='$booked_order'";
	mysql_query($sql, $conn) or die(mysql_error());
	mysql_close($conn);
	$url = $_SESSION['from'];
	header('Location:' . $url);
}
?>