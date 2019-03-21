<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{

include '../../connect_db.php';

//if( $n != 0 )
//{
	$fy = $_POST['fy'];
	$fm = $_POST['fm'];
	$fd = $_POST['fd'];
	$ty = $_POST['ty'];
	$tm = $_POST['tm'];
	$td = $_POST['td'];

	if( $fm < 10 ) $fm = "0" . $fm;
	if( $fd < 10 ) $fd = "0" . $fd;
	if( $tm < 10 ) $tm = "0" . $tm;
	if( $td < 10 ) $td = "0" . $td;

	$sql = "Insert Into holiday values('" . $fy . $fm . $fd . "','" . $ty . $tm . $td . "')";
	mysql_query($sql, $conn);
	mysql_close($conn);
	header('Location: set_holiday1.php');
//}

} // login check
?>
