<?php
$target = "show_booking.php";
include 'check_login.php';

if( $valid )
{

// Notify the manager!!
$headers = "From: vincent.sm.huang@gmail.com \r\n";
$headers.= "Content-Type: text/html; charset=UTF-8 \r\n";
$headers .= "MIME-Version: 1.0 \r\n";
$message = "User " . $_SESSION['id'] . " modify the schedule";
mail("vincent.sm.huang@gmail.com", $message, $message, $headers);


// Receive the tutor's id
$tutor = $_POST['tutor'];
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

if( $location == "DELL" )
	$sql = "Update schedule Set monday=$monday, tuesday=$tuesday, wednesday=$wednesday, thursday=$thursday, friday=$friday, email='$email', class='$class' Where tutor_name='$tutor'";
else if( $location == "LIB" )
	$sql = "Update schedule_lib Set monday=$monday, tuesday=$tuesday, wednesday=$wednesday, thursday=$thursday, friday=$friday,email='$email', class='$class' Where tutor_name='$tutor'";
else if( $location == "NIGHT" )
	$sql = "Update schedule_night Set monday=$monday, tuesday=$tuesday, wednesday=$wednesday, thursday=$thursday, friday=$friday,email='$email', class='$class' Where tutor_name='$tutor'";


mysql_query($sql, $conn) or die(mysql_error());
mysql_close($conn);
header('Location: show_management.php');

} // login check
?>