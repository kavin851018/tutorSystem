<?php
// =====
// This file is used to delete a subject. When delete it, it may need to delete all of the corresponding files and records.
// =====

$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';

$bulletin_id = $_GET['bid'];

// Delete all the corresponding files.
$sql = "Select file_name From bulletin_files Where bulletin_id='$bulletin_id'";
$result = mysql_query($sql, $conn) or die(mysql_error());

while( $row = mysql_fetch_array($result) )
{
	unlink("../../../../bulletin_upfiles/" . $row['file_name']);
}

// Remove all of the corresponding records.
$sql = "Delete From bulletin_files Where bulletin_id='$bulletin_id'";
mysql_query($sql, $conn);

// Remove the subject record.
$sql = "Delete From bulletin_board Where bulletin_id='$bulletin_id'";
mysql_query($sql, $conn);
mysql_close($conn);
header('Location: bulletin_manager.php');
?>
