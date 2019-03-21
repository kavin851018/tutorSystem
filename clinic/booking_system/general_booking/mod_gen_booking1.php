<?php
$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';

// Received id
$id = $_GET['id'];
$sql = "Select * From general_booking Where id = '" . $id . "'";
$row = mysql_fetch_array(mysql_query($sql, $conn));
$start_yy = substr($row['time'],0,4);
$start_mm = substr($row['time'],5,2);
$start_dd = substr($row['time'],8,2);
$hour = substr($row['time'],11,2);
$minite = substr($row['time'],14,2);
$yy = substr($row['deadline'],0,4);
$mm = substr($row['deadline'],5,2);
$dd = substr($row['deadline'],8,2);
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<p>&nbsp;</p>
<form name="form1" method="post" action="mod_gen_booking2.php">
  <table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006666">
    <tr> 
      <td colspan="2"><div align="center"><br>
          <strong><font color="white" size="3">修改</font></strong>
          <input name="id" type="hidden" id="id" value="<?php echo $id;?>">
          <br>
          <br>
        </div></td>
    </tr>
    <tr> 
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">標題</font></td>
      <td bgcolor="white"> <input name="topic" type="text" id="topic" value="<?php echo $row['topic'];?>" size="40" maxlength="128"></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#AAFFFF"><font color="#006666" size="2">敘述</font></td>
      <td bgcolor="white"> <textarea name="description" cols="70" rows="8" id="description"><?php echo $row['description'];?></textarea></td>
    </tr>
    <tr> 
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">最大人數</font></td>
      <td bgcolor="white"> <input name="max" type="text" id="max" value="<?php echo $row['max_booking'];?>" size="10" maxlength="5"></td>
    </tr>
    <tr>
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">舉辦時間</font></td>
      <td bgcolor="white"><font color="#006666" size="2">
        <input name="start_yy" type="text" id="start_yy" value="<?php echo $start_yy;?>" size="8" maxlength="4">
年
<input name="start_mm" type="text" id="start_mm" value="<?php echo $start_mm;?>" size="4" maxlength="2">
月
<input name="start_dd" type="text" id="start_dd" value="<?php echo $start_dd;?>" size="4" maxlength="2">
日
<input name="hour" type="text" id="hour" value="<?php echo $hour;?>" size="4" maxlength="2">
時
<input name="minite" type="text" id="minite" value="<?php echo $minite;?>" size="4" maxlength="2">
分      </font></td>
    </tr>
    <tr>
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">舉辦地點</font></td>
      <td bgcolor="white"><input name="location" type="text" id="location" value="<?php echo $row['location'];?>" size="20" maxlength="128"></td>
    </tr>
    <tr>
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">主持人/介紹人</font></td>
      <td bgcolor="white"><input name="compere" type="text" id="compere" value="<?php echo $row['compere'];?>" size="20" maxlength="32"></td>
    </tr>
    <tr> 
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">到期日</font></td>
      <td bgcolor="white"><font color="#006666" size="2">
        <input name="yy" type="text" id="yy" value="<?php echo $yy;?>" size="8" maxlength="4">
        年 
        <input name="mm" type="text" id="mm" value="<?php echo $mm;?>" size="4" maxlength="2">
        月 
        <input name="dd" type="text" id="dd" value="<?php echo $dd;?>" size="8" maxlength="2">
        日</font></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#AAFFFF"> <div align="center"> 
          <input type="submit" name="Submit" value="修改">
          <input name="Submit2" type="button" onClick="MM_goToURL('this','show_general_booking.php');return document.MM_returnValue" value="返回">
</div></td>
    </tr>
  </table>
</form>
<div align="center">
  報名名單：<br>
  <?php
  $sql = "Select * From `general_booked` Where booked_id='".$id."'";
  $result_booked = mysql_query($sql, $conn) or die(mysql_error());
  $i = 1;

  echo "<table border='1'>";
  while( $row_booked = mysql_fetch_array($result_booked)){
      if($row_booked['name']=='雀祠v'){$row_booked['name']="許雄肖";}//big5 encoding problem workaround 20171018
    echo "<tr class=style2><td>";
    echo $i . ". </td>";
    echo "<td>".$row_booked['dept']."</td><td>".$row_booked['name']."</td><td>".$row_booked['phone']."</td><td>".$row_booked['email']."</td>";
    $i++;
    echo "</tr>";
  }
  echo "</table>";
  ?>
</div>
</body>
</html>
<?php
mysql_close($conn);
?>