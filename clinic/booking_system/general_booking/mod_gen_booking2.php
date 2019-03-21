<?php
$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';

// Receive form data
$id = $_POST['id'];
$topic = addslashes($_POST['topic']);
$description = addslashes($_POST['description']);
$max = $_POST['max'];
$time = $_POST['start_yy'] . "-" . $_POST['start_mm'] . "-" . $_POST['start_dd'] . " " . $_POST['hour'] . ":" . $_POST['minite'];
$location = $_POST['location'];
$compere = $_POST['compere'];
$deadline = $_POST['yy'] . "-" . $_POST['mm'] . "-" . $_POST['dd'];

$sql = "Update general_booking Set topic='$topic', description='$description', max_booking=$max, deadline='$deadline', time='$time', location='$location', compere='$compere' Where id='$id'";
mysql_query($sql, $conn) or die(mysql_error());
mysql_close($conn);

header('Location: show_general_booking.php');
?>
