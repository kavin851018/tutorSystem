<?php
// This program is used to change the state of attendance.
$target = "login.htm";
include 'check_login.php';

if( $valid )
{
	include '../../connect_db.php';

	$booked_date = $_GET['d'];
	$location = $_GET['location'];
	$booked_order = $_GET['order'];

	// Select out the attendance and then change it.
	$sql = "Select attendance From booked Where booked_date='$booked_date' AND location='$location' AND booked_order='$booked_order'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$attendance = $row['attendance'];
	$attendance = ($attendance + 1) % 2;

	// Update.
	$sql = "Update booked Set attendance=$attendance Where booked_date='$booked_date' AND location='$location' AND booked_order='$booked_order'";
	mysql_query($sql, $conn) or die(mysql_error());
	mysql_close($conn);
	$url = $_SESSION['from'];
	header('Location: ' . $url);
}
?>