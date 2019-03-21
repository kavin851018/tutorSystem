<?php
$target = "clinic/booking_system/login.htm";
include '../../check_login.php';
if($n != 0 )
{
include '../../connect_db.php';
?>

<html>
<head>
<style type="text/css">
<!--
.title{font-family:Arial, Helvetica, sans-serif; font-size:15px;color:white}
.content{font-family:Arial, Helvetica, sans-serif;font-size:13px;color:black}
.red{font-family:Arial, Helvetica, sans-serif;font-size:13px;color:red; font-weight:bold}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>無標題文件</title>
</head>

<body>
<form name="form1" method="post" action="add_tutor2.php">
<table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#336600">
  <tr>
    <td><div align="center" class="title">Add a tutor</div></td>
  </tr>
  <tr>
    <td bgcolor="white"><span class="content">Tutor's Name:</span>	 <input name="name" type="text" id="name" maxlength="32">
        <strong><font color="#FF0000" size="2">(不可有空格)</font></strong> </td>
  </tr>
  <tr>
    <td bgcolor="white"><span class="content">Tutor's Email:</span>      <input name="email" type="text" id="email"></td>
  </tr>
  <tr>
    <td bgcolor="white" class="content">Select class:
	<select name="class" id="class">
<?php
$sql = "Select title_name, location, id From class_title Order by location";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 0;
while( $row = mysql_fetch_array($result) )
{
	if( $row['location'] == "DELL" )
		$location = "DELL Room 306";
	else if( $row['location'] == "LIB" )
		$location = "Library Building";
	else if( $row['location'] == "NIGHT" )
		$location = "Dormitory Building";		
		
		
	echo "<option value=\"" . $row['id'] . "\"";
	if( $i == 0 ) echo " selected";
	echo ">" . $row['title_name'] . " ($location)" . "</option>";
	$i++;
}
?>
	</select> 
	<span class="red">(選擇tutor要負責的class，請仔細將tutor與class配合好)</span></td>
  </tr>
  <tr>
    <td bgcolor="white"><span class="content">Select the Location:</span>      <select name="location" id="location">
        <option value="DELL" selected>DELL Room 306</option>
        <option value="LIB">Library Building</option>
        <option value="NIGHT">Dormitory Building</option>
      </select></td>
  </tr>
  <tr>
    <td bgcolor="white"><div align="center"><span class="content">Time Table: </span><br>      
    </div>      
        <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FF6600">
          <tr bgcolor="#FFDEC8" class="content"> 
            <td bgcolor="#FFDEC8"><div align="center">Time</div></td>
            <td width="75"><div align="center">Monday</div></td>
            <td width="75" bgcolor="#FFDEC8"><div align="center">Tuesday</div></td>
            <td width="75" bgcolor="#FFDEC8"><div align="center">Wednesday</div></td>
            <td width="75" bgcolor="#FFDEC8"><div align="center">Thursday</div></td>
            <td width="75" bgcolor="#FFDEC8"><div align="center">Friday</div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">9:00~10:00</div></td>
            <td width="75"><div align="center"> 
                <input name="monday1" type="checkbox" id="monday1" value="2048">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="tuesday1" type="checkbox" id="tuesday1" value="2048">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="wednesday1" type="checkbox" id="wednesday1" value="2048">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="thursday1" type="checkbox" id="thursday1" value="2048">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="friday1" type="checkbox" id="friday1" value="2048">
              </div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">10:00~11:00</div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="monday2" type="checkbox" id="monday2" value="1024">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="tuesday2" type="checkbox" id="tuesday2" value="1024">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="wednesday2" type="checkbox" id="wednesday2" value="1024">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="thursday2" type="checkbox" id="thursday2" value="1024">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="friday2" type="checkbox" id="friday2" value="1024">
              </div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">11:00~12:00</div></td>
            <td width="75"><div align="center"> 
                <input name="monday3" type="checkbox" id="monday3" value="512">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="tuesday3" type="checkbox" id="tuesday3" value="512">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="wednesday3" type="checkbox" id="wednesday3" value="512">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="thursday3" type="checkbox" id="thursday3" value="512">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="friday3" type="checkbox" id="friday3" value="512">
              </div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">12:00~13:00</div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="monday4" type="checkbox" id="monday4" value="256">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="tuesday4" type="checkbox" id="tuesday4" value="256">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="wednesday4" type="checkbox" id="wednesday4" value="256">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="thursday4" type="checkbox" id="thursday4" value="256">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="friday4" type="checkbox" id="friday4" value="256">
              </div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">13:00~14:00</div></td>
            <td width="75"><div align="center"> 
                <input name="monday5" type="checkbox" id="monday5" value="128">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="tuesday5" type="checkbox" id="tuesday5" value="128">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="wednesday5" type="checkbox" id="wednesday5" value="128">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="thursday5" type="checkbox" id="thursday5" value="128">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="friday5" type="checkbox" id="friday5" value="128">
              </div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">14:00~15:00</div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="monday6" type="checkbox" id="monday6" value="64">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="tuesday6" type="checkbox" id="tuesday6" value="64">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="wednesday6" type="checkbox" id="wednesday6" value="64">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="thursday6" type="checkbox" id="thursday6" value="64">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="friday6" type="checkbox" id="friday6" value="64">
              </div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">15:00~16:00</div></td>
            <td width="75"><div align="center"> 
                <input name="monday7" type="checkbox" id="monday7" value="32">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="tuesday7" type="checkbox" id="tuesday7" value="32">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="wednesday7" type="checkbox" id="wednesday7" value="32">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="thursday7" type="checkbox" id="thursday7" value="32">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="friday7" type="checkbox" id="friday7" value="32">
              </div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">16:00~17:00</div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="monday8" type="checkbox" id="monday8" value="16">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="tuesday8" type="checkbox" id="tuesday8" value="16">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="wednesday8" type="checkbox" id="wednesday8" value="16">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="thursday8" type="checkbox" id="thursday8" value="16">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="friday8" type="checkbox" id="friday8" value="16">
              </div></td>
          </tr>
        
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">17:00~18:00</div></td>
            <td width="75"><div align="center"> 
                <input name="monday9" type="checkbox" id="monday9" value="8">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="tuesday9" type="checkbox" id="tuesday9" value="8">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="wednesday9" type="checkbox" id="wednesday9" value="8">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="thursday9" type="checkbox" id="thursday9" value="8">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="friday9" type="checkbox" id="friday9" value="8">
              </div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">18:00~19:00</div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="monday10" type="checkbox" id="monday10" value="4">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="tuesday10" type="checkbox" id="tuesday10" value="4">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="wednesday10" type="checkbox" id="wednesday10" value="4">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="thursday10" type="checkbox" id="thursday10" value="4">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="friday10" type="checkbox" id="friday10" value="4">
              </div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">19:00~20:00</div></td>
            <td width="75"><div align="center"> 
                <input name="monday11" type="checkbox" id="monday11" value="2">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="tuesday11" type="checkbox" id="tuesday11" value="2">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="wednesday11" type="checkbox" id="wednesday11" value="2">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="thursday11" type="checkbox" id="thursday11" value="2">
              </div></td>
            <td width="75" bgcolor="white"><div align="center"> 
                <input name="friday11" type="checkbox" id="friday11" value="2">
              </div></td>
          </tr>
          <tr bgcolor="white"> 
            <td bgcolor="#FFDEC8" class="content"><div align="center">20:00~21:00</div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="monday12" type="checkbox" id="monday12" value="1">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="tuesday12" type="checkbox" id="tuesday12" value="1">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="wednesday12" type="checkbox" id="wednesday12" value="1">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="thursday12" type="checkbox" id="thursday12" value="1">
              </div></td>
            <td width="75" bgcolor="#FFECCE"><div align="center"> 
                <input name="friday12" type="checkbox" id="friday12" value="1">
              </div></td>
          </tr>
        </table>    </td>
  </tr>
  <tr>
    <td>      <div align="center">
        <input type="submit" name="Submit" value="Add">
        <span class="title">[<a href="show_management.php" class="title">Back</a>]</span></div></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}
?>