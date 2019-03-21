<?php

include '../../check_login.php';
if($n != 0 )
{
  include '../../connect_db.php';
  include "lib/check_record_exist.php";
  
  if ( isset($_POST['id']) && $_POST['id']!="" && isset($_POST['start']) && $_POST['start']!="" && isset($_POST['end']) && $_POST['end']!=""  ) {
    $id = strtolower($_POST['id']);
    $start = $_POST['start'];
    $end = $_POST['end']; 
    
    mysql_select_db('splendid', $conn) or die(mysql_error());
    if ( $start > $end ) {
    
      $_SESSION['message'] = "起始日期不能大於終止日期！";
      
    } else if (check_record_exist("booking_blacklist", "student_id", $id, $conn)) {
    
      //$_SESSION['message'] = $id . " 已於黑名單中";
      mysql_select_db('splendid', $conn) or die(mysql_error());
      $sql = "UPDATE booking_blacklist SET starttime='" . $start . "' , endtime='" . $end . "' WHERE student_id='" . $id . "'";
      $result = mysql_query($sql, $conn) or die(mysql_error());
      
    } else {
    
      mysql_select_db('self_access', $conn) or die(mysql_error());
      if( check_record_exist("student", "id", $id, $conn) ) {
        mysql_select_db('splendid', $conn) or die(mysql_error());
        $sql = "INSERT INTO booking_blacklist (student_id, starttime, endtime) VALUES ('" . $id . "', '" . $start . "', '" . $end . "')";
        $result = mysql_query($sql, $conn) or die(mysql_error());
      } else {
        $_SESSION['message'] = "你輸入的學號有誤！<br>(You input a wrong identity!)";
      }
      
    }  
  } else {
    $_SESSION['message'] = "欄位皆不能為空！";
  }
  
}

header("Location: " . $_SESSION['back']);

?>
