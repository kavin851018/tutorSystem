<?php
// This file is used to modify the 'put to top' value.

$classify = $_POST['classify'];

include '../../../check_login.php';
include '../../../connect_db.php';

$sql = "Select bulletin_id From bulletin_board Where classify='$classify'";
$result = mysql_query($sql, $conn);

while( $row = mysql_fetch_array($result) )
{
	$temp = "checkbox_" . $row['bulletin_id'];
	// receive checked value
	@$value = $_POST[$temp];
	if( isset($value) && $value != "" )
		$sql = "Update bulletin_board set puttop=1 Where bulletin_id='" . $row['bulletin_id'] . "'";
	else
		$sql = "Update bulletin_board set puttop=0 Where bulletin_id='" . $row['bulletin_id'] . "'";

	mysql_query($sql, $conn);
}

mysql_close($conn);
header('Location: bulletin_manager.php');
?>
