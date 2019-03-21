<?php
session_start();

$_SESSION['from'] = "yes";
$d = $_GET['d'];
$location = $_GET['location'];
$order = $_GET['order'];
$tutor = $_GET['tutor'];

// Retrieve session variables.
@$student_id = $_SESSION['student_id'];
@$student_name = $_SESSION['student_name'];
@$student_dept = $_SESSION['student_dept'];
@$student_phone = $_SESSION['student_phone'];
@$student_email = $_SESSION['student_email'];

// Unset the session variables.
$_SESSION['student_id'] = "";
$_SESSION['student_name'] = "";
$_SESSION['student_dept'] = "";
$_SESSION['student_email'] = "";
$_SESSION['student_phone'] = "";
unset($_SESSION['student_id']);
unset($_SESSION['student_name']);
unset($_SESSION['student_dept']);
unset($_SESSION['student_email']);
unset($_SESSION['student_phone']);

if( !isset($_SESSION['book_m']) || !isset($_SESSION['book_d']) || !isset($_SESSION['book_y']) )
	$back_url = "book.php";
else
	$back_url = "book.php?m=" . $_SESSION['book_m'] . "&d=" . $_SESSION['book_d'] . "&y=" . $_SESSION['book_y'];
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>Booking System</title>
<style type="text/css">
<!--
.content {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:black}
.title {font-family:Arial, Helvetica, sans-serif;font-size:15px;color:white}
.style1{font-family:Arial, Helvetica, sans-serif;font-size:13px;color:blue}
.style2 {
	color: #FF0000;
	font-size: 13px;
}
.style5 {color: #990000;font-size:13px;}
.title1 {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:white}
.style_subtitle {font-family:Arial, Helvetica, sans-serif; font-size:13px; color:black}
.style_worklist_content {font-family:Arial, Helvetica, sans-serif; font-size:13px; color:black}
-->
</style>

<script language="JavaScript" type="text/JavaScript">
function initial()
{
<?php
if( isset($_SESSION['message']) && $_SESSION['message'] != "" )
{
	$mes = str_replace("<br>", "\\n", $_SESSION['message']);
	echo "alert(\"" . $mes . "\")";
	unset($_SESSION['message']);
}
else
	//echo "alert(\"�нT���J�ۤv���m�W�P�p���覡�Ӷi��w���A���̳W�w�d�U�p���覡�B���`�Y���̱N�C���¦W��C\");";
	echo "alert(\"�нT���J�ۤv���p���覡�Ӷi��w���A���̳W�w�d�U�p���覡�θ�T�����̡A�ӹw���۰ʧR���A���`�Y���̱N�C���¦W��C�����@��L�P���v�q�榸�w������οԸ߷���{�ɨ����w���A�N�����C�J�¦W��A�w�����v�@�Ӥ�A�ä��i��۾Ƕ�����W�C\\n���ϥΥ��H�b���n�O�A�аȥ���a�ǥ��ҩ�¾���ҫe���ԸߡA�������Ť@�g�o�{�A�N�C�J�¦W��B�b�~�����o�w���C \");";
?>
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
</head>

<body onLoad="initial();">
<p align=center></p>
<form name="form1" method="post" action="make_book2.php">
  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="20" height="20" background="images/tableCorner/lefttop.png">&nbsp;</td>
      <td background="images/tableCorner/top.png">&nbsp;</td>
      <td width="20" height="20" background="images/tableCorner/righttop.png">&nbsp;</td>
    </tr>
    <tr>
      <td background="images/tableCorner/left.png">&nbsp;</td>
      <td><table width="350" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr bgcolor="#FFA86F" class="content">
          <td colspan="2" align="center" class="title">��J�w�����(Booking Info)</td>
        </tr>
        <tr bgcolor="#FFDEC8" class="content">
          <td width="87" bgcolor="#FFFFFF" class="style1"><div align="center">�Ǹ�/�b��
            (ID)</div></td>
          <td width="248" bgcolor="#FFFFFF"><input name="id" type="text" id="id" value="<?php echo $student_id;?>" size="16" maxlength="32"></td>
        </tr>
        <!--<tr bgcolor="#FFDEC8" class="content">
          <td bgcolor="#FFFFFF" class="style1"><div align="center">�m�W(Name)</div></td>
          <td bgcolor="#FFFFFF"><input name="name" type="text" id="name" value="<?php echo $student_name;?>" size="16" maxlength="32"></td>
        </tr>
        <tr bgcolor="#FFDEC8" class="content">
          <td bgcolor="#FFFFFF" class="style1"><div align="center">�t��(Dept)</div></td>
          <td bgcolor="#FFFFFF"><input name="dept" type="text" id="dept" value="<?php echo $student_dept;?>" size="16" maxlength="16"></td>
        </tr>-->
        <tr bgcolor="#FFDEC8" class="content">
          <td bgcolor="#FFFFFF" class="style1"><div align="center">Email</div></td>
          <td bgcolor="#FFFFFF"><input name="email" type="text" id="email" value="<?php echo $student_email;?>" size="30" maxlength="64"></td>
        </tr>
        <tr bgcolor="#FFDEC8" class="content">
          <td bgcolor="#FFFFFF" class="style1"><div align="center">Phone</div></td>
          <td bgcolor="#FFFFFF"><input name="phone" type="text" id="phone" value="<?php echo $student_phone;?>" size="16" maxlength="16"></td>
        </tr>
        <tr bgcolor="#FFDEC8" class="content">
          <td bgcolor="#FFFFFF" class="style1"><div align="center">Code</div></td>
          <td bgcolor="#FFFFFF"><input name="code" type="password" id="code" size="16" maxlength="36">
              <br>
              <span class="style2">*�]�w�@�ձK�X�A���ӱz�Y�n�������w���A�ЧQ�Φ��K�X�����C</span></td>
        </tr>
        <tr bgcolor="#FFA86F" class="content">
          <td colspan="2" class="style1"><div align="center">
		  <input type="button" name="Submit2" value="Back" onClick="MM_goToURL('this','<?php echo $back_url;?>');return document.MM_returnValue">
            <input type="submit" name="Submit" value="Booking">
                  <input name="location" type="hidden" id="location" value="<?php echo $location?>">
                  <input name="d" type="hidden" id="d" value="<?php echo $d;?>">
                  <input name="order" type="hidden" id="order" value="<?php echo $order; ?>">
                  <input name="tutor" type="hidden" id="tutor" value="<?php echo $tutor;?>">
          </div></td>
        </tr>
      </table>
        <div align="center"><br>
          <font color="red" size="2">�Яd�UEmail �MPhone ���,���޲z���b����o�ƥ�ɯ�P�A�s���C</font></div></td>
      <td background="images/tableCorner/right.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="20" height="20" background="images/tableCorner/leftbottom.png">&nbsp;</td>
      <td background="images/tableCorner/bottom.png">&nbsp;</td>
      <td width="20" height="20" background="images/tableCorner/rightbottom.png">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p align="center">&nbsp;</p>
</form>
</body>
</html>