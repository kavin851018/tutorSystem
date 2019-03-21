<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{

$old_id = $_SESSION['id'];
$id = $_POST['id'];
$passwd = $_POST['passwd'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

include '../../connect_db.php';
$sql = "Update user SET id='$id', passwd='$passwd', name='$name', email='$email', phone='$phone' WHERE id='$old_id'";
mysql_query($sql, $conn) or die(mysql_error());
mysql_close($conn);
$_SESSION['id'] = $id;
$_SESSION['passwd'] = $passwd;
header('Location: show_management.php');

} // login check
?>
