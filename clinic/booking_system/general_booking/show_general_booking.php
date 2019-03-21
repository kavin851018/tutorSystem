<?php
// This file is used to search all of the booking record and show it.

$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';
?>

<html>
<head>
<style type="text/css">
<!--
A:hover {LEFT: 1px; POSITION: relative; TOP: 1px; text-decoration:none}
A{text-decoration:none}
.style1{font-family:Arial, Helvetica, sans-serif; font-size:13px; color:black;}
-->
</style>

<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
</head>

<body>
<table width="700" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006666">
  <tr> 
    <td colspan="8"><div align="center"> 
        <table width="40" border="0" align="right" cellpadding="2" cellspacing="0">
          <tr> 
            <td bgcolor="#009999"> 
              <div align="center"><a href="add_gen_booking1.php"><font size="2" color=white>新增</font></a></div></td>
          </tr>
        </table>
        <strong><font color="white" size="3"> The General Booking System</font></strong></div></td>
  </tr>
  <tr bgcolor="#AAFFFF"> 
    <td> <div align="center"><font color="#006666" size="2">標題</font></div></td>
	<td align=center><font color=#006666 size=2>主持人</font></div>
	<td align=center><font color=#006666 size=2>地點</font></div>
	<td align=center><font color=#006666 size=2>時間</font></div>
    <td align=center><font color="#006666" size="2">最大報名人數</font></td>
	<td align=center><font color="#006666" size=2>已報名人數</font></td>
    <td> <div align="center"><font color="#006666" size="2">截止日期</font></div></td>
    <td> <div align="center"><font color="#006666" size="2">刪除</font></div></td>
	<td> <div align="center"><font color="#006666" size="2">View</font></div></td>
  </tr>
  
<?php
$sql = "Select * From general_booking Order By id DESC";
$result = mysql_query($sql, $conn);
$n = mysql_num_rows($result);

if($n)
{
	while( $row = mysql_fetch_array($result) )
	{
		// Find the number of booked.
		$sql = "Select id From general_booked Where booked_id='" . $row['id'] . "'";
		$k = mysql_num_rows(mysql_query($sql, $conn));
		echo "<tr bgcolor=white class=style1>";
		echo "<td align=center><a href=mod_gen_booking1.php?id=" . $row['id'] . ">" . $row['topic'] . "</a></td>";
		echo "<td align=center>" . $row['compere'] . "</td>";
		echo "<td align=center>" . $row['location'] . "</td>";
		echo "<td align=center>" . str_replace("-", "/", $row['time']) . "</td>";
		echo "<td align=center>" . $row['max_booking'] . "</td>";
		echo "<td align=center><a href=booked_person.php?id=" . $row['id'] . ">" . $k . "</a></td>";
		echo "<td align=center>" . str_replace("-", "/" , $row['deadline']) . "</td>";
		echo "<td align=center><a href=del_gen_booking.php?id=" . $row['id'] . ">DEL</a></td>";
		echo "<td align=cener><a href=view_detail.php?id=" . $row['id'] . ">URL</a></td>";
		echo "</tr>";
	}
}
?>

</table>

<?php
if(!$n)
	echo "<div align=center><br><br><font size=2 color=red>目前尚未有任何資料</font></div>";
?>
</body>
</html>

<?php
	mysql_close($conn);
?>
