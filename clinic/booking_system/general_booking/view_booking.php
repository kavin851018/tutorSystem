<html>
<head>
<style type="text/css">
<!--
A:hover {LEFT: 1px; POSITION: relative; TOP: 1px; text-decoration:none}
A{text-decoration:none}
.style1{font-family:Arial, Helvetica, sans-serif; font-size:13px; color:green;}
-->
</style>

<title>The general booking system</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
</head>

<body>
<span style="float:right;font-size:12px;"><a href="../show_management.php">Manager</a></span>
<table width="700" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006666">
  <tr> 
    <td colspan="6"><div align="center"> 
        <strong><font color="white" size="3"> </font></strong>
        <strong><font color="white" size="3">The General Booking System</font></strong></div></td>
  </tr>
  <tr bgcolor="#AAFFFF"> 
    <td> <div align="center"><font color="#006666" size="2">標題</font></div></td>
	<td align=center><font color=#006666 size=2>主持人</font></div>
	<td align=center><font color=#006666 size=2>地點</font></div>
	<td align=center><font color=#006666 size=2>舉辦時間</font></div>
    <td bgcolor="#AAFFFF"> <div align="center"><font color="#006666" size="2">最大報名人數</font></div></td>
    <td> <div align="center"><font color="#006666" size="2">截止日期</font></div></td>
  </tr>
  
<?php
include '../../../connect_db.php';
//$sql = "Select * From general_booking WHERE TIME >= DATE_SUB(NOW(),INTERVAL 6 MONTH ) Order By time DESC";

$sql = "Select * From general_booking Order By time DESC";
$result = mysql_query($sql, $conn);
$n = mysql_num_rows($result);

if($n)
{
	while( $row = mysql_fetch_array($result) )
	{
		echo "<tr bgcolor=white class=style1>";

		$condition=date('Y-m-d')>$row['time'];
		if($condition==1){
            echo "<td  align=center>" . $row['topic'] . "</td >";
        }else{
            echo "<td  align=center><a href=view_detail.php?id=" . $row['id'] . ">" . $row['topic'] . "</a></td >";

        }
		echo "<td align=center>" . $row['compere'] . "</td>";
		echo "<td align=center>" . $row['location'] . "</td>";
		echo "<td align=center>" . str_replace("-", "/", substr($row['time'],0,16)) . "</td>";
		echo "<td align=center>" . $row['max_booking'] . "</td>";
		echo "<td align=center>" . str_replace("-", "/" , $row['deadline']) . "</td>";
		echo "</tr>";
	}
}
?>

</table>

<?php
if(!$n)
	echo "<div align=center><br><br><font size=2 color=red>目前尚未有任何資料</font></div>";

mysql_close($conn);
?>
</body>
</html>
