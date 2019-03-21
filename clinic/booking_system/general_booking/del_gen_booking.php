<?php
$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';

$id = $_GET['id'];

if ( strstr( $id, "'") == FALSE ) {  // SQL injection
  // Delete the booked person associate to this booking
  $sql = "Delete From general_booked Where booked_id='$id'";
  mysql_query($sql, $conn) or die(mysql_error());
  
  // Delete the booking
  $sql = "Delete From general_booking Where id='$id'";
  mysql_query($sql, $conn) or die(mysql_error());
  mysql_close($conn);
}

header('Location: show_general_booking.php');
?>
