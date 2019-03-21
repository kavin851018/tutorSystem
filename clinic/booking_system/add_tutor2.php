<?php
$target = "clinic/booking_system/login.htm";
include '../../check_login.php';

if( $n != 0 )
{
	// Receive the tutor's name & location
	$name = $_POST['name'];
	$location = $_POST['location'];
	$email = $_POST['email'];
	$class = $_POST['class'];
	
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
	
	include '../../connect_db.php';
	if($location == "DELL")
		$sql = "Insert into schedule ";
	else if($location == "LIB")
		$sql = "Insert Into schedule_lib ";
	else if($location == "NIGHT")
		$sql = "Insert Into schedule_night ";
				
	$sql .= "(tutor_name, monday, tuesday, wednesday, thursday, friday,email,class) Values ('$name',$monday,$tuesday,$wednesday,$thursday,$friday,'$email', $class)";
	mysql_query($sql, $conn) or die(mysql_error());
	mysql_close($conn);
	header('Location: show_management.php');
}
?>
