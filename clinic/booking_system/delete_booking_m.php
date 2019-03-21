<?php
$target = "login.htm";
include 'check_login.php';
if( $valid )
{
	$booked_date = $_GET['d'];
	$location = $_GET['location'];
	$booked_order = $_GET['order'];
	$_SESSION['booked_date'] = $booked_date;
	$_SESSION['location'] = $location;
	$_SESSION['booked_order'] = $booked_order;

	// The array of Time slot.
	$time_slot = array("2048" => "9:00~10:00", "1024" => "10:00~11:00", "512" => "11:00~12:00", "256" => "12:00~13:00", "128" => "13:00~14:00", "64" => "14:00~15:00", "32" => "15:00~16:00", "16" => "16:00~17:00", "8" => "17:00~18:00", "4" => "18:00~19:00", "2" => "19:00~20:00", "1" => "20:00~21:00");
	
	// Extract the month, day, and time
	$month = substr($booked_date, 4, 2);
	$day = substr($booked_date, 6, 2);
	$time = substr($booked_date, 8, strlen($booked_date) - 8);
	
	// Select out the booked date.
	include 'connect_db.php';
	$sql = "Select * From booked Where booked_date='$booked_date' AND location='$location' AND booked_order='$booked_order'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>Delete booking</title>
<style type="text/css">
<!--
A:hover {LEFT: 1px; POSITION: relative; TOP: 1px; text-decoration:none}
.style1 {color: #FFFFFF;font-size: 16px;font-weight: bold;font-family: Arial, Helvetica, sans-serif;}
.style2 {color: #003366;font-size: 13px;font-family: Arial, Helvetica, sans-serif;}
.style3 {color: #339900;font-size: 11px;font-family: Arial, Helvetica, sans-serif;}
-->
</style>
</head>

<body>
<p>&nbsp;</p>
<table width="300"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#990000">
  <tr>
    <td align="center"><span class="style1">Delete Booking </span></td>
  </tr>
  <tr class="style2">
    <td bgcolor="#FFFFFF"><p class="style2">You are going to delete the booking:</p>
      <table width="80%"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr bgcolor="#FFFFFF" class="style2">
          <td>&nbsp;</td>
          <td align="center"><?php echo $month . "/" . $day;?></td>
        </tr>
        <tr bgcolor="#FFFFFF" class="style2">
          <td align="center"><?php echo $time_slot[$time];?></td>
          <td align=center class=style3><?php if( $row['booked_order'] == 1) echo "0~25"; else echo "30~55";?><br>Name: <?php echo $row['name'];?><br>Dept: <?php echo $row['dept'];?></td>
        </tr>
      </table>
    <p align=center>[<a href="<?php echo $_SESSION['from'];?>"><font color=blue>Back</font></a>] [<a href="delete_booking_m2.php"><font color=red>Yes</font></a>] </p></td>
  </tr>
</table>
</body>
</html>
<?
mysql_close($conn);
} // Valid.
?>