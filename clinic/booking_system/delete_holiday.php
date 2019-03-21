<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{

include '../../connect_db.php';

$f = $_GET['f'];
$t = $_GET['t'];

$sql = "Delete From holiday Where from_date='" . $f . "' AND to_date='" . $t . "'";
mysql_query($sql, $conn);
mysql_close($conn);
header('Location: set_holiday1.php');

} // login check
?>
