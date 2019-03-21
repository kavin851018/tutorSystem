<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{

include '../../connect_db.php';

$booked_date = $_GET['id'];
$location = $_GET['location'];
$order = $_GET['order'];
$sure = @$_GET['sure'];
$tutor = $_GET['tutor'];

if($sure == "ok")
{
	$sql = "Delete From booked Where booked_date='$booked_date' AND location='$location' AND booked_order='$order' AND tutor='$tutor'";
// Notify the manager!!
$headers = "From: vincent.sm.huang@gmail.com \r\n";
$headers.= "Content-Type: text/html; charset=UTF-8 \r\n";
$headers .= "MIME-Version: 1.0 \r\n";
$message = "User " . $_SESSION['id'] . " are excuting the delete books procedure. Sql=" . $sql;
mail("vincent.sm.huang@gmail.com", $message, $message, $headers);



	mysql_query($sql, $conn);
	mysql_close($conn);
	header('Location: show_management.php');
}
else
{
	echo "<p>&nbsp;</p><p>&nbsp;</p>";
	$title="Delete Booking";
	$mes = "You are deleting a booking!! Are you sure?";
	$title_color="white"; $title_bgcolor="#990000"; $title_size=3; $border_color="#990000";
	$body_bgcolor="white"; $body_fcolor="red"; $body_fsize="2"; $width="300";
	$b_content="Sure"; $b_link="delete_booking3.php?id=" . $booked_date . "&location=" . $location . "&order=" . $order . "&tutor=" . $tutor . "&sure=ok";
	include 'print_message.php';
}

} // login check
?>
