<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{

include '../../connect_db.php';
$period = array ("2048" => "9:00~10:00", "1024" => "10:00~11:00", "512" => "11:00~12:00", "256" => "12:00~13:00", "128" => "13:00~14:00", "64" => "14:00~15:00", "32" => "15:00~16:00", "16" => "16:00~17:00", "8" => "17:00~18:00", "4" => "18:00~19:00", "2" => "19:00~20:00", "1" => "20:00~21:00");

$name = @$_POST['name'];
$dept = @$_POST['dept'];
$location = @$_POST['location'];
$y = @$_POST['year'];
if( @$_POST['month'] < 10 && $_POST['month'] != "" )
	$m = "0" . @$_POST['month'];
else
	$m = @$_POST['month'];

if( @$_POST['day'] < 10 && $_POST['day'] != "" )
	$d = "0" . @$_POST['day'];
else
	$d = @$_POST['day'];

$time = @$_POST['time'];
$booked_date = $y . $m . $d . $time;
$o = @$_POST['order'];
$condition = false;

$sql = "Select * From booked";

if( $name != "" )
{
	$sql .= " Where name='$name'";
	$condition = true;
}

if( $dept != "" )
{
	if( $condition )
		$sql .= " AND dept='$dept'";
	else
	{
		$sql .= " Where dept='$dept'";
		$condition = true;
	}
}

if( $location != "" )
{
	if( $condition )
		$sql .= " AND location='$location'";
	else
	{
		$sql .= " Where location='$location'";
		$condition = true;
	}
}

if( $booked_date != "" )
{
	if( $condition )
		$sql .= " AND booked_date='$booked_date'";
	else
	{
		$sql .= " Where booked_date='$booked_date'";
		$condition = true;
	}
}

if( $o != "" )
{
	if( $condition )
		$sql .= " AND booked_order='$o'";
	else
	{
		$sql .= " Where booked_order='$o'";
		$condition = true;
	}
}

$sql .= " Order by booked_date DESC";

$result = mysql_query($sql, $conn) or die(mysql_error());
if( $row=mysql_fetch_array($result) )
{
	echo "<table width=\"700\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\" bgcolor=\"#996600\" align=center>";
	echo "<tr><td colspan=6 align=center><font color=white>Search Result</font></td></tr>";
	echo "<tr bgcolor=#FFEBC1>";
	echo "<td><font size=2 color=blue>姓名</font></td>";
	echo "<td><font size=2 color=blue>學號</font></td>";
	echo "<td><font size=2 color=blue>系級</font></td>";
	echo "<td><font size=2 color=blue>預約地點</font></td>";
	echo "<td><font size=2 color=blue>預約日期</font></td>";
	echo "<td><font size=2 color=blue>預約時段</font></td>";
	echo "<td><font size=2 color=blue>預約totur</font></td>";
	echo "<td><font size=2 color=blue>Email</font></td>";
	echo "<td><font size=2 color=blue>Phone</font></td>";
	echo "<td><font size=2 color=blue>刪除</font></td>";
	echo "</tr>";

	$today = date('Ymd');
	do
	{
		$this_d = substr($row['booked_date'], 0, 8);
		if( $this_d < $today ) $color = "gray"; else $color="green";
		$yy = substr($row['booked_date'], 0, 4);
		$mm = substr($row['booked_date'], 4, 2);
		$dd = substr($row['booked_date'], 6, 2);
		$tt = substr($row['booked_date'], 8);
		echo "<tr bgcolor=white>";
		echo "<td><font color=$color size=2>" . $row['name'] . "</font></td>";
		echo "<td><font color=$color size=2>" . $row['student_id'] . "</font></td>";
		echo "<td><font color=$color size=2>" . $row['dept'] . "</font></td>";
		echo "<td><font color=$color size=2>" . $row['location'] . "</font></td>";
		echo "<td><font color=$color size=2>" . $yy . "/" . $mm . "/" . $dd . "</font></td>";
		echo "<td><font color=$color size=2>" . (isset($period[$tt])?$period[$tt]:"");
		if( $row['booked_order'] == 1 )
			echo "(0~25)</font></td>";
		else
			echo "(30~55)</font></td>";

		echo "<td><font color=$color size=2>" . $row['tutor'] . "</font></td>";
		echo "<td><font color=$color size=2>" . $row['email'] . "</font></td>";
		echo "<td><font color=$color size=2>" . $row['phone'] . "</font></td>";
		echo "<td><font color=green size=2>[<a href=delete_booking3.php?id=" . $row['booked_date'] . "&location=" . $row['location'] . "&order=" . $row['booked_order'] . "&tutor=" . $row['tutor'] . "><font color=red>remove</font></a>]</font></td>";
		echo "</tr>";
	}while( $row=mysql_fetch_array($result) );
	echo "</table>";
	
}
else
{
	$title="查詢失敗";
	$mes = "資料庫中並無此預約！請確定輸入無誤。";
	$title_color="white"; $title_bgcolor="#990000"; $title_size=3; $border_color="#990000";
	$body_bgcolor="white"; $body_fcolor="red"; $body_fsize="2"; $width="300";
	$b_content="確定"; $b_link="delete_booking.php";
	include 'print_message.php';
}

} // login check
?>
