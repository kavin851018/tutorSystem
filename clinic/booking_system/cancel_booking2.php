<?php
session_start();

// Receive data
$booked_date =$_SESSION['booked_date'];
$location = $_SESSION['location'];
$order = $_SESSION['order'];
$tutor = $_SESSION['tutor'];
$code = $_POST['code'];

unset($_SESSION['booked_date']);
unset($_SESSION['location']);
unset($_SESSION['order']);
unset($_SESSION['tutor']);

include '../../connect_db.php';
// Check if the code is correct.
$sql = "Select code From booked Where booked_date='$booked_date' AND booked_order='$order' AND location='$location' AND tutor='$tutor' AND code='$code'";
$result = mysql_query($sql, $conn) or die(mysql_error());
$n = mysql_num_rows($result);
$row = mysql_fetch_array($result);

// The inputed code is wrong. Redirect to the previous page.
if( $n == 0 || $code != $row['code'])
{
	$_SESSION['message'] = "<font color=red size=2>Code error!</font>";
	$url = "cancel_booking.php?d=$booked_date&location=$location&order=$order&tutor=$tutor";
	
	// sending the log to manager
	/*
  require("lib/class.phpmailer.php");
  $mail = new PHPMailer();
  //$mail->CharSet = "BIG5";    
  $mail->IsSMTP();  // telling the class to use SMTP
  $mail->Host     = "mail.nsysu.edu.tw"; // SMTP server
  $mail->SMTPAuth   = true;
  $mail->Username   = "onlinelearning";
  $mail->Password   = "jiVx2686";
  $mail->FromName = "";
  $mail->IsHTML(true);
  $mail->From     = "onlinelearning@mail.nsysu.edu.tw";
  $mail->FromName = "System";
  $mail->AddAddress("cfbbqlr@gmail.com");
  $mail->Subject = "A log of cancel error";
  $mail->Body     = "
    booked_date= " . $booked_date . "<br \>
    booked_order= " . $order . "<br \>
    location= " . $location . "<br \>
    tutor= " . $tutor . "<br \>
    code= " . $code . "<br \>
    from: " . $_SERVER['REMOTE_HOST'] . " " . $_SERVER['REMOTE_ADDR'] . "<br \>
    ";
  $mail->Send();*/
	
	header('Location: ' . $url );
	
} else { // The inputed code is correct. Delete the entry and redirect to the 'book.php'

	$sql = "Delete From booked Where booked_date='$booked_date' AND booked_order='$order' AND location='$location' AND tutor='$tutor' AND code='$code'";
	mysql_query($sql, $conn);
	$_SESSION['message'] = "<font color=blue size=2>Cancel booking successfully.</font>";
	mysql_close($conn);
	$m = $_SESSION['book_m']; $d = $_SESSION['book_d']; $y = $_SESSION['book_y'];

	// sending the log to manager
	/*
  require("lib/class.phpmailer.php");
  $mail = new PHPMailer();
  //$mail->CharSet = "BIG5";    
  $mail->IsSMTP();  // telling the class to use SMTP
  $mail->Host     = "mail.nsysu.edu.tw"; // SMTP server
  $mail->SMTPAuth   = true;
  $mail->Username   = "onlinelearning";
  $mail->Password   = "jiVx2686";
  $mail->FromName = "";
  $mail->IsHTML(true);
  $mail->From     = "onlinelearning@mail.nsysu.edu.tw";
  $mail->FromName = "System";
  $mail->AddAddress("cfbbqlr@gmail.com");
  $mail->Subject = "A log of cancel";
  $mail->Body     = "
    booked_date= " . $booked_date . "<br \>
    booked_order= " . $order . "<br \>
    location= " . $location . "<br \>
    tutor= " . $tutor . "<br \>
    code= " . $code . "<br \>
    ";
  $mail->Send();*/
	
	header("Location: book.php?m=$m&d=$d&y=$y");
}
?>