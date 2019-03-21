<?php
$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';

// Generate id
$id = date('YmdHis');
// Receive form data
$topic = addslashes($_POST['topic']);
$description = addslashes($_POST['description']);
$max = $_POST['max'];
$time = $_POST['start_yy'] . "-" . $_POST['start_mm'] . "-" . $_POST['start_dd'] . " " . $_POST['hour'] . ":" . $_POST['minite'];
$location = addslashes($_POST['location']);
$compere = addslashes($_POST['compere']);
$deadline = $_POST['yy'] . "-" . $_POST['mm'] . "-" . $_POST['dd'];

$sql = "Insert Into general_booking Values('$id','$topic','$description',$max,'$deadline','$time','$location','$compere')";
mysql_query($sql, $conn) or die(mysql_error());
mysql_close($conn);

header('Location: show_general_booking.php');
?>
