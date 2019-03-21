<?php
$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
</head>

<body>
<p>&nbsp;</p>
<form name="form1" method="post" action="add_gen_booking2.php">
  <table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006666">
    <tr> 
      <td colspan="2"><div align="center"><br>
          <strong><font color="white" size="3">建立一個新的預約(報名)標題</font></strong><br>
          <br>
        </div></td>
    </tr>
    <tr> 
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">標題</font></td>
      <td bgcolor="white"> <input name="topic" type="text" id="topic" size="40" maxlength="128"></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#AAFFFF"><font color="#006666" size="2">敘述</font></td>
      <td bgcolor="white"> <textarea name="description" cols="70" rows="8" id="description"></textarea></td>
    </tr>
    <tr> 
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">最大報名人數</font></td>
      <td bgcolor="white"> <input name="max" type="text" id="max" value="0" size="10" maxlength="5"></td>
    </tr>
    <tr>
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">舉辦時間</font></td>
      <td bgcolor="white"><font color="#006666" size="2">
        <select name="start_yy" id="start_yy">

<?php
	echo "<option value=" . date('Y') . " selected>" . date('Y') . "</option>";
	echo "<option value=" . (date('Y')+1) . ">" . (date('Y')+1) . "</option>";
?>

        </select>
年
<select name="start_mm" id="select2">
  <?php
	for( $i=1; $i<=12; $i++ )
	{
		if( $i != date('n') )
			echo "<option value=" . $i . ">" . $i . "</option>";
		else
			echo "<option value=" . $i . " selected>" . $i . "</option>";
	}
?>
</select>
月
<select name="start_dd" id="select3">
  <?php
	for( $i = 1; $i <= 31; $i++ )
	{
		if( $i != date('j') )
			echo "<option value=" . $i . ">" . $i . "</option>";
		else
			echo "<option value=" . $i . " selected>" . $i . "</option>";
	}
?>
</select>
日
<input name="hour" type="text" id="hour" size="4" maxlength="2"> 
時
<input name="minite" type="text" id="minite" size="4" maxlength="2">
分      </font></td>
    </tr>
    <tr>
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">舉辦地點</font></td>
      <td bgcolor="white"><input name="location" type="text" id="location" size="20" maxlength="128"></td>
    </tr>
    <tr>
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">主持人/介紹人</font></td>
      <td bgcolor="white"><input name="compere" type="text" id="compere" size="20" maxlength="32"></td>
    </tr>
    <tr> 
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">到期日</font></td>
      <td bgcolor="white"><font color="#006666" size="2">
        <select name="yy" id="yy">
		  
<?php
	echo "<option value=" . date('Y') . " selected>" . date('Y') . "</option>";
	echo "<option value=" . (date('Y')+1) . ">" . (date('Y')+1) . "</option>";
?>

        </select>
        年 
        <select name="mm" id="mm">

<?php
	for( $i=1; $i<=12; $i++ )
	{
		if( $i != date('n') )
			echo "<option value=" . $i . ">" . $i . "</option>";
		else
			echo "<option value=" . $i . " selected>" . $i . "</option>";
	}
?>

                </select>
        月 
        <select name="dd" id="dd">

<?php
	for( $i = 1; $i <= 31; $i++ )
	{
		if( $i != date('j') )
			echo "<option value=" . $i . ">" . $i . "</option>";
		else
			echo "<option value=" . $i . " selected>" . $i . "</option>";
	}
?>

                </select>
        日</font></td>
    </tr>
      <tr>
          <td bgcolor="#AAFFFF"><font color="#006666" size="2">用餐習慣</font></td>
          <td bgcolor="white"><input name="compere" type="text" id="compere" size="20" maxlength="32"></td>
      </tr>
    <tr>

      <td colspan="2" bgcolor="#AAFFFF"> <div align="center"> 
          <input type="submit" name="Submit" value="建立">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
