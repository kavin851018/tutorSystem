<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>Booking</title>
</head>

<body>
<p>&nbsp;</p>
<form name="form1" method="post" action="user_delete2.php">
<?php
if( @$_SESSION['message'] != '' )
{
  echo "<div align=center>" . $_SESSION['message'] . "</div>";
  unset($_SESSION['message']);
}
?>
  <table width="350" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006666">
    <tr>
      <td colspan="2"><div align="center"><br>
              <strong><font color="white" size="3">取消報名</font></strong>
              <input name="booked_id" type="hidden" id="booked_id" value="<?php echo $_GET['id'];?>">
              <br>
              <br>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">姓名</font></td>
      <td bgcolor="white">        <input name="name" type="text" id="name" value="<?php echo @$_SESSION['name'];?>" size="20" maxlength="32"></td>
    </tr>
    <tr>
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">聯絡電話</font></td>
      <td bgcolor="white"><input name="phone" type="text" id="phone" value="<?php echo @$_SESSION['phone'];?>" size="20" maxlength="16"></td>
    </tr>
    <tr>
      <td bgcolor="#AAFFFF"><font color="#006666" size="2">Email</font></td>
      <td bgcolor="white"><font color="#006666" size="2">
        <input name="email" type="text" id="email" value="<?php echo @$_SESSION['email'];?>" size="30" maxlength="64">
        </font></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#AAFFFF">
        <div align="center">
          <br>
          <input type="submit" name="Submit" value="取消報名">
          <br>
          <br>
</div></td>
    </tr>
  </table>
</form>
<p style="text-align:center;">如無法取消報名，請Email: <a href="mailto:onlinelearning@mail.nsysu.edu.tw">onlinelearning@mail.nsysu.edu.tw</a></p>
</body>
</html>
