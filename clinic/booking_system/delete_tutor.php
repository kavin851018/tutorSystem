<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{

$tutor = $_GET['tutor'];
include '../../connect_db.php';
$sql = "Delete From schedule Where tutor_name='$tutor'";

// Notify the manager!!
$headers = "From: vincent.sm.huang@gmail.com \r\n";
$headers.= "Content-Type: text/html; charset=UTF-8 \r\n";
$headers .= "MIME-Version: 1.0 \r\n";
$message = "User " . $_SESSION['id'] . " are excuting the delete tutor procedure. Sql=" . $sql;
mail("vincent.sm.huang@gmail.com", $message, $message, $headers);


mysql_query($sql, $conn) or die(mysql_error());
mysql_close($conn);
header('Location: show_management.php');

} // login check
?>
