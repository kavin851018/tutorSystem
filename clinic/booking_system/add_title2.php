<?php
$target = "clinic/booking_system/login.htm";
include '../../check_login.php';

if( $n != 0 )
{
	// Receive the tutor's name & location
	$title = $_POST['title'];
	$location = $_POST['location'];
	
	// Recieve the time table.
	$monday = 0;
	$tuesday = 0;
	$wednesday = 0;
	$thursday = 0;
	$friday = 0;
	
	for($i=1; $i<=12; $i++)
	{
		if( isset($_POST['monday' . $i]) ) $monday += $_POST['monday' . $i];
		if( isset($_POST['tuesday' . $i]) ) $tuesday += $_POST['tuesday' . $i];
		if( isset($_POST['wednesday' . $i]) ) $wednesday += $_POST['wednesday' . $i];
		if( isset($_POST['thursday' . $i]) ) $thursday += $_POST['thursday' . $i];
		if( isset($_POST['friday' . $i]) ) $friday += $_POST['friday' . $i];
	}
	
	$id = date('YmdHis');
	include '../../connect_db.php';
	$sql = "Insert into class_title ";
		
	$sql .= "(title_name, location, monday, tuesday, wednesday, thursday, friday,id) Values ('$title','$location',$monday,$tuesday,$wednesday,$thursday,$friday,$id)";
	mysql_query($sql, $conn) or die(mysql_error());
	mysql_close($conn);
	header('Location: show_management.php');
}
?>
