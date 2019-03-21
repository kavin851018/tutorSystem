<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{
	include '../../connect_db.php';
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>The Booking Manager</title>
<style type="text/css">
<!--
A:hover {LEFT: 1px; POSITION: relative; TOP: 1px; text-decoration:none}
A{text-decoration:none}
.title {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:white}
.content {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:black}
-->
</style>
</head>
<body>

<table align=center width="90%" border=0 cellpadding="3" cellspacing="1" bgcolor="#996699">
  <tr bgcolor="#ECE3EC"> 
    <td valign="top" class="content"><div align="center"><strong>Functions</strong></div></td>
    <td><div align="center"><strong>The schedules of Booking System </strong></div></td>
  </tr>
  <tr bgcolor="white"> 
    <td valign="top" bgcolor="white" class="content"><p>==== Self Access Center ====<br>
&gt; <!--a href="http://zephyr.nsysu.edu.tw/self_access/eng_knowledge/manager.php">New English Knowledge</a><br>
&gt; <a href="http://zephyr.nsysu.edu.tw/self_access/news_system/news_manager.php">News</a><br>
&gt; <a href="http://zephyr.nsysu.edu.tw/self_access/forum/login.php">Forum</a><br>
&gt; Booking System<br>
        　1. <a href="add_tutor.php">Add a tutor </a><br>
        　2. <a href="add_title.php">Add a class </a><br>
        　3. <a href="delete_booking.php">Delete booking</a><br>
        　4. <a href="delete_overdue.php">Delete overdue bookings</a><br>
        　5. <a href="set_holiday1.php">Set holiday</a><br>
        　6. <a href="blacklist.php">Manage Blacklist</a><br>
        &gt; <a href="http://zephyr.nsysu.edu.tw/self_access/class_resource/manager/manager.php" target="_blank">Class resource</a> </p>
      <p>====　Manager　====<br>
        &gt; <a href="modify_info.php">Modify Personal Info</a></p>
      <p> =Foreign Language Dept=<br>
        &gt; <a href="bulletin_board/bulletin_manager.php">Bulletin Board</a><br--> 
        &gt;
<a href="general_booking/show_general_booking.php">General Booking System</a></p>
      <!--p>=== Temp ===<br>
        &gt; <a href="http://zephyr.nsysu.edu.tw/toeic/show_registration.php">Toeic registration result</a><br>
        &gt; <a href="http://zephyr.nsysu.edu.tw/csept/show_registration.php">CSEPT registration result </a><br>
        &gt; <a href="../../../TACMRS/2008dream/showRegistration.php">TACMRS registration result</a> </p-->
    </td>
    <td> <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FF6600">
        <tr bgcolor="#FFA86F" class="content"> 
          <td colspan="6"><div align="center" class="title">The schedule of DELL 
              Room </div></td>
        </tr>
        <tr bgcolor="#FFDEC8" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">Time</div></td>
          <td width="75"><div align="center">Monday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Tuesday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Wednesday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Thursday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Friday</div></td>
        </tr>
        <?php
// Select the schedule from DELL
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

// Select the class from DELL
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
	
if($i || $j)
{
?>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8" align="center">9:00~10:00</td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_monday, $title_name, $j); if($i) if($i) print_tutor(2048, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(2048, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(2048, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(2048, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_friday, $title_name, $j); if($i) if($i) print_tutor(2048, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">10:00~11:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_monday, $title_name, $j); if($i) if($i) print_tutor(1024, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(1024, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(1024, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(1024, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_friday, $title_name, $j); if($i) if($i) print_tutor(1024, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">11:00~12:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_monday, $title_name, $j); if($i) if($i) print_tutor(512, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(512, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(512, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(512, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_friday, $title_name, $j); if($i) if($i) print_tutor(512, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">12:00~13:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_monday, $title_name, $j); if($i) if($i) print_tutor(256, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(256, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(256, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(256, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_friday, $title_name, $j); if($i) if($i) print_tutor(256, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">13:00~14:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_monday, $title_name, $j); if($i) if($i) print_tutor(128, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(128, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(128, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(128, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_friday, $title_name, $j); if($i) if($i) print_tutor(128, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">14:00~15:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_monday, $title_name, $j); if($i) if($i) print_tutor(64, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(64, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(64, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(64, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_friday, $title_name, $j); if($i) if($i) print_tutor(64, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">15:00~16:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_monday, $title_name, $j); if($i) if($i) print_tutor(32, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(32, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(32, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(32, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_friday, $title_name, $j); if($i) if($i) print_tutor(32, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">16:00~17:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_monday, $title_name, $j); if($i) if($i) print_tutor(16, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(16, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_wednesday, $title_name, $j);if($i) print_tutor(16, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_thursday, $title_name, $j);if($i) print_tutor(16, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_friday, $title_name, $j);if($i) print_tutor(16, $friday, $tutor_name, $i);?>
          </td>
        </tr>
<tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">17:00~18:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_monday, $title_name, $j); if($i) if($i) print_tutor(8, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(8, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_wednesday, $title_name, $j);if($i) print_tutor(8, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_thursday, $title_name, $j);if($i) print_tutor(8, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_friday, $title_name, $j);if($i) print_tutor(8, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">18:00~19:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_monday, $title_name, $j);if($i) print_tutor(4, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_tuesday, $title_name, $j);if($i) print_tutor(4, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_wednesday, $title_name, $j);if($i) print_tutor(4, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_thursday, $title_name, $j);if($i) print_tutor(4, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_friday, $title_name, $j);if($i) print_tutor(4, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">19:00~20:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_monday, $title_name, $j);if($i) print_tutor(2, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_tuesday, $title_name, $j);if($i) print_tutor(2, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_wednesday, $title_name, $j);if($i) print_tutor(2, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_thursday, $title_name, $j);if($i) print_tutor(2, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_friday, $title_name, $j);if($i) print_tutor(2, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">20:00~21:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_monday, $title_name, $j);if($i) print_tutor(1, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_tuesday, $title_name, $j);if($i) print_tutor(1, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_wednesday, $title_name, $j);if($i) print_tutor(1, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_thursday, $title_name, $j);if($i) print_tutor(1, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_friday, $title_name, $j);if($i) print_tutor(1, $friday, $tutor_name, $i);?>
          </td>
        </tr>
      </table>
      <table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006600">
        <tr bgcolor="#B0FFB0" class="content" align="center"> 
          <td>The tutors in DELL Room </td>
          <td>The class in DELL Room </td>
        </tr>
        <tr bgcolor="#B0FFB0" class="content" align="center"> 
          <td> 
            <?php
	echo "<table width=100% border=0 align=center cellpadding=3 cellspacing=1 bgcolor=#006600>";
	
	// Read all of the tutors from two table 'schedule'
	$sql = "Select tutor_name From schedule";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$i = 0;
	while( $row = mysql_fetch_row($result) )
	{
		echo "<tr bgcolor=white class=content>";
		echo "<td><a href=modify_schedule.php?tutor=" . $row[0] . "&location=DELL>" . $row[0] . "</a></td>";
		echo "<td><a href=delete_tutor.php?tutor=" . $row[0] . "><font color=red>Del</font></a></td>";
		echo "</tr>";
	}
	echo "</table>";
?>
          </td>
          <td> 
            <?php
	echo "<table width=100% border=0 align=center cellpadding=3 cellspacing=1 bgcolor=#006600>";
	
	// Read all of the title from two table 'title_name'
	$sql = "Select title_name,id From class_title Where location='DELL'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$i = 0;
	while( $row = mysql_fetch_row($result) )
	{
		echo "<tr bgcolor=white class=content>";
		echo "<td><a href=modify_class.php?id=" . $row[1] . ">" . $row[0] . "</a></td>";
		echo "<td><a href=delete_class.php?id=" . $row[1] . "><font color=red>Del</font></a></td>";
		echo "</tr>";
	}
	echo "</table>";
?>
          </td>
        </tr>
      </table>
      <?php
}
else
{
	echo "</table><font color=green size=2>No schedule of DELL ROOM!!</font>";
}
echo "<br><br><br>";
?>
      <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FF6600">
        <tr bgcolor="#FFA86F" class="content"> 
          <td colspan="6"><div align="center" class="title">The Schedule of library 
            </div></td>
        </tr>
        <tr bgcolor="#FFDEC8" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">Time</div></td>
          <td width="75"><div align="center">Monday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Tuesday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Wednesday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Thursday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Friday</div></td>
        </tr>
        <?php
// Select the schedule from Library
$sql = "Select * From schedule_lib";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 0;
while( $row = mysql_fetch_array($result) )
{
	$tutor_name_lib[$i] = $row['tutor_name'];
	$monday_lib[$i] = $row['monday'];
	$tuesday_lib[$i] = $row['tuesday'];
	$wednesday_lib[$i] = $row['wednesday'];
	$thursday_lib[$i] = $row['thursday'];
	$friday_lib[$i] = $row['friday'];
	$i++;
}

	$sql = "Select * From class_title Where location='LIB'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$j = 0;
	while( $row = mysql_fetch_array($result) )
	{
		$title_name_lib[$j] = $row['title_name'];
		$t_monday_lib[$j] = $row['monday'];
		$t_tuesday_lib[$j] = $row['tuesday'];
		$t_wednesday_lib[$j] = $row['wednesday'];
		$t_thursday_lib[$j] = $row['thursday'];
		$t_friday_lib[$j] = $row['friday'];
		$j++;
	}
	
if($i || $j)
{
?>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8" align="center">9:00~10:00</td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_monday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(2048, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_tuesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(2048, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_wednesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(2048, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_thursday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(2048, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_friday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(2048, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">10:00~11:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_monday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(1024, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_tuesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(1024, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_wednesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(1024, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_thursday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(1024, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_friday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(1024, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">11:00~12:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_monday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(512, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_tuesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(512, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_wednesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(512, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_thursday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(512, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_friday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(512, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">12:00~13:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_monday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(256, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_tuesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(256, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_wednesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(256, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_thursday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(256, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_friday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(256, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">13:00~14:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_monday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(128, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_tuesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(128, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_wednesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(128, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_thursday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(128, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_friday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(128, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">14:00~15:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_monday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(64, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_tuesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(64, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_wednesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(64, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_thursday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(64, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_friday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(64, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">15:00~16:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_monday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(32, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_tuesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(32, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_wednesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(32, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_thursday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(32, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_friday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(32, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">16:00~17:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_monday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(16, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_tuesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(16, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_wednesday_lib, $title_name_lib, $j);if($i) print_tutor(16, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_thursday_lib, $title_name_lib, $j);if($i) print_tutor(16, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_friday_lib, $title_name_lib, $j);if($i) print_tutor(16, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
<tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">17:00~18:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_monday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(8, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_tuesday_lib, $title_name_lib, $j); if($i) if($i) print_tutor(8, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_wednesday_lib, $title_name_lib, $j);if($i) print_tutor(8, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_thursday_lib, $title_name_lib, $j);if($i) print_tutor(8, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_friday_lib, $title_name_lib, $j);if($i) print_tutor(8, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">18:00~19:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_monday_lib, $title_name_lib, $j);if($i) print_tutor(4, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_tuesday_lib, $title_name_lib, $j);if($i) print_tutor(4, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_wednesday_lib, $title_name_lib, $j);if($i) print_tutor(4, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_thursday_lib, $title_name_lib, $j);if($i) print_tutor(4, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_friday_lib, $title_name_lib, $j);if($i) print_tutor(4, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">19:00~20:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_monday_lib, $title_name_lib, $j);if($i) print_tutor(2, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_tuesday_lib, $title_name_lib, $j);if($i) print_tutor(2, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_wednesday_lib, $title_name_lib, $j);if($i) print_tutor(2, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_thursday_lib, $title_name_lib, $j);if($i) print_tutor(2, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_friday_lib, $title_name_lib, $j);if($i) print_tutor(2, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">20:00~21:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_monday_lib, $title_name_lib, $j);if($i) print_tutor(1, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_tuesday_lib, $title_name_lib, $j);if($i) print_tutor(1, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_wednesday_lib, $title_name_lib, $j);if($i) print_tutor(1, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_thursday_lib, $title_name_lib, $j);if($i) print_tutor(1, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_friday_lib, $title_name_lib, $j);if($i) print_tutor(1, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
      </table>
      <table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006600">
        <tr bgcolor="#B0FFB0" class="content" align="center"> 
          <td>The tutors in library </td>
          <td>The class in library </td>
        </tr>
        <tr bgcolor="#B0FFB0" class="content" align="center"> 
          <td> 
            <?php
	echo "<table width=100% border=0 align=center cellpadding=3 cellspacing=1 bgcolor=#006600>";
	
	// Read all of the tutors from two table 'schedule'
	$sql = "Select tutor_name From schedule_lib";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$i = 0;
	while( $row = mysql_fetch_row($result) )
	{
		echo "<tr bgcolor=white class=content>";
		echo "<td><a href=modify_schedule.php?tutor=" . $row[0] . "&location=LIB>" . $row[0] . "</a></td>";
		echo "<td><a href=delete_tutor_lib.php?tutor=" . $row[0] . "><font color=red>Del</font></a></td>";
		echo "</tr>";
	}
	echo "</table>";
?>
          </td>
          <td> 
            <?php
	echo "<table width=100% border=0 align=center cellpadding=3 cellspacing=1 bgcolor=#006600>";
	
	// Read all of the titles from two table 'title_name'
	$sql = "Select title_name,id From class_title Where location='LIB'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$i = 0;
	while( $row = mysql_fetch_row($result) )
	{
		echo "<tr bgcolor=white class=content>";
		echo "<td><a href=modify_class.php?id=" . $row[1] . ">" . $row[0] . "</a></td>";
		echo "<td><a href=delete_class.php?id=" . $row[1] . "><font color=red>Del</font></a></td>";
		echo "</tr>";
	}
	echo "</table>";
?>
          </td>
        </tr>
        
        
        
        
        
        
        
        
      </table>
      <?php
}
else
{
	echo "</table><font color=green size=2>No schedule of DELL ROOM!!</font>";
}
?>
<br>



  <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FF6600">
        <tr bgcolor="#FFA86F" class="content"> 
          <td colspan="6"><div align="center" class="title">The Schedule of dormitory 
            </div></td>
        </tr>
        <tr bgcolor="#FFDEC8" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">Time</div></td>
          <td width="75"><div align="center">Monday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Tuesday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Wednesday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Thursday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Friday</div></td>
        </tr>
        <?php
// Select the schedule from Library
$sql = "Select * From schedule_night";
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

	$sql = "Select * From class_title Where location='NIGHT'";
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
	
if($i || $j)
{
?>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8" align="center">9:00~10:00</td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_monday, $title_name, $j); if($i) if($i) print_tutor(2048, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(2048, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(2048, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(2048, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2048, $t_friday, $title_name, $j); if($i) if($i) print_tutor(2048, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">10:00~11:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_monday, $title_name, $j); if($i) if($i) print_tutor(1024, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(1024, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(1024, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(1024, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1024, $t_friday, $title_name, $j); if($i) if($i) print_tutor(1024, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">11:00~12:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_monday, $title_name, $j); if($i) if($i) print_tutor(512, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(512, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(512, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(512, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(512, $t_friday, $title_name, $j); if($i) if($i) print_tutor(512, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">12:00~13:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_monday, $title_name, $j); if($i) if($i) print_tutor(256, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(256, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(256, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(256, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(256, $t_friday, $title_name, $j); if($i) if($i) print_tutor(256, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">13:00~14:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_monday, $title_name, $j); if($i) if($i) print_tutor(128, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(128, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(128, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(128, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(128, $t_friday, $title_name, $j); if($i) if($i) print_tutor(128, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">14:00~15:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_monday, $title_name, $j); if($i) if($i) print_tutor(64, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(64, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(64, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(64, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(64, $t_friday, $title_name, $j); if($i) if($i) print_tutor(64, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">15:00~16:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_monday, $title_name, $j); if($i) if($i) print_tutor(32, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(32, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_wednesday, $title_name, $j); if($i) if($i) print_tutor(32, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_thursday, $title_name, $j); if($i) if($i) print_tutor(32, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(32, $t_friday, $title_name, $j); if($i) if($i) print_tutor(32, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">16:00~17:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_monday, $title_name, $j); if($i) if($i) print_tutor(16, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(16, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_wednesday, $title_name, $j);if($i) print_tutor(16, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_thursday, $title_name, $j);if($i) print_tutor(16, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(16, $t_friday, $title_name, $j);if($i) print_tutor(16, $friday, $tutor_name, $i);?>
          </td>
        </tr>
<tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">17:00~18:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_monday, $title_name, $j); if($i) if($i) print_tutor(8, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_tuesday, $title_name, $j); if($i) if($i) print_tutor(8, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_wednesday, $title_name, $j);if($i) print_tutor(8, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_thursday, $title_name, $j);if($i) print_tutor(8, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(8, $t_friday, $title_name, $j);if($i) print_tutor(8, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">18:00~19:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_monday, $title_name, $j);if($i) print_tutor(4, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_tuesday, $title_name, $j);if($i) print_tutor(4, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_wednesday, $title_name, $j);if($i) print_tutor(4, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_thursday, $title_name, $j);if($i) print_tutor(4, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(4, $t_friday, $title_name, $j);if($i) print_tutor(4, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">19:00~20:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_monday, $title_name, $j);if($i) print_tutor(2, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_tuesday, $title_name, $j);if($i) print_tutor(2, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_wednesday, $title_name, $j);if($i) print_tutor(2, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_thursday, $title_name, $j);if($i) print_tutor(2, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(2, $t_friday, $title_name, $j);if($i) print_tutor(2, $friday, $tutor_name, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">20:00~21:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_monday, $title_name, $j);if($i) print_tutor(1, $monday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_tuesday, $title_name, $j);if($i) print_tutor(1, $tuesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_wednesday, $title_name, $j);if($i) print_tutor(1, $wednesday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_thursday, $title_name, $j);if($i) print_tutor(1, $thursday, $tutor_name, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(1, $t_friday, $title_name, $j);if($i) print_tutor(1, $friday, $tutor_name, $i);?>
          </td>
        </tr>
      </table>
      <table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006600">
        <tr bgcolor="#B0FFB0" class="content" align="center"> 
          <td>The tutors in dormitory </td>
          <td>The class in dormitory </td>
        </tr>
        <tr bgcolor="#B0FFB0" class="content" align="center"> 
          <td> 
            <?php
	echo "<table width=100% border=0 align=center cellpadding=3 cellspacing=1 bgcolor=#006600>";
	
	// Read all of the tutors from two table 'schedule'
	$sql = "Select tutor_name From schedule_night";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$i = 0;
	while( $row = mysql_fetch_row($result) )
	{
		echo "<tr bgcolor=white class=content>";
		echo "<td><a href=modify_schedule.php?tutor=" . $row[0] . "&location=NIGHT>" . $row[0] . "</a></td>";
		echo "<td><a href=delete_tutor_night.php?tutor=" . $row[0] . "><font color=red>Del</font></a></td>";
		echo "</tr>";
	}
	echo "</table>";
?>
          </td>
          <td> 
            <?php
	echo "<table width=100% border=0 align=center cellpadding=3 cellspacing=1 bgcolor=#006600>";
	
	// Read all of the titles from two table 'title_name'
	$sql = "Select title_name,id From class_title Where location='NIGHT'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$i = 0;
	while( $row = mysql_fetch_row($result) )
	{
		echo "<tr bgcolor=white class=content>";
		echo "<td><a href=modify_class.php?id=" . $row[1] . ">" . $row[0] . "</a></td>";
		echo "<td><a href=delete_class.php?id=" . $row[1] . "><font color=red>Del</font></a></td>";
		echo "</tr>";
	}
	echo "</table>";
?>
          </td>
        </tr>
      </table>
      <?php
}
else
{
	echo "</table><font color=green size=2>No schedule of dormitory!!</font>";
}
?>
    </td>

  </tr>
</table>
    </td>
    
  </tr>
  
</table>
</body>
</html>
<?php
mysql_close($conn);

} // login check

// This function is used to print the tutor's name. It has four variables.
// $index indicates that what the exponent is now.
// $day indicates that what day is now.
// $name indicates that tutors' name.
// $num indicats the number of all tutors.
function print_tutor($index, &$day, $name, $num)
{
$color = array('blue', 'green', 'red', 'orange', 'purple');

	for( $i=0; $i<$num; $i++ )
	{
		$j = $i % 5;
		if( $day[$i] >= $index )
		{
			echo "<font color=" . $color[$j] . ">" . $name[$i] . "</font><br>";
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
			echo "<font color=#999933>" . $name[$i] . "</font><br>";
			$day[$i] -= $index;
		}
	}
}
?>
