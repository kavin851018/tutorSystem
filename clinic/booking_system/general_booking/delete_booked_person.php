<?php
$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';

$id = $_GET['id'];
$booked_id = $_GET['bid'];
$sql = "Delete From general_booked Where id='$id'";
mysql_query($sql, $conn) or die(mysql_error());
mysql_close($conn);
header('Location: booked_person.php?id=' . $booked_id);
?>