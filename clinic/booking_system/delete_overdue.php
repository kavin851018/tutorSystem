<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{

include '../../connect_db.php';

$period = array ("2048" => "9:00~10:00", "1024" => "10:00~11:00", "512" => "11:00~12:00", "256" => "12:00~13:00", "128" => "13:00~14:00", "64" => "14:00~15:00", "32" => "15:00~16:00", "16" => "16:00~17:00", "8" => "17:00~18:00","4" => "18:00~19:00", "2" => "19:00~20:00","1" => "20:00~21:00");

$today = date('Ymd');
$sql = "Select * From booked Order By booked_date";
$result = mysql_query($sql, $conn);

if( $row=mysql_fetch_array($result) )
{
	echo "<table width=\"700\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\" bgcolor=\"#996600\" align=center>";
	echo "<tr><td colspan=9 align=center><font color=white>Search result of overdue bookings</font></td></tr>";
	echo "<tr bgcolor=#FFEBC1>";
	echo "<td>&nbsp;</td>";
	echo "<td><font size=2 color=blue>姓名</font></td>";
	echo "<td><font size=2 color=blue>學號</font></td>";
	echo "<td><font size=2 color=blue>系級</font></td>";
	echo "<td><font size=2 color=blue>預約地點</font></td>";
	echo "<td><font size=2 color=blue>預約日期</font></td>";
	echo "<td><font size=2 color=blue>預約時段</font></td>";
	echo "<td><font size=2 color=blue>Email</font></td>";
	echo "<td><font size=2 color=blue>Phone</font></td>";
	echo "</tr>";

	$i = 1;
	do
	{
		if( substr($row['booked_date'], 0, 8) < $today )
		{
			$yy = substr($row['booked_date'], 0, 4);
			$mm = substr($row['booked_date'], 4, 2);
			$dd = substr($row['booked_date'], 6, 2);
			$tt = substr($row['booked_date'], 8);
			echo "<tr bgcolor=white>";
			echo "<td><font color=green size=2>" . $i . "</font></td>";
			echo "<td><font color=green size=2>" . $row['name'] . "</font></td>";
			echo "<td><font color=green size=2>" . $row['student_id'] . "</font></td>";
			echo "<td><font color=green size=2>" . $row['dept'] . "</font></td>";
			echo "<td><font color=green size=2>" . $row['location'] . "</font></td>";
			echo "<td><font color=green size=2>" . $yy . "/" . $mm . "/" . $dd . "</font></td>";
			echo "<td><font color=green size=2>" . (isset($period[$tt])?$period[$tt]:"");
			if( $row['booked_order'] == 1 )
				echo "(0~25)</font></td>";
			else
				echo "(30~55)</font></td>";

			echo "<td><font color=green size=2>" . $row['email'] . "</font></td>";
			echo "<td><font color=green size=2>" . $row['phone'] . "</font></td>";
			echo "</tr>";
			$i++;
		}
	}while( $row=mysql_fetch_array($result) );
	echo "</table><p>&nbsp;</p>";
	
	$title="Confirm";
	$mes = "You are going to delete all of the overdue bookings! Are you sure?";
	$title_color="white"; $title_bgcolor="#990000"; $title_size=3; $border_color="#990000";
	$body_bgcolor="white"; $body_fcolor="red"; $body_fsize="2"; $width="300";
	$b_content="Sure"; $b_link="delete_overdue2.php";
	include 'print_message.php';
}
else
{
	echo "<p>&nbsp;</p><p>&nbsp</p>";
	$title="No data";
	$mes = "There is no booking which is overdue.";
	$title_color="white"; $title_bgcolor="#006600"; $title_size=3; $border_color="#006600";
	$body_bgcolor="white"; $body_fcolor="green"; $body_fsize="2"; $width="300";
	$b_content="Sure"; $b_link="show_management.php";
	include 'print_message.php';
}

mysql_close($conn);

} // login check
?>
