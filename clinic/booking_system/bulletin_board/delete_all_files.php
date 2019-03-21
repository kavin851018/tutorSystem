<?php
// =====
// When user cancel the adding action, system must remove all the uploaded files and records
// =====

$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';

$bulletin_id = $_SESSION['bulletin_id'];

// Delete all of the file
$sql = "Select file_name From bulletin_files Where bulletin_id='$bulletin_id'";
$result = mysql_query($sql, $conn);
while( $row = mysql_fetch_array($result) )
{
	unlink("../../../../bulletin_upfiles/" . $row['file_name']);
}

$sql = "Delete From bulletin_files Where bulletin_id='$bulletin_id'";
mysql_query($sql, $conn);

unset($_SESSION['bulletin_id']);
unset($_SESSION['title']);
unset($_SESSION['content']);
unset($_SESSION['date']);
unset($_SESSION['classify']);

mysql_close($conn);
header('Location: bulletin_manager.php');
?>
