<?php
$target = "login.htm";
include 'check_login.php';
if( $valid ) // Valid.
{
// Initial the session data;
$_SESSION['booked_date'] = ""; unset($_SESSION['booked_date']);
$_SESSION['location'] = ""; unset($_SESSION['location']);
$_SESSION['booked_order'] = ""; unset($_SESSION['booked_order']);

@$m = $_GET['m'];
@$d = $_GET['d'];
@$y = $_GET['y'];

// Record the previous page.
if( isset($_GET['m']) && isset($_GET['d']) && isset($_GET['y']) )
	$_SESSION['from'] = "manager_booking.php?m=$m&d=$d&y=$y";
else
	$_SESSION['from'] = "manager_booking.php";

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

// Read the limit days
$limit_file = fopen("limit.txt", "r");
$limit_days = fgets($limit_file);

// Compute the limit date
$ly = date('Y'); $lm = date('m'); $ld = date('d');
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

// Read the holidays from database table 'holiday'
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
A:hover {LEFT: 1px; POSITION: relative; TOP: 1px; text-decoration:none}
A:{text-decoration:none}
.content {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:black}
.title {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:white}
.style{font-family:Arial, Helvetica, sans-serif;color:blue;font-size:13px;}
body {
	background-image: url();
	BACKGROUND-REPEAT:No-Repeat;
}
.style3 {color: #330000;}
.style5 {color: #990000;font-size:13px;}
.style6 {color: #006600;font-weight: bold;}
-->
</style>
</head>

<body bgproperties="fixed">
      <p align="center" class="style"><img src="images/bookable.png" width="22" height="22" align="absmiddle">:bookable <img src="images/overdue.png" width="22" height="22" align="absmiddle">:overdue <img src="images/notyet.png" width="22" height="22" align="absmiddle">:not yet <img src="images/holiday.png" width="22" height="22" align="absmiddle"> :Holiday  <img src="images/cancel.png" width="22" height="22" align="absmiddle">:Delete booking<br>
<?php echo @$_SESSION['message']; $_SESSION['message'] = ""; unset($_SESSION['message']);?><br> 
[<a href="show_management.php">Back to the manager interface</a>]
</p>
      <table width="650" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006633">
          <tr bgcolor="#006633" class="content">
            <td colspan="6"><div align="center" class="title">The schedule of <strong>DELL room (外文系3樓309室自學中心) </strong></div></td>
          </tr>
          <tr bgcolor="#E1FFF0" class="content">
            <td bgcolor="#E1FFF0"><div align="center" class="style5">Time</div></td>
            <td><div align="center"><strong>Monday<?php echo '<font color=blue>(' . $b_day[1] . ')</font>';?></strong></div></td>
            <td><div align="center"><strong>Tuesday<?php echo '<font color=blue>(' . $b_day[2] . ')</font>';?></strong></div></td>
            <td><div align="center"><strong>Wednesday<?php echo '<font color=blue>(' . $b_day[3] . ')</font>';?></strong></div></td>
            <td><div align="center"><strong>Thursday<?php echo '<font color=blue>(' . $b_day[4] . ')</font>';?></strong></div></td>
            <td><div align="center"><strong>Friday<?php echo '<font color=blue>(' . $b_day[5] . ')</font>';?></strong></div></td>
        </tr>
<?php
// Select the schedule
$sql = "Select * From schedule";

$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 0;
while( $row = mysql_fetch_array($result) )
{
	$tutor_name[$i] = $row['tutor_name'];
	$monday[$i] = $row['monday'];
	$tuesday[$i] = $row['tuesday'];
	$wednesday[$i] = $row['wednesday'];
	$thursday[$i] = $row['thursday'];
	$friday[$i] = $row['friday'];
	$i++;
}

if($i)
{
	// Select the title
	$sql = "Select * From class_title Where location='DELL'";

	$result = mysql_query($sql, $conn) or die(mysql_error());
	$j = 0;
	while( $row = mysql_fetch_array($result) )
	{
		$title_name[$j] = $row['title_name'];
		$t_monday[$j] = $row['monday'];
		$t_tuesday[$j] = $row['tuesday'];
		$t_wednesday[$j] = $row['wednesday'];
		$t_thursday[$j] = $row['thursday'];
		$t_friday[$j] = $row['friday'];
		$j++;
	}
?>
          <tr bgcolor="white" class="content">
            <td bgcolor="#E1FFF0"><div align="center">9:00~10:00</div></td>
	    <td<?php td_bgcolor($b_day, $today,1);?> align=center><?php if($j){ print_title(1024, $t_monday, $title_name, $j); print_tutor(1024, $monday, $tutor_name, $i, $b_year, $b_day, 1, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 2);?> align=center><?php if($j){ print_title(1024, $t_tuesday, $title_name, $j); print_tutor(1024, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 3);?> align=center><?php if($j){ print_title(1024, $t_wednesday, $title_name, $j); print_tutor(1024, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 4);?> align=center><?php if($j){ print_title(1024, $t_thursday, $title_name, $j); print_tutor(1024, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 5);?> align=center><?php if($j){ print_title(1024, $t_friday, $title_name, $j); print_tutor(1024, $friday, $tutor_name, $i, $b_year, $b_day, 5, "DELL", $conn);}?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#E1FFF0"><div align="center">10:00~11:00</div></td>
            <td<?php td_bgcolor($b_day, $today, 1);?> align=center><?php if($j){ print_title(512, $t_monday, $title_name, $j);print_tutor(512, $monday, $tutor_name, $i, $b_year, $b_day, 1, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 2);?> align=center><?php if($j){ print_title(512, $t_tuesday, $title_name, $j);print_tutor(512, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 3);?> align=center><?php if($j){ print_title(512, $t_wednesday, $title_name, $j);print_tutor(512, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 4);?> align=center><?php if($j){ print_title(512, $t_thursday, $title_name, $j);print_tutor(512, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 5);?> align=center><?php if($j){ print_title(512, $t_friday, $title_name, $j);print_tutor(512, $friday, $tutor_name, $i, $b_year, $b_day, 5, "DELL", $conn);}?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#E1FFF0"><div align="center">11:00~12:00</div></td>
            <td<?php td_bgcolor($b_day, $today, 1);?> align=center><?php if($j){ print_title(256, $t_monday, $title_name, $j);print_tutor(256, $monday, $tutor_name, $i, $b_year, $b_day, 1, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 2);?> align=center><?php if($j){ print_title(256, $t_tuesday, $title_name, $j);print_tutor(256, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 3);?> align=center><?php if($j){ print_title(256, $t_wednesday, $title_name, $j);print_tutor(256, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 4);?> align=center><?php if($j){ print_title(256, $t_thursday, $title_name, $j);print_tutor(256, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 5);?> align=center><?php if($j){ print_title(256, $t_friday, $title_name, $j);print_tutor(256, $friday, $tutor_name, $i, $b_year, $b_day, 5, "DELL", $conn);}?></td>
          </tr>
          
  <tr bgcolor="#CCCCFF" class="content"> 
    <td colspan=6 align=center><b>noon</b></td>
        </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#E1FFF0"><div align="center">14:00~15:00</div></td>
            <td<?php td_bgcolor($b_day, $today, 1);?> align=center><?php if($j){ print_title(32, $t_monday, $title_name, $j);print_tutor(32, $monday, $tutor_name, $i, $b_year, $b_day, 1, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 2);?> align=center><?php if($j){ print_title(32, $t_tuesday, $title_name, $j);print_tutor(32, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 3);?> align=center><?php if($j){ print_title(32, $t_wednesday, $title_name, $j);print_tutor(32, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 4);?> align=center><?php if($j){ print_title(32, $t_thursday, $title_name, $j);print_tutor(32, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 5);?> align=center><?php if($j){ print_title(32, $t_friday, $title_name, $j);print_tutor(32, $friday, $tutor_name, $i, $b_year, $b_day, 5, "DELL", $conn);}?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#E1FFF0"><div align="center">15:00~16:00</div></td>
            <td<?php td_bgcolor($b_day, $today, 1);?> align=center><?php if($j){ print_title(16, $t_monday, $title_name, $j);print_tutor(16, $monday, $tutor_name, $i, $b_year, $b_day, 1, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 2);?> align=center><?php if($j){ print_title(16, $t_tuesday, $title_name, $j);print_tutor(16, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 3);?> align=center><?php if($j){ print_title(16, $t_wednesday, $title_name, $j);print_tutor(16, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 4);?> align=center><?php if($j){ print_title(16, $t_thursday, $title_name, $j);print_tutor(16, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 5);?> align=center><?php if($j){ print_title(16, $t_friday, $title_name, $j);print_tutor(16, $friday, $tutor_name, $i, $b_year, $b_day, 5, "DELL", $conn);}?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#E1FFF0"><div align="center">16:00~17:00</div></td>
            <td<?php td_bgcolor($b_day, $today, 1);?> align=center><?php if($j){ print_title(8, $t_monday, $title_name, $j);print_tutor(8, $monday, $tutor_name, $i, $b_year, $b_day, 1, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 2);?> align=center><?php if($j){ print_title(8, $t_tuesday, $title_name, $j);print_tutor(8, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 3);?> align=center><?php if($j){ print_title(8, $t_wednesday, $title_name, $j);print_tutor(8, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 4);?> align=center><?php if($j){ print_title(8, $t_thursday, $title_name, $j);print_tutor(8, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "DELL", $conn);}?></td>
            <td<?php td_bgcolor($b_day, $today, 5);?> align=center><?php if($j){ print_title(8, $t_friday, $title_name, $j);print_tutor(8, $friday, $tutor_name, $i, $b_year, $b_day, 5, "DELL", $conn);}?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td colspan="6" align="center">
<?php
echo "<a href=\"manager_booking.php?m=" . $pre_month . "&d=" . $pre_day . "&y=" . $pre_year . "\">&lt;Previous Week</a> || ";
echo "<a href=manager_booking.php>This Week</a> || ";
echo "<a href=\"manager_booking.php?m=" . $next_month . "&d=" . $next_day . "&y=" . $next_year . "\">Next Week &gt;</a>";
?>
			</td>
          </tr>
</table>

<?php } ?>

      <p>&nbsp;</p>
      
<table width="650" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666600">
  <tr class="content"> 
    <td colspan="6"><div align="center" class="title">The schedule of<strong> 
        Library (圖書館4樓自學中心) </strong></div></td>
  </tr>
  <tr bgcolor="#FFFFBF" class="content"> 
    <td><div align="center" class="style5">Time</div></td>
    <td><div align="center"><strong>Monday<?php echo '<font color=blue>(' . $b_day[1] . ')</font>';?></strong></div></td>
    <td><div align="center"><strong>Tuesday<?php echo '<font color=blue>(' . $b_day[2] . ')</font>';?></strong></div></td>
    <td><div align="center"><strong>Wednesday<?php echo '<font color=blue>(' . $b_day[3] . ')</font>';?></strong></div></td>
    <td><div align="center"><strong>Thursday<?php echo '<font color=blue>(' . $b_day[4] . ')</font>';?></strong></div></td>
    <td><div align="center"><strong>Friday<?php echo '<font color=blue>(' . $b_day[5] . ')</font>';?></strong></div></td>
  </tr>
  <?php
// Select the schedule
$sql = "Select * From schedule_lib";

$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 0;
while( $row = mysql_fetch_array($result) )
{
	$tutor_name[$i] = $row['tutor_name'];
	$monday[$i] = $row['monday'];
	$tuesday[$i] = $row['tuesday'];
	$wednesday[$i] = $row['wednesday'];
	$thursday[$i] = $row['thursday'];
	$friday[$i] = $row['friday'];
	$i++;
}

if($i)
{
	// Select the title
	$sql = "Select * From class_title Where location='LIB'";

	$result = mysql_query($sql, $conn) or die(mysql_error());
	$j = 0;
	while( $row = mysql_fetch_array($result) )
	{
		$title_name[$j] = $row['title_name'];
		$t_monday[$j] = $row['monday'];
		$t_tuesday[$j] = $row['tuesday'];
		$t_wednesday[$j] = $row['wednesday'];
		$t_thursday[$j] = $row['thursday'];
		$t_friday[$j] = $row['friday'];
		$j++;
	}
?>
  <tr bgcolor="white" class="content"> 
    <td bgcolor="#FFFFBF"><div align="center" class="style3">9:00~10:00</div></td>
    <td<?php td_bgcolor($b_day, $today, 1);?> align=center> 
      <?php if($j){ print_title(1024, $t_monday, $title_name, $j); print_tutor(1024, $monday, $tutor_name, $i, $b_year, $b_day, 1, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 2);?> align=center> 
      <?php if($j){ print_title(1024, $t_tuesday, $title_name, $j); print_tutor(1024, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 3);?> align=center> 
      <?php if($j){ print_title(1024, $t_wednesday, $title_name, $j); print_tutor(1024, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 4);?> align=center> 
      <?php if($j){ print_title(1024, $t_thursday, $title_name, $j); print_tutor(1024, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 5);?> align=center> 
      <?php if($j){ print_title(1024, $t_friday, $title_name, $j); print_tutor(1024, $friday, $tutor_name, $i, $b_year, $b_day, 5, "LIB", $conn);}?>
    </td>
  </tr>
  <tr bgcolor="white" class="content"> 
    <td bgcolor="#FFFFBF"><div align="center" class="style3">10:00~11:00</div></td>
    <td<?php td_bgcolor($b_day, $today, 1);?> align=center> 
      <?php if($j){ print_title(512, $t_monday, $title_name, $j);print_tutor(512, $monday, $tutor_name, $i, $b_year, $b_day, 1, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 2);?> align=center> 
      <?php if($j){ print_title(512, $t_tuesday, $title_name, $j);print_tutor(512, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 3);?> align=center> 
      <?php if($j){ print_title(512, $t_wednesday, $title_name, $j);print_tutor(512, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 4);?> align=center> 
      <?php if($j){ print_title(512, $t_thursday, $title_name, $j);print_tutor(512, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 5);?> align=center> 
      <?php if($j){ print_title(512, $t_friday, $title_name, $j);print_tutor(512, $friday, $tutor_name, $i, $b_year, $b_day, 5, "LIB", $conn);}?>
    </td>
  </tr>
  <tr bgcolor="white" class="content"> 
    <td bgcolor="#FFFFBF"><div align="center" class="style3">11:00~12:00</div></td>
    <td<?php td_bgcolor($b_day, $today, 1);?> align=center> 
      <?php if($j){ print_title(256, $t_monday, $title_name, $j);print_tutor(256, $monday, $tutor_name, $i, $b_year, $b_day, 1, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 2);?> align=center> 
      <?php if($j){ print_title(256, $t_tuesday, $title_name, $j);print_tutor(256, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 3);?> align=center> 
      <?php if($j){ print_title(256, $t_wednesday, $title_name, $j);print_tutor(256, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 4);?> align=center> 
      <?php if($j){ print_title(256, $t_thursday, $title_name, $j);print_tutor(256, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 5);?> align=center> 
      <?php if($j){ print_title(256, $t_friday, $title_name, $j);print_tutor(256, $friday, $tutor_name, $i, $b_year, $b_day, 5, "LIB", $conn);}?>
    </td>
  </tr>
  <tr bgcolor="#CCCCFF" class="content"> 
    <td colspan=6 align=center><b>noon</b></td>
  </tr>
  <tr bgcolor="white" class="content"> 
    <td bgcolor="#FFFFBF"><div align="center" class="style3">14:00~15:00</div></td>
    <td<?php td_bgcolor($b_day, $today, 1);?> align=center> 
      <?php if($j){ print_title(32, $t_monday, $title_name, $j);print_tutor(32, $monday, $tutor_name, $i, $b_year, $b_day, 1, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 2);?> align=center> 
      <?php if($j){ print_title(32, $t_tuesday, $title_name, $j);print_tutor(32, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 3);?> align=center> 
      <?php if($j){ print_title(32, $t_wednesday, $title_name, $j);print_tutor(32, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 4);?> align=center> 
      <?php if($j){ print_title(32, $t_thursday, $title_name, $j);print_tutor(32, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 5);?> align=center> 
      <?php if($j){ print_title(32, $t_friday, $title_name, $j);print_tutor(32, $friday, $tutor_name, $i, $b_year, $b_day, 5, "LIB", $conn);}?>
    </td>
  </tr>
  <tr bgcolor="white" class="content"> 
    <td bgcolor="#FFFFBF"><div align="center" class="style3">15:00~16:00</div></td>
    <td<?php td_bgcolor($b_day, $today, 1);?> align=center> 
      <?php if($j){ print_title(16, $t_monday, $title_name, $j);print_tutor(16, $monday, $tutor_name, $i, $b_year, $b_day, 1, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 2);?> align=center> 
      <?php if($j){ print_title(16, $t_tuesday, $title_name, $j);print_tutor(16, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 3);?> align=center> 
      <?php if($j){ print_title(16, $t_wednesday, $title_name, $j);print_tutor(16, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 4);?> align=center> 
      <?php if($j){ print_title(16, $t_thursday, $title_name, $j);print_tutor(16, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 5);?> align=center> 
      <?php if($j){ print_title(16, $t_friday, $title_name, $j);print_tutor(16, $friday, $tutor_name, $i, $b_year, $b_day, 5, "LIB", $conn);}?>
    </td>
  </tr>
  <tr bgcolor="white" class="content"> 
    <td bgcolor="#FFFFBF"><div align="center" class="style3">16:00~17:00</div></td>
    <td<?php td_bgcolor($b_day, $today, 1);?> align=center> 
      <?php if($j){ print_title(8, $t_monday, $title_name, $j);print_tutor(8, $monday, $tutor_name, $i, $b_year, $b_day, 1, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 2);?> align=center> 
      <?php if($j){ print_title(8, $t_tuesday, $title_name, $j);print_tutor(8, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 3);?> align=center> 
      <?php if($j){ print_title(8, $t_wednesday, $title_name, $j);print_tutor(8, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 4);?> align=center> 
      <?php if($j){ print_title(8, $t_thursday, $title_name, $j);print_tutor(8, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 5);?> align=center> 
      <?php if($j){ print_title(8, $t_friday, $title_name, $j);print_tutor(8, $friday, $tutor_name, $i, $b_year, $b_day, 5, "LIB", $conn);}?>
    </td>
  </tr>
  <tr bgcolor="#CCCCFF" class="content"> 
    <td colspan="6" align="center"><strong>break</strong></td>
  </tr>
  <tr bgcolor="white" class="content"> 
    <td bgcolor="#FFFFBF"><div align="center" class="style3">19:00~20:00</div></td>
    <td<?php td_bgcolor($b_day, $today, 1);?> align=center> 
      <?php if($j){ print_title(4, $t_monday, $title_name, $j);print_tutor(4, $monday, $tutor_name, $i, $b_year, $b_day, 1, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 2);?> align=center> 
      <?php if($j){ print_title(4, $t_tuesday, $title_name, $j);print_tutor(4, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 3);?> align=center> 
      <?php if($j){ print_title(4, $t_wednesday, $title_name, $j);print_tutor(4, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 4);?> align=center> 
      <?php if($j){ print_title(4, $t_thursday, $title_name, $j);print_tutor(4, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 5);?> align=center> 
      <?php if($j){ print_title(4, $t_friday, $title_name, $j);print_tutor(4, $friday, $tutor_name, $i, $b_year, $b_day, 5, "LIB", $conn);}?>
    </td>
  </tr>
  <tr bgcolor="white" class="content"> 
    <td bgcolor="#FFFFBF"><div align="center" class="style3">20:00~21:00</div></td>
    <td<?php td_bgcolor($b_day, $today, 1);?> align=center> 
      <?php if($j){ print_title(2, $t_monday, $title_name, $j);print_tutor(2, $monday, $tutor_name, $i, $b_year, $b_day, 1, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 2);?> align=center> 
      <?php if($j){ print_title(2, $t_tuesday, $title_name, $j);print_tutor(2, $tuesday, $tutor_name, $i, $b_year, $b_day, 2, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 3);?> align=center> 
      <?php if($j){ print_title(2, $t_wednesday, $title_name, $j);print_tutor(2, $wednesday, $tutor_name, $i, $b_year, $b_day, 3, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 4);?> align=center> 
      <?php if($j){ print_title(2, $t_thursday, $title_name, $j);print_tutor(2, $thursday, $tutor_name, $i, $b_year, $b_day, 4, "LIB", $conn);}?>
    </td>
    <td<?php td_bgcolor($b_day, $today, 5);?> align=center> 
      <?php if($j){ print_title(2, $t_friday, $title_name, $j);print_tutor(2, $friday, $tutor_name, $i, $b_year, $b_day, 5, "LIB", $conn);}?>
    </td>
  </tr>
  <tr bgcolor="white" class="content"> 
    <td colspan="6" align="center"> 

<?php
echo "<a href=\"manager_booking.php?m=" . $pre_month . "&d=" . $pre_day . "&y=" . $pre_year . "\">&lt;Previous Week</a> || ";
echo "<a href=manager_booking.php>This Week</a> || ";
echo "<a href=\"manager_booking.php?m=" . $next_month . "&d=" . $next_day . "&y=" . $next_year . "\">Next Week &gt;</a>";
?>

    </td>
  </tr>
</table>
	    
      <p>&nbsp;</p>
      <p align="right"><a href="login.htm" class="style">Manager</a></p>
      <p>&nbsp;</p>
</body>
</html>
<?php
}
mysql_close($conn);

} // Valid.

// This function is used to print the tutor's name. It has four variables.
// $index indicates that what the exponent is now.
// $day indicates that what day is now.
// $name indicates that tutors' name.
// $num indicats the number of all tutors.
function print_tutor($index, &$day, $name, $num, $b_year, $b_day, $weekend, $location, $conn)
{
	$color = array('blue', 'green', 'red', 'orange', 'purple');

	for( $i=0; $i<$num; $i++ )
	{
		$j = $i % 5;
		if( $day[$i] >= $index )
		{
			echo "<font color=" . $color[$j] . " size=2>(" . $name[$i] . ")</font><br>";
			echo "</td></tr>";	// draw table
			
			p_link($b_year, $b_day, $weekend, $index, $location, $conn);	// call the printing links function
			$day[$i] -= $index;
		}
	}
}

function print_title($index, &$day, $name, $num)
{
	for( $i=0; $i<$num; $i++ )
	{
		if( $day[$i] >= $index )
		{
			// draw table
			echo "<table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#6699CC\">";
			echo "<tr bgcolor=\"#D6E3F1\">";
			echo "<td colspan=\"2\" align=center nowrap>";
			
			// print class title
			echo "<font color=#999933 size=2>" . $name[$i] . "</font>";
			$day[$i] -= $index;
		}
	}
}

function p_link($y, $day, $weekend , $index, $location, $conn)
{
	$d = $y[$weekend] . str_replace("/" , "", $day[$weekend]) . $index;
	$this_d = $y[$weekend] . str_replace("/" , "", $day[$weekend]);

	// Overdue
	$month_day = $_SESSION['month_day'];
	$overdueY = date('Y'); $overdueM = date('n'); $overdueD = date('j') + 2;
	if( $overdueD > $month_day[$overdueM] )
	{
		$overdueD -= $month_day[$overdueM];
		$overdueM++;
	}
	if( $overdueD < 10 ) $overdueD = "0" . $overdueD;
	if( $overdueM > 12 )
	{
		$overdueM = 1;
		$overdueY++;
	}
	if( $overdueM < 10 ) $overdueM = "0" . $overdueM;
	$overdue = $overdueY . $overdueM . $overdueD;
	
	// Check if the period of the booked date is full.
	$sql = "Select * From booked Where location='$location' AND booked_date='$d' ORDER BY booked_order";
	$result = mysql_query($sql, $conn);
	$n = mysql_num_rows($result);
	
	echo "<tr bgcolor=\"#D6E3F1\">";	// draw table

	$printed = 1;
	for( $i=0; $i<2; $i++ )
	{
		if( $i == 0)
			echo "<td align=center nowrap><font size=2 color=gray>0~25</font><br>";	//draw table
		else
			echo "<td align=center nowrap><font size=2 color=gray>30~55</font><br>";
		
		if($printed)
			$row = mysql_fetch_array($result);

		// Print booked person or other options.
		if( $row['booked_order'] == ($i+1) )	// print booked person
		{
			echo "<font size=1 color=#9966CC>Name:<U>";
			echo $row['name'] . "</U><br>";
			echo "Dept:<U>" . $row['dept'] . "</U><br>";
			$printed = 1;
			

			// Print the 'Attendence' button.
			if( $row['attendance'] == 0 )
				echo "<a href=attendance.php?d=" . $row['booked_date'] . "&location=" . $row['location'] . "&order=" . $row['booked_order'] . "><img src=images/unattended.png border=0 alt=\"Unattended!\"></a>";
			else
				echo "<a href=attendance.php?d=" . $row['booked_date'] . "&location=" . $row['location'] . "&order=" . $row['booked_order'] . "><img src=images/attended.png border=0 alt=\"Unattended!\"></a>";

			// Print the 'Delete' button.
			echo "<a href=delete_booking_m.php?d=" . $row['booked_date'] . "&location=" . $row['location'] . "&order=" . $row['booked_order'] . "><img src=images/cancel.png border=0 alt=\"Delete this booking!\"></a>";
		}
		else	// print 'bookable' or 'holiday' or 'Not yet'
		{
			// Read holiday variables
			$n = $_SESSION['holiday_num'];
			$isholiday = 0;
			$printed = 0;	// Means there may some data hasn't been printed.
			for( $j=0; $j<$n; $j++ )
			{
				// During the holiday setting
				if( ($this_d >= $_SESSION['from_date' . $j]) && ($this_d <= $_SESSION['to_date' . $j]) )
				{
					$isholiday = 1;
					$j = $n;
				}
			}

			if( $isholiday )	// The day is contained in the holiday setting
				echo "<img src=images/holiday.png border=0 alt=\"Holiday\">";
			else
			{
				if( $this_d >= $overdue)	// The day is not overdue
				{
					// Decide that if the day over limit days
					if( $this_d <= $_SESSION['limit_d'] )
					{
						echo "<a href=make_book.php?d=" . $d . "&location=" . $location . "&order=" . ($i+1) . ">";
						echo "<img src=images/bookable.png border=0 alt=\"Bookable\">";
						echo "</a>";
					}
					else
						echo "<img src=images/notyet.png border=0 alt=\"Not Yet!\">";
					//$printed = 0;
				}
				// The day is overdue.
				else
					echo "<img src=images/overdue.png border=0 alt=\"Overdue\">";
			}
		}
		echo "</td>";	//draw table
	}// for
	echo "</tr></table>";	//draw table
}

function td_bgcolor($b_day, $today, $i)
{
	if($b_day[$i] != $today)
		echo " bgcolor=white";
	else
		echo " bgcolor=#FFDDDD";
}
?>