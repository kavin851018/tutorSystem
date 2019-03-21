<?php
session_start();
@$m = $_GET['m'];
@$d = $_GET['d'];
@$y = $_GET['y'];
@$_SESSION['book_m'] = $m;
@$_SESSION['book_d'] = $d;
@$_SESSION['book_y'] = $y;
include '../../connect_db.php';

// Caculate the leap year
if( ((date('Y') - 2000) % 4) )
	$month_day = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
else
	$month_day = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

$_SESSION['month_day'] = $month_day;

// The weekend array
$weekend = array("Mon" => 1, "Tue" => 2, "Wed" => 3, "Thu" => 4, "Fri" => 5, "Sat" => 6, "Sun" => 7);
$today = date('m') . '/' . date('d');

// Compute the limit date (limit_d is used for checking if the filed is available or not yet)
/*
$limit_days = 30;
$ly = date('Y'); $lm = date('n'); $ld = date('j');
$ld += $limit_days;
while( $ld > $month_day[$lm-1] )
{
	$ld -= $month_day[$lm-1];
	$lm++;
	if( $lm > 12 )
	{
		$ly++;
		$lm = 1;
	}
}
if( $lm < 10 ) $lm = "0" . $lm;
if( $ld < 10 ) $ld = "0" . $ld;
$_SESSION['limit_d'] = $ly . $lm . $ld;
*/
$_SESSION['limit_d'] = date("Ymd", strtotime("+ 2weeks", strtotime(date("Ymd"))));  // booking is allowed next 2 weeks before

// Read the holidays from database table 'holiday' (This is used for checking if today is holiday)
$sql = "Select * From holiday";
$result_holiday = mysql_query($sql, $conn);
$i = 0;
while( $row = mysql_fetch_array($result_holiday) )
{
	$_SESSION['from_date' . $i] = $row['from_date'];
	$_SESSION['to_date' . $i] = $row['to_date'];
	$i++;
}
$_SESSION['holiday_num'] = $i;

// Computer the overdue ($overdue is used for checking if it is overdue)
$month_day = $_SESSION['month_day'];
$overdueY = date('Y'); $overdueM = date('n'); $overdueD = date('j') + 1;
if( $overdueD > $month_day[$overdueM - 1] )
{
	$overdueD -= $month_day[$overdueM - 1];
	$overdueM++;
}
if( $overdueD < 10 ) $overdueD = "0" . $overdueD;
if( $overdueM > 12 )
{
	$overdueM = 1;
	$overdueY++;
}
if( $overdueM < 10 ) $overdueM = "0" . $overdueM;
$_SESSION['overdue'] = $overdueY . $overdueM . $overdueD;

if( $m != "" && $d != "" && $y != "")
{
	for( $i=1; $i<=5; $i++ )
	{
		if($m<10)
			$temp_m = '0' . $m;
		else
			$temp_m = $m;
			
		if($d<10)
			$temp_d = '0' . $d;
		else
			$temp_d = $d;

		$b_day[$i] = $temp_m . '/' . $temp_d;
		$b_year[$i] = $y;
		$d++;
		if( $d > $month_day[$m-1] )
		{
			$d = $d - $month_day[$m-1];
			$m++;
			if( $m == 13 )
			{
				$m = 1;
				$y++;
			}
		}
	}
}
else
{
	// Find date of Monday
	$w = $weekend[date('D')];

	$m = date('n');
	$d = date('j');
	$y = date('Y');

	if( $d < $w)
	{
		$w -= ($d + 1);
		$m--;
		if( $m == 0 )
		{
			$m = 12;
			$y--;
		}
		$d = $month_day[$m-1] - $w;
	}
	else
	{
		$d = $d - $w + 1;
	}

	for( $i=1; $i<=5; $i++ )
	{
		if($m<10)
			$temp_m = '0' . $m;
		else
			$temp_m = $m;

		if($d<10)
			$temp_d = '0' . $d;
		else
			$temp_d = $d;

		$b_day[$i] = $temp_m . '/' . $temp_d;
		$b_year[$i] = $y;
		$d++;
		if( $d > $month_day[$m-1] )
		{
			$d = $d - $month_day[$m-1];
			$m++;
			if( $m == 13 )
			{
				$m = 1;
				$y++;
			}
		}
	}
}

// Caculate the date of next monday
$d = $d + 2;
if( $d > $month_day[$m-1] )
{
	$d = $d - $month_day[$m-1];
	$m++;
	if( $m == 13 )
	{
		$m = 1;
		$y++;
	}
}
$next_month = $m;
$next_day = $d;
$next_year = $y;

// Caculate the date of previous monday
if( $d > 14 )
{
	$d = $d - 14;
}
else
{
	$d = 14 - $d;
	$m--;
	if ( $m == 0 )
	{
		$m = 12;
		$y--;
	}
	$d = $month_day[$m-1] - $d;
}
$pre_month = $m;
$pre_day = $d;
$pre_year = $y;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>Booking System</title>
<style type="text/css">
<!--
A:hover {LEFT: 1px; POSITION: relative; TOP: 1px;}
A{text-decoration:none}
.content {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:black}
.title {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:white}
.style{font-family:Arial, Helvetica, sans-serif;color:blue;font-size:13px;}
body {background-image: url();BACKGROUND-REPEAT:No-Repeat;}
.style5 {color: #990000;font-size:13px;}
.styleClass{font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#663300}
.styleTutor{font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:blue}
.styleBooked{font-family:Arial, Helvetica, sans-serif; font-size:9px; color:#9966CC}
.style8 {
	font-size: 24px;
	font-family: "標楷體";
}
-->
</style>

<script language="JavaScript" type="text/JavaScript">

function initial() {
/*
  <?php
    if( !isset($_SERVER['HTTP_REFERER']) || ereg("self_access",$_SERVER['HTTP_REFERER'])) {
    	echo "alert(\"因進行英語諮詢預約系統維護作業，故3/7~3/18之部分預約系統自動刪除，麻煩已預約同學重新上網預約，造成不便，尚祈見諒。\\n\\n自學園公告2011.03.06\");";
    }
  ?>
*/
}

</script>

</head>

<body bgproperties="fixed" onLoad="initial();">
<div align="right"><a href="login.htm" class="style">Manager</a></div>
      <div align="center" class="style">
        <table width="400" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td align="center"><span class="style8">外文系自學園 – 小老師預約系統 </span></td>
          </tr>
        </table>
        <p><img src="images/bookable.png" width="22" height="22" align="absmiddle">:Bookable <img src="images/overdue.png" width="22" height="22" align="absmiddle">:Overdue <img src="images/notyet.png" width="22" height="22" align="absmiddle">:Not yet <img src="images/holiday.png" width="22" height="22" align="absmiddle"> :Holiday  <img src="images/cancel.png" width="22" height="22" align="absmiddle">:Already booked        </p>
<?php echo @$_SESSION['message']; $_SESSION['message'] = ""; unset($_SESSION['message']);?></div>

      <table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="20" height="20" background="images/tableCorner/lefttop.png">&nbsp;</td>
          <td background="images/tableCorner/top.png">&nbsp;</td>
          <td width="20" height="20" background="images/tableCorner/righttop.png">&nbsp;</td>
        </tr>
        <tr>
          <td background="images/tableCorner/left.png">&nbsp;</td>
          <td>
<!--
<?php
echo "<div align=center class=content>";
if( isset($pre_month) && isset($pre_day) )
{
	echo "<a href=\"book.php?m=" . $pre_month . "&d=" . $pre_day . "&y=" . $pre_year . "\">&lt;Previous Week</a> || ";
	echo "<a href=book.php>This Week</a> || ";
}
echo "<a href=\"book.php?m=" . $next_month . "&d=" . $next_day . "&y=" . $next_year . "\">Next Week &gt;</a>";
echo "</div>";
?>

		  <table width="650" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#0099CC">
            <tr class="content">
              <td colspan="6"><div align="center" class="title">The schedule of <strong>DELL room (外文系3樓309室自學中心) </strong></div></td>
            </tr>
            <tr bgcolor="#E1FFF0" class="content">
              <td bgcolor="#E1FFF0"><div align="center" class="style5">Time</div></td>
              <td align="center" nowrap><strong>Monday <?php echo '<font color=blue>(' . $b_day[1] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Tuesday <?php echo '<font color=blue>(' . $b_day[2] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Wednesday <?php echo '<font color=blue>(' . $b_day[3] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Thursday <?php echo '<font color=blue>(' . $b_day[4] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Friday <?php echo '<font color=blue>(' . $b_day[5] . ')</font>';?></strong></td>
            </tr>
            <?php
// Select the schedule
$sql = "Select * From schedule";

$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 0;
while( $row = mysql_fetch_array($result) ) // Read each tutor's timetable
{
	$tutorName[$i] = $row['tutor_name'];
	$tutorClass[$i] = $row['class'];
	$tutorDay[1][$i] = $row['monday'];
	$tutorDay[2][$i] = $row['tuesday'];
	$tutorDay[3][$i] = $row['wednesday'];
	$tutorDay[4][$i] = $row['thursday'];
	$tutorDay[5][$i] = $row['friday'];
	$i++;
}

if($i)
{
	// Select the title
	$sql = "Select * From class_title Where location='DELL'";

	$result = mysql_query($sql, $conn) or die(mysql_error());
	$j = 0;
	while( $row = mysql_fetch_array($result) ) // Read the timetable of each class title.
	{
		$className[$j] = $row['title_name'];
		$classID[$j] = $row['id'];
		$classDay[1][$j] = $row['monday'];
		$classDay[2][$j] = $row['tuesday'];
		$classDay[3][$j] = $row['wednesday'];
		$classDay[4][$j] = $row['thursday'];
		$classDay[5][$j] = $row['friday'];
		$j++;
	}
}

//$timePeriod = array("9:00~10:00","10:00~11:00","11:00~12:00", "14:00~15:00","15:00~16:00", "16:00~17:00"); // Each time period
//$periodNumber = array(1024, 512, 256, 32, 16, 8);
$timePeriod = array("9:00~10:00","10:00~11:00","11:00~12:00", "12:00~13:00", "13:00~14:00", "14:00~15:00","15:00~16:00", "16:00~17:00", "17:00~18:00", "18:00~19:00", "19:00~20:00", "20:00~21:00"); // Each time period
$periodNumber = array(2048, 1024, 512, 256, 128, 64, 32, 16, 8, 4, 2, 1);

for ($i=0; $i<count($timePeriod); $i++) // each time {9:00 ~ }
{
	echo "<tr bgcolor=white class=content>";
	echo "<td>" . $timePeriod[$i] . "</td>";

	for ($j=1; $j<=5; $j++) // each day {Monday to Friday}
	{
		echo "<td " . td_bgcolor($b_day, $today, $j) . " align=center>";
		printField($j, $periodNumber[$i], "DELL", $tutorName, $tutorClass, $tutorDay[$j], $classID, $className, $classDay[$j], $b_year, $b_day, $conn);
		echo "</td>";
	}
	echo "</tr>";
//	if( $timePeriod[$i] == "11:00~12:00" || $timePeriod[$i] == "16:00~17:00" )
//	if( $timePeriod[$i] == "16:00~17:00" )
//		echo "<tr><td colspan=6 align=center><font color=white size=2>Break</font></td></tr>";
}
?>
          </table>

<?php
echo "<div align=center class=content>";
if( isset($pre_month) && isset($pre_day) )
{
	echo "<a href=\"book.php?m=" . $pre_month . "&d=" . $pre_day . "&y=" . $pre_year . "\">&lt;Previous Week</a> || ";
	echo "<a href=book.php>This Week</a> || ";
}
echo "<a href=\"book.php?m=" . $next_month . "&d=" . $next_day . "&y=" . $next_year . "\">Next Week &gt;</a>";
echo "</div>";
?>		  </td>
          <td background="images/tableCorner/right.png">&nbsp;</td>
        </tr>
        <tr>
          <td width="20" height="20" background="images/tableCorner/leftbottom.png">&nbsp;</td>
          <td background="images/tableCorner/bottom.png">&nbsp;</td>
          <td width="20" height="20" background="images/tableCorner/rightbottom.png">&nbsp;</td>
        </tr>
      </table>
-->
      <!-- Part of the Library's schedule -->
	  <!--
      <br>
      <br>
      <table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="20" height="20" background="images/tableCorner/lefttop.png">&nbsp;</td>
          <td background="images/tableCorner/top.png">&nbsp;</td>
          <td width="20" height="20" background="images/tableCorner/righttop.png">&nbsp;</td>
        </tr>
        <tr>
          <td background="images/tableCorner/left.png">&nbsp;</td>
          <td><table width="650" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#0099CC">
            <tr class="content">
              <td colspan="6"><div align="center" class="title">The schedule of <strong>Library(圖書館四樓語文諮詢區) </strong></div></td>
            </tr>
            <tr bgcolor="#E1FFF0" class="content">
              <td bgcolor="#E1FFF0"><div align="center" class="style5">Time</div></td>
              <td align="center" nowrap><strong>Monday <?php echo '<font color=blue>(' . $b_day[1] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Tuesday <?php echo '<font color=blue>(' . $b_day[2] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Wednesday <?php echo '<font color=blue>(' . $b_day[3] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Thursday <?php echo '<font color=blue>(' . $b_day[4] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Friday <?php echo '<font color=blue>(' . $b_day[5] . ')</font>';?></strong></td>
            </tr>
            <?php
// Select the schedule
$sql = "Select * From schedule_lib";

$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 0;
while( $row = mysql_fetch_array($result) ) // Read each tutor's timetable
{
	$tutorName[$i] = $row['tutor_name'];
	$tutorClass[$i] = $row['class'];
	$tutorDay[1][$i] = $row['monday'];
	$tutorDay[2][$i] = $row['tuesday'];
	$tutorDay[3][$i] = $row['wednesday'];
	$tutorDay[4][$i] = $row['thursday'];
	$tutorDay[5][$i] = $row['friday'];
	$i++;
}

if($i)
{
	// Select the title
	$sql = "Select * From class_title Where location='LIB'";

	$result = mysql_query($sql, $conn) or die(mysql_error());
	$j = 0;
	while( $row = mysql_fetch_array($result) ) // Read the timetable of each class title.
	{
		$className[$j] = $row['title_name'];
		$classID[$j] = $row['id'];
		$classDay[1][$j] = $row['monday'];
		$classDay[2][$j] = $row['tuesday'];
		$classDay[3][$j] = $row['wednesday'];
		$classDay[4][$j] = $row['thursday'];
		$classDay[5][$j] = $row['friday'];
		$j++;
	}
}
$timePeriod = array("9:00~10:00","10:00~11:00","11:00~12:00", "12:00~13:00", "13:00~14:00", "14:00~15:00","15:00~16:00", "16:00~17:00", "17:00~18:00" ,"18:00~19:00", "19:00~20:00", "20:00~21:00"); // Each time period
$periodNumber = array(2048, 1024, 512, 256, 128, 64, 32, 16, 8, 4, 2,1);

for ($i=0; $i<count($timePeriod); $i++) // each time {9:00 ~ 10:00 …}
{
	echo "<tr bgcolor=white class=content>";
	echo "<td>" . $timePeriod[$i] . "</td>";

	for ($j=1; $j<=5; $j++) // each day {Monday to Friday}
	{
		echo "<td " . td_bgcolor($b_day, $today, $j) . " align=center>";
		printField($j, $periodNumber[$i], "LIB", $tutorName, $tutorClass, $tutorDay[$j], $classID, $className, $classDay[$j], $b_year, $b_day, $conn);
		echo "</td>";
	}

	echo "</tr>";
//	if( $timePeriod[$i] == "11:00~12:00" || $timePeriod[$i] == "16:00~17:00" )
//	if( $timePeriod[$i] == "16:00~17:00" )
//		echo "<tr><td colspan=6 align=center><font color=white size=2>Break</font></td></tr>";
}
?>
          </table>            <?php
echo "<div align=center class=content>";
if( isset($pre_month) && isset($pre_day) )
{
	echo "<a href=\"book.php?m=" . $pre_month . "&d=" . $pre_day . "&y=" . $pre_year . "\">&lt;Previous Week</a> || ";
	echo "<a href=book.php>This Week</a> || ";
}
echo "<a href=\"book.php?m=" . $next_month . "&d=" . $next_day . "&y=" . $next_year . "\">Next Week &gt;</a>";
echo "</div>";
?>
          </td>
          <td background="images/tableCorner/right.png">&nbsp;</td>
        </tr>
        <tr>
          <td width="20" height="20" background="images/tableCorner/leftbottom.png">&nbsp;</td>
          <td background="images/tableCorner/bottom.png">&nbsp;</td>
          <td width="20" height="20" background="images/tableCorner/rightbottom.png">&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p>
-->


















          
      <br>
      <table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="20" height="20" background="images/tableCorner/lefttop.png">&nbsp;</td>
          <td background="images/tableCorner/top.png">&nbsp;</td>
          <td width="20" height="20" background="images/tableCorner/righttop.png">&nbsp;</td>
        </tr>
        <tr>
          <td background="images/tableCorner/left.png">&nbsp;</td>
          <td><table width="650" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#0099CC">
            <tr class="content">
              <td colspan="6"><div align="center" class="title">The schedule of <strong>dormitory(宿舍區)</strong></div></td>
            </tr>
            <tr bgcolor="#E1FFF0" class="content">
              <td bgcolor="#E1FFF0"><div align="center" class="style5">Time</div></td>
              <td align="center" nowrap><strong>Monday <?php echo '<font color=blue>(' . $b_day[1] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Tuesday <?php echo '<font color=blue>(' . $b_day[2] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Wednesday <?php echo '<font color=blue>(' . $b_day[3] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Thursday <?php echo '<font color=blue>(' . $b_day[4] . ')</font>';?></strong></td>
              <td align="center" nowrap><strong>Friday <?php echo '<font color=blue>(' . $b_day[5] . ')</font>';?></strong></td>
            </tr>
            <?php
// Select the schedule
$sql = "Select * From schedule_night";

$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 0;
while( $row = mysql_fetch_array($result) ) // Read each tutor's timetable
{
	$tutorName[$i] = $row['tutor_name'];
	$tutorClass[$i] = $row['class'];
	$tutorDay[1][$i] = $row['monday'];
	$tutorDay[2][$i] = $row['tuesday'];
	$tutorDay[3][$i] = $row['wednesday'];
	$tutorDay[4][$i] = $row['thursday'];
	$tutorDay[5][$i] = $row['friday'];
	$i++;
}

if($i)
{
	// Select the title
	$sql = "Select * From class_title Where location='NIGHT'";

	$result = mysql_query($sql, $conn) or die(mysql_error());
	$j = 0;
	while( $row = mysql_fetch_array($result) ) // Read the timetable of each class title.
	{
		$className[$j] = $row['title_name'];
		$classID[$j] = $row['id'];
		$classDay[1][$j] = $row['monday'];
		$classDay[2][$j] = $row['tuesday'];
		$classDay[3][$j] = $row['wednesday'];
		$classDay[4][$j] = $row['thursday'];
		$classDay[5][$j] = $row['friday'];
		$j++;
	}
}
//$timePeriod = array("9:00~10:00","10:00~11:00","11:00~12:00", "12:00~13:00", "13:00~14:00", "14:00~15:00","15:00~16:00", "16:00~17:00", "17:00~18:00",  "18:00~19:00", "19:00~20:00", "20:00~21:00"); // Each time period
//$periodNumber = array(2048, 1024, 512, 256, 128, 64, 32, 16, 8, 4, 2, 1);
$timePeriod = array("12:00~13:00", "13:00~14:00", "14:00~15:00","15:00~16:00", "16:00~17:00", "17:00~18:00",  "18:00~19:00", "19:00~20:00", "20:00~21:00"); // Each time period
$periodNumber = array(256, 128, 64, 32, 16, 8, 4, 2, 1);

for ($i=0; $i<count($timePeriod); $i++) // each time {9:00 ~ 10:00 …}
{
	echo "<tr bgcolor=white class=content>";
	echo "<td>" . $timePeriod[$i] . "</td>";

	for ($j=1; $j<=5; $j++) // each day {Monday to Friday}
	{
		echo "<td " . td_bgcolor($b_day, $today, $j) . " align=center>";
		printField($j, $periodNumber[$i], "NIGHT", $tutorName, $tutorClass, $tutorDay[$j], $classID, $className, $classDay[$j], $b_year, $b_day, $conn);
		echo "</td>";
	}

	echo "</tr>";
//	if( $timePeriod[$i] == "11:00~12:00" || $timePeriod[$i] == "16:00~17:00" )
//	if( $timePeriod[$i] == "16:00~17:00" )
//		echo "<tr><td colspan=6 align=center><font color=white size=2>Break</font></td></tr>";
}
?>
          </table>            <?php
echo "<div align=center class=content>";
if( isset($pre_month) && isset($pre_day) )
{
	echo "<a href=\"book.php?m=" . $pre_month . "&d=" . $pre_day . "&y=" . $pre_year . "\">&lt;Previous Week</a> || ";
	echo "<a href=book.php>This Week</a> || ";
}
echo "<a href=\"book.php?m=" . $next_month . "&d=" . $next_day . "&y=" . $next_year . "\">Next Week &gt;</a>";
echo "</div>";
?>
          </td>
          <td background="images/tableCorner/right.png">&nbsp;</td>
        </tr>
        <tr>
          <td width="20" height="20" background="images/tableCorner/leftbottom.png">&nbsp;</td>
          <td background="images/tableCorner/bottom.png">&nbsp;</td>
          <td width="20" height="20" background="images/tableCorner/rightbottom.png">&nbsp;</td>
        </tr>
      </table>
     <p align="center" class="content">若你在使用Booking System時有碰到任何困難，請通知
      ???@???.??? Thanks.<br>
      若你無法自行取消預約，請與自學園連絡: 07-5252000 ext.3211/3214 或 onlinelearning@mail.nsysu.edu.tw</p>
</body>
</html>
<?php
mysql_close($conn);

// Display the class, tutor, and booked data corresponding to the field. (day cross time)
function printField($weekend, $periodNumber, $location, $tutorName, $tutorClass, &$tutorDay, $classID, $className, &$classDay, $b_year, $b_day, $conn)
{
	$this_day = $b_year[$weekend] . str_replace("/" , "", $b_day[$weekend]);
	
	// Find out the classes which were associated to this filed
	$classI = 0;
	$tutorI = 0;

	for( $i=0; $i<count($classDay); $i++)
	{
		if( $classDay[$i] >= $periodNumber )
		{
			$classDay[$i] -= $periodNumber;
			$class[$classI] = $i;
			$classI++;
		}
	}

	// Find out the tutors who were associated to this filed.
	for( $i=0; $i<count($tutorDay); $i++ )
	{
		if( $tutorDay[$i] >= $periodNumber )
		{
			$tutorDay[$i] -= $periodNumber;
			$tutor[$tutorI] = $i;
			$tutorI++;
		}
	}

	// Display all found classes and the tutors who is associated to this class
	for( $i=0; $i<$classI; $i++ )
	{
		for( $j=0; $j<$tutorI; $j++ )
		{
			// Check if the tutor is associated to this class
			// If ture, Display this class and tutor
			if( $classID[$class[$i]] == $tutorClass[$tutor[$j]] )
			{
				echo "<table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">";// bgcolor=\"#6699CC\">";
				echo "<tr bgcolor=\"#B9CFE8\">";
				echo "<td colspan=\"2\" align=center nowrap>";
				echo "<font class=styleClass>" . $className[$class[$i]] . "</font><font class=styleTutor>(" . $tutorName[$tutor[$j]] . ")</font>";
				echo "</td></tr><tr bgcolor=\"#E6EEF7\">";
				printBookField($b_year[$weekend], $b_day[$weekend], $periodNumber, $tutorName[$tutor[$j]], $location, $conn);
				echo "</tr></table>";
			}
		}
		if( $i !=($classI - 1) ) echo "<br>";
	}
}

// This function is used to display the booking state (booking link, booked person, or holiday).
function printBookField($year, $day, $periodNumber, $tutor, $location, $conn)
{
	$d = $year . str_replace("/" , "", $day) . $periodNumber;
	$this_d = $year . str_replace("/" , "", $day);

	// Check if this Field is holiday
	$isHoliday = 0;
	for( $i=0; $i<$_SESSION['holiday_num']; $i++ )
	{
		// During the holiday setting
		if( ($this_d >= $_SESSION['from_date' . $i]) && ($this_d <= $_SESSION['to_date' . $i]) )
		{
			$isHoliday = 1;
			break;
		}
	}

	// Display two time slots. (0~25, 30~55)
	// Removing two time slots on 16 Feb 2016 by Gavin Hong.
	//$timeSlot[0] = "0~25"; $timeSlot[1] = "30~55";
	//for ($i=0; $i<=1; $i++ ) // Booking order
	//{
		$bookedOrder = $i + 1;
		echo "<td align=center nowrap>";
		echo "<font size=2 color=gray>" . $timeSlot[$i] . "</font><br>";
		if( $isHoliday ) // Holiday
			echo "<img src=images/holiday.png border=0 alt=\"Holiday\">";
		elseif( $this_d > $_SESSION['limit_d'] ) // Notyet
			echo "<img src=images/notyet.png border=0 alt=\"Not Yet!\">";
		else // Bookable, Overdue, or Already Booked
		{
			$sql = "Select * From booked Where location='$location' AND booked_date='$d' AND tutor='$tutor' AND booked_order=$bookedOrder";
			$result = mysql_query($sql, $conn);
			$n = mysql_num_rows($result);

			if( $n == 0 ) // Bookable or Overdue
			{
				$dothing=1;
				if($this_d < $_SESSION['overdue']) $dothing=0;
				else if($this_d == $_SESSION['overdue']){
					if( date("H")>=12 ) $dothing=0;
				}

				if( $dothing==0 ) // Overdue      source: $this_d < $_SESSION['overdue']
					echo "<img src=images/overdue.png border=0 alt=\"Overdue\">";
				else // Bookable
				{
					echo "<a href=make_book.php?d=" . $d . "&location=" . $location . "&order=" . ($i+1) . "&tutor=" . "$tutor title=\"Bookable\">";
					echo "<img src=images/bookable.png border=0>";
					echo "</a>";
				}
			}
			else // Already Booked
			{
				$row = mysql_fetch_array($result);
				//echo "<font class=styleBooked>ID:" . $row['student_id'] . "<br>" . "Name:" . $row['name'] . "</font>";
				echo "<font class=styleBooked>ID:" . $row['student_id'] . "</font>";
				
				$dothing=1;
				if($this_d < $_SESSION['overdue']) $dothing=0;
				else if($this_d == $_SESSION['overdue']){
					if( date("H")>=12 ) $dothing=0;
				}
				
				if($dothing==1){
					// Print the 'cancel' button.
					$canceling_day = substr($row['booked_date'], 0, 8);
					if( $canceling_day >= $_SESSION['overdue'] )
						echo "<br><a href=cancel_booking.php?d=" . $row['booked_date'] . "&location=" . $row['location'] . "&order=" .$row['booked_order'] . "&tutor=" . $row['tutor'] . " title=\"Cancel this booking\"><img src=images/cancel.png border=0></a>";
				}
				else{
					echo "<img src=images/overdue.png border=0 alt=\"Overdue\">";
				}
				
			}
		}
		echo "</td>";
	//}
}

function td_bgcolor($b_day, $today, $i)
{
	if($b_day[$i] != $today)
		return " bgcolor=white";
	else
		return " bgcolor=#FFDDDD";
}
?>