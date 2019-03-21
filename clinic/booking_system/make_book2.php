<?php
session_start();
header('meta http-equiv="Content-Type" content="text/html; charset=big5"');

$d = $_POST['d'];
// $different_date is used to check if the received booking is in the valid date (booking at two days before)
$received_date = strtotime( substr($d, 0, 8) );
$this_date = strtotime( "+1 day", strtotime(date("Ymd")));
$different_date = $received_date - $this_date;

//
$today = substr($d, 0, 8);
$limit = date("Ymd", strtotime("+ 2weeks", strtotime(date("Ymd"))));

if( $_SESSION['from'] == "yes" && ($different_date>=0) && ($limit>=$today) )
{
	include "lib/connect_db.php";
	include "lib/check_record_exist.php";
	
	$location = $_POST['location'];
	$id = $_POST['id'];
	//$name = $_POST['name'];
	//$dept = $_POST['dept'];
	$booked_order = $_POST['order'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$code = $_POST['code'];
	$tutor = $_POST['tutor'];
	$_SESSION['student_id'] = $id;
	//$_SESSION['student_name'] = $name;
	//$_SESSION['student_dept'] = $dept;
	$_SESSION['student_email'] = $email;
	$_SESSION['student_phone'] = $phone;
	$url = "make_book.php?d=$d&location=$location&order=$booked_order&tutor=$tutor";
//	http://zephyr.nsysu.edu.tw/splendid/clinic/booking_system/make_book.php?d=20080926512&location=DELL&order=2&tutor=Yuying
	$b_link="book.php?m=" . $_SESSION['book_m'] . "&d=" . $_SESSION['book_d'] . "&y=" . $_SESSION['book_y'];

  $black = 0;
  $conn = connect_db("splendid");
	if( check_record_exist("booking_blacklist", "student_id", $id, $conn) ) 
	{
	  $sql = "SELECT * FROM booking_blacklist WHERE student_id='" . $id . "'";
    $result = mysql_query($sql, $conn) or die(mysql_error());
    $row = mysql_fetch_array($result);
    $today = strtotime( date("Y/m/d") );
    $start = strtotime( $row['starttime'] );
    $end = strtotime( $row['endtime'] ); 
    
    if ( $today>=$start && $today<=$end ) {
	   $black = 1;
      $_SESSION['message'] = "此學號已被列為黑名單！<br>(The identity has been blacklisted.)";
		  header("Location: $url");
		}
  }
  
  if ( !$black ) {
    
    $conn = connect_db("self_access");
    if( check_record_exist("student", "id", $id, $conn) )
  	{
  		
		// Check the input columns
  		$_SESSION['message'] = "";
  		//if( $name == "" ) $_SESSION['message'] .= "Name<br>";
  		//if( $dept == "" ) $_SESSION['message'] .= "Department<br>";
  		if( $email == "") $_SESSION['message'] .= "Emai<br>";
  		if( $phone == "") $_SESSION['message'] .= "Phone<br>";
  		if( $code == "" ) $_SESSION['message'] .= "Code";
  
  		if($_SESSION['message'] == "" ) // Check ok.
  		{
		
  			$conn = connect_db("self_access");
			$sql = "SELECT firstname, dept FROM student WHERE id='" . $id . "'";
			$result = mysql_query($sql, $conn) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$name = $row['firstname'];
			$dept = $row['dept'];
			
			
			
			// Check if the date of this booking was booked twice.
  			$conn2 = connect_db("splendid");
  			$sql = "Select * From booked Where location='$location' AND booked_date='$d' AND booked_order=$booked_order AND tutor='$tutor'";
  			$n = mysql_num_rows( mysql_query($sql, $conn2) );
  
  			if(!$n)
  			{
  				// Check if the user has booked another period (a user just can book a hour per day).
  				
				$booked_period = substr($d, 8);
  				$like_d = substr($d, 0, 8) . "%";
  				$sql = "Select booked_date From booked Where booked_date Like '$like_d' AND student_id='$id'";
  				$result = mysql_query($sql, $conn) or die(mysql_error());
  				$n = mysql_num_rows($result);
  				$n2 = 0; // 0 => the user can book the period. 1 => the user cannot book this period.
  				while( $row = mysql_fetch_array($result) )
  				{
  					if( $row['booked_date'] != $d )
  						$n2 = 1;
  				}
				
  				// Check if the user has booked the same period with different tutor.
  				$sql = "Select tutor From booked Where booked_date='$d' AND student_id='$id'";
  				$result = mysql_query($sql, $conn) or die(mysql_error());
  				$n3 = mysql_num_rows($result);
  				if( $n3 != 0 )
  				{
  					$row = mysql_fetch_array($result);
  					if( $row['tutor'] == $tutor )
  						$n3 = 0;
  					else
  						$n3 = 1;
  				}
				
  				if( $n2 == 0 && $n3 == 0 )
  				{
  					// Insert record into the database.
  					$sql = "Insert Into booked Values('$d', '', '$dept', '$location', '$booked_order', '$code', '$email', '$phone', '0', '$id','$tutor')";
  					//echo $sql."<br>";
					mysql_query($sql, $conn2) or die(mysql_error());
  					$title = "預約成功(Successfully)";
  					$mes = "預約成功，請準時前往自學中心。(Successfully! Please go to Self-Access Center on time.)";
  					$mes .= "<br><br><font color=red>注意！若您無法預期前往自學中心，請利用下面此組密碼來取消您的預約。";
  					$mes .= "<table bgcolor=#BFDFFF border=0 cellspacing=0 cellpadding=0 align=center><tr><td><font size=2 color=purple>" . $code . "</font></td></tr></table>";
  					$mes .= "<br>請妥善保存此密碼以備取消預約之用,此組密碼只能用於取消目前預約的時段~(避免被他人得知此組密碼,以免被惡意取消預約)</font>";
					$mes .= "<p><font color='ff0000'  ><b>限使用本人帳號登記，請務必攜帶學生證或職員證前往諮詢，身分不符一經發現，將列入黑名單且半年內不得預約。</b></font></p>";
					
  					$title_color="white"; $title_bgcolor="#006633"; $title_size=3; $border_color="#006633";
  					$body_bgcolor="white"; $body_fcolor="blue"; $body_fsize="2"; $width="400";
  					$b_content="確定";
  					include 'print_message.php';
  				}
  				elseif( $n2 != 0 )
  				{
  					echo "<p>&nbsp;</p>";
  					$title="預約失敗(Booked failed)";
  					$mes = "<br><div align=center>抱歉！一天只能預約一個時段</div>";
  					$title_color="white"; $title_bgcolor="#990000"; $title_size=3; $border_color="#990000";
  					$body_bgcolor="white"; $body_fcolor="red"; $body_fsize="2"; $width="400";
  					$b_content="確定";
  					include 'print_message.php';
  				}
  				elseif( $n3 != 0 )
  				{
  					echo "<p>&nbsp;</p>";
  					$title="預約失敗(Booked failed)";
  					$mes = "<br><div align=center>抱歉！你不能在同一個時段裡預約兩位Tutor</div>";
  					$title_color="white"; $title_bgcolor="#990000"; $title_size=3; $border_color="#990000";
  					$body_bgcolor="white"; $body_fcolor="red"; $body_fsize="2"; $width="400";
  					$b_content="確定";
  					include 'print_message.php';
  				}
				echo "3";
  			}
  			else
  			{
  				echo "<p>&nbsp;</p>";
  				$title="預約失敗(Booked failed)";
  				$mes = "抱歉！該時段已經被預約。<br>(Sorry! The period you want has been booked.)";
  				$title_color="white"; $title_bgcolor="#990000"; $title_size=3; $border_color="#990000";
  				$body_bgcolor="white"; $body_fcolor="red"; $body_fsize="2"; $width="400";
  				$b_content="確定";
  				include 'print_message.php';
  			}
  
  			$_SESSION['from'] = "";
  
  			// unset the session variables.
  			$_SESSION['student_id'] = "";
  			$_SESSION['student_name'] = "";
  			$_SESSION['student_dept'] = "";
  			$_SESSION['student_email'] = "";
  			$_SESSION['student_phone'] = "";
  			unset($_SESSION['student_id']);
  			unset($_SESSION['student_name']);
  			unset($_SESSION['student_dept']);
  			unset($_SESSION['student_email']);
  			unset($_SESSION['student_phone']);
  		}
  		else // There are some errors of inputed columns. Redirect to 'make_book1.php'.
  		{
  			$_SESSION['message'] = "The following columns are wrong:<br>" . $_SESSION['message'];
  			header("Location: $url");
  		}
  	} // check_record_exist
  	else
  	{
  		$_SESSION['message'] = "你輸入的學號有誤！<br>(You input a wrong identity!)";
  		header("Location: $url");
  	}
	
	}
}
else
{
	header('Location: book.php');
}

function make_seed()
{
   list($usec, $sec) = explode(' ', microtime());
   return (float) $sec + ((float) $usec * 100000);
}
?>
