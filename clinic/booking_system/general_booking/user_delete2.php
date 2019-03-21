<?php
session_start();

// Generate 'id' and check if it is existed in the database.
include '../../../connect_db.php';
//srand(make_seed());
/*while(true)
{
	$id = date('YmdHis') . rand(10,99);
	$sql = "Select id from general_booked Where id='$id'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$n = mysql_num_rows($result);
	if(!$n)	break;
}*/

$name = $_POST['name'];
//$dept = $_POST['dept'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$booked_id = $_POST['booked_id'];

// Check the deadline
/*$sql = "Select deadline From general_booking Where id='$booked_id'";
$row = mysql_fetch_array(mysql_query($sql, $conn));
$deadline = strtotime($row['deadline']);
$now = strtotime(date('Y-m-d'));

if ($now > $deadline) {
  header("Location: view_detail.php?id=$booked_id");
} else {*/
  
  // Check if the input fileds are not empty
  $_SESSION['message'] = '';
  if( $name == "" ) $_SESSION['message'] .= "您未輸入姓名欄位";
  if( $email == "" || $phone == "" ) $_SESSION['message'] .= "您未輸入email或電話(請至少輸入一項)";
  
  /*/ Check if the "name" has existed
  $sql = "Select Count(*) From general_booked Where booked_id='$booked_id' AND name='$name'";
  $result = mysql_query($sql, $conn) or die(mysql_error());
  $row = mysql_fetch_row($result);
  if( $row[0] != 0 ) $_SESSION['message'] .= "您輸入的姓名已預約"; */
  

  //Delete booking

  if( $_SESSION['message'] == ''){
    $sql = "DELETE FROM `general_booked` WHERE `name`='$name' AND `phone`='$phone' AND `email`='$email' AND `booked_id`='$booked_id'";
    if(mysql_query($sql, $conn)){
      $_SESSION['message'] = "<font color=red size=5>取消成功</font>";
      mysql_close($conn);
      header('location:view_detail.php?id='.$booked_id);
    }
    else{
      $_SESSION['message'] = "<font color=red size=5>取消失敗</font>";
      header('location:view_detail.php?id='.$booked_id);
    }
  }
  else{
    $_SESSION['name'] = $name;
    $_SESSION['dept'] = $dept;
    $_SESSION['phone'] = $phone;
    $_SESSION['email'] = $email;
    header("Location: user_delete.php?id=$booked_id");
  }
  /*
  //check number
  $sql = "Select max_booking From general_booking Where id='$booked_id'";
  $row = mysql_fetch_array(mysql_query($sql, $conn));
  $max_num = $row['max_booking'];
  
  $sql = "Select Count(*) From general_booked Where booked_id='$booked_id'";
  $result = mysql_query($sql, $conn) or die(mysql_error());
  $row = mysql_fetch_row($result);
  $now_num = $row[0];
  if($max_num<=$now_num)$_SESSION['message'].="<br>抱歉! 報名人數已滿";
  
  if( $_SESSION['message'] == '' )
  {
  	$sql = "Insert Into general_booked Values('$id','$name','$dept','$phone','$email','$booked_id')";
  	mysql_query($sql, $conn) or die(mysql_error());
  	mysql_close($conn);
  
  	$_SESSION['message'] = "<font color=blue size=2>預約成功</font>";
  	header('Location: view_detail.php?id=' . $booked_id);
  }
  else
  {
  	$_SESSION['name'] = $name;
  	$_SESSION['dept'] = $dept;
  	$_SESSION['phone'] = $phone;
  	$_SESSION['email'] = $email;
  	header("Location: user_book.php?id=$booked_id");
  }
}*/

function make_seed()
{
   list($usec, $sec) = explode(' ', microtime());
   return (float) $sec + ((float) $usec * 100000);
}
?>
