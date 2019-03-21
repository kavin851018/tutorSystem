<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{

include '../../connect_db.php';
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form name="form1" method="post" action="set_holiday2.php">
  <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006633">
    <tr> 
      <td><div align="center"><font color="white" size="3"><strong>Set Holiday</strong></font></div></td>
    </tr>
    <tr> 
      <td bgcolor="white"><div align="center"><font size="2">From 
          <input name="fy" type="text" id="fy" size="4" maxlength="4">
          年 
          <input name="fm" type="text" id="fm" size="4" maxlength="2">
          月 
          <input name="fd" type="text" id="fd" size="4" maxlength="2">
          日　　 To 
          <input name="ty" type="text" id="ty" size="4" maxlength="4">
          年 
          <input name="tm" type="text" id="tm" size="4" maxlength="2">
          月 
          <input name="td" type="text" id="td" size="4" maxlength="2">
          日<br>
          <font color="green">(ex. From 2006/12/25 To 2007/1/3)</font></font></div></td>
    </tr>
    <tr> 
      <td bgcolor="white"><div align="center"> 
          <input type="submit" name="Submit" value="Add Holiday setting">
          <font size="2">[<a href="show_management.php">返回</a>]</font></div></td>
    </tr>
  </table>
</form>
<?php
$sql = "Select * From holiday ORDER BY from_date DESC";
$result = mysql_query($sql, $conn);
$n = mysql_num_rows($result);
if($n)
{
?>

<table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#003366">
  <tr> 
    <td colspan="3"><div align="center"><font color="white" size="3"><strong>Existed 
        Holiday setting</strong></font></div></td>
  </tr>

<?php
	$i = $n; //total num rows of record edited by Gavin 25Jan2016

	while( $row = mysql_fetch_array($result) )
	{
		echo "<tr>";
		echo "<td bgcolor=white><font color=blue size=2>" . $i . "</font></td>";
		echo "<td bgcolor=white><font color=blue size=2>" . $row['from_date'] . " - " . $row['to_date'] . "</font></td>";
		echo "<td bgcolor=white><a href=delete_holiday.php?f=" . $row['from_date'] . "&t=" . $row['to_date'] . "><font color=red size=2>Delete</font></a></td>";
		echo "</tr>";
		$i--;
	}
}

mysql_close($conn);
?>
</table>
</body>
</html>
<?php
} // login check
?>