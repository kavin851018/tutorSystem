<?php
// =====
// After input all columns and upload need files, this file will add the records into table 'bulletin_board'.
// =====

$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';

$bulletin_id = $_SESSION['bulletin_id'];
$title = addslashes($_SESSION['title']);
//$content = str_replace("'", "\'", $_SESSION['content']);
$content = addslashes($_SESSION['content']);
$date = $_SESSION['date'];
$classify = $_SESSION['classify'];

$sql = "Insert Into bulletin_board Values('$bulletin_id','$title','$content','$date','$classify',0)";
mysql_query($sql, $conn) or die(mysql_error());
mysql_close($conn);

// Delete all sessions
unset($_SESSION['bulletin_id']);
unset($_SESSION['title']);
unset($_SESSION['content']);
unset($_SESSION['date']);
unset($_SESSION['classify']);

header('Location: bulletin_manager.php');
?>
