<?php
$target = "show_booking.php";
include 'check_login.php';

if( $valid )
{

// Receive the class id and class title name
$id = $_POST['id'];
$title_name = $_POST['title_name'];

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
$sql = "Update class_title Set title_name='$title_name',monday=$monday, tuesday=$tuesday, wednesday=$wednesday, thursday=$thursday, friday=$friday Where id='$id'";

// Notify the manager!!
$headers = "From: zkhong93@gmail.com \r\n";
$headers.= "Content-Type: text/html; charset=UTF-8 \r\n";
$headers .= "MIME-Version: 1.0 \r\n";
$message = "User " . $_SESSION['id'] . " are excuting the modify class procedure. Sql=" . $sql;
mail("zkhong93@gmail.com", $message, $message, $headers);

mysql_query($sql, $conn) or die(mysql_error());
mysql_close($conn);
header('Location: show_management.php');

} // login check
?>