<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>�L���D���</title>
<style type="text/css">
<!--
.style1 {color: white; font-weight:bold;}
.style2 {font-size:13px; color:#993300;}
.style3 {font-size:13px; color:red;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="delete_booking2.php">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="300" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#996600">
    <tr>
      <td colspan="2" align=center><span class="style1">�j�M���R�����w��</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFEBBF" class="style2"><div align="center">�m�W<span class="style3">*</span></div></td>
      <td bgcolor="white"><input name="name" type="text" id="name" size="16" maxlength="32"></td>
    </tr>
    <tr>
      <td bgcolor="#FFEBBF" class="style2"><div align="center">�t��</div></td>
      <td bgcolor="white"><input name="dept" type="text" id="dept" size="16" maxlength="32">      </td>
    </tr>
    <tr>
      <td bgcolor="#FFEBBF" class="style2"><div align="center">Location:</div></td>
      <td bgcolor="white"><select name="location" id="location">
        <option selected> </option>
        <option value="DELL">�~��t309��</option>
        <option value="LIB">�Ϯ��]</option>
        <option value="NIGHT">�J�ٰ�</option>        
      </select></td>
    </tr>
    <tr>
      <td bgcolor="#FFEBBF" class="style2"><div align="center">���</div></td>
      <td bgcolor="white"><input name="year" type="text" id="year" size="4" maxlength="4">
        �~
        <input name="month" type="text" id="month" size="4" maxlength="2">
          ��
        <input name="day" type="text" id="day" size="4" maxlength="2">
          ��          </td>
    </tr>
    <tr>
      <td bgcolor="#FFEBBF" class="style2"><div align="center">�ɬq</div></td>
      <td bgcolor="white"><select name="time" id="time">
        <option selected> </option>
        <option value="2048">9:00~10:00</option>
        <option value="1024">10:00~11:00</option>
        <option value="512">11:00~12:00</option>
        <option value="256">12:00~13:00</option>
        <option value="128">13:00~14:00</option>
        <option value="64">14:00~15:00</option>
        <option value="32">15:00~16:00</option>
        <option value="16">16:00~17:00</option>
        <option value="8">17:00~18:00</option>
        <option value="4">18:00~19:00</option>
        <option value="2">19:00~20:00</option>
        <option value="1">20:00~21:00</option>
                                                                                                </select>        <select name="order" id="order">
                                                                                <option selected> </option>
                                                                                <option value="1">0~25</option>
        <option value="2">30~55</option>
                                                                                                                                                                  </select></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFEBBF" class="style2"><div align="center">
        <input type="submit" name="Submit" value="Search">
      </div></td>
    </tr>
  </table>
  <p align="center" class="style3">�j�M�����ɡA�Ъ�����[Search]<br>
    �νЦܤֿ�J�m�W�@���j�M��keyword</p>
</form>
</body>
</html>
<?php
}
?>