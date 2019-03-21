<?php
// ====================
// Remove a added file
// ====================

$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';
$_SESSION['del_file'] = "yes";

$bulletin_id = $_GET['id'];
$file_name = $_GET['fn'];

// Delete file from the directory
$file = "../../../../bulletin_upfiles/" . $file_name;
unlink($file);

// Remove the record from the database
$sql = "Delete From bulletin_files Where bulletin_id='$bulletin_id' && file_name='$file_name'";
mysql_query($sql, $conn);
mysql_close($conn);
header('Location: add_subject2.php?id=' . $bulletin_id );
?>
