<?php

include '../../check_login.php';
if($n != 0 )
{
  include '../../connect_db.php';
  
  if ( isset($_GET['id']) ) {
    $sql = "DELETE FROM booking_blacklist WHERE student_id='" . $_GET['id'] . "'";
    $result = mysql_query($sql, $conn) or die(mysql_error());  
  }
  
}

header("Location: " . $_SESSION['back']);

?>
