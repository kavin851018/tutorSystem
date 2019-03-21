<?php
// $title
// $mes
// $title_color
// $title_bgcolor
// $title_size
// $border_color
// $body_bgcolor
// $body_fcolor
// $body_fsize
// $width
// $b_content
// $b_link

echo "<table width=$width bgcolor=$border_color border=0 cellspacing=1 cellpadding=3 align=center>";
echo "<tr bgcolor=$title_bgcolor align=center><td><font color=$title_color size=$title_size>$title</font></td></tr>";
echo "<tr bgcolor=$body_bgcolor><td><font color=$body_fcolor size=$body_fsize>$mes";
echo "<br><br><div align=center>[<a href=$b_link>$b_content</a>]</div></font></td></tr>";
echo "</table>";
?>
