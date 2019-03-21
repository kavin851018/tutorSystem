<?php
session_start();

include '../../connect_db.php';

//$id = $_POST['id'];
//$passwd = $_POST['passwd'];

$id = mysql_real_escape_string($_POST['id']);
$passwd = mysql_real_escape_string($_POST['passwd']);

$sql = "Select * From user Where id='" . $id . "' AND passwd='" . $passwd . "'";
$n = mysql_num_rows(mysql_query($sql, $conn));

if($n)
{
	$_SESSION['id'] = $id;
	$_SESSION['passwd'] = $passwd;
	$_SESSION['login'] = "manager";
	mysql_close($conn);
	header('Location: show_management.php');
}
else
{
	echo "Login failed!";
}
mysql_close($conn);
?>
