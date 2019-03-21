<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{

include '../../connect_db.php';

$sql = "Select * From booked Order By booked_date";
$result = mysql_query($sql, $conn);
$today = date('Ymd');

while( $row = mysql_fetch_array($result) )
{
	$this_d = substr($row['booked_date'],0 ,8);
	if( $this_d < $today )
	{
		$sql = "Delete From booked Where booked_date='" . $row['booked_date'] . "'";

// Notify the manager!!
$headers = "From: vincent.sm.huang@gmail.com \r\n";
$headers.= "Content-Type: text/html; charset=UTF-8 \r\n";
$headers .= "MIME-Version: 1.0 \r\n";
$message = "User " . $_SESSION['id'] . " are excuting the delete overdue procedure. Sql=" . $sql;
mail("vincent.sm.huang@gmail.com", $message, $message, $headers);

		mysql_query($sql, $conn);
	}
	else
	{
		break;
	}
}
mysql_close($conn);
header('Location: show_management.php');

} // login check
?>
