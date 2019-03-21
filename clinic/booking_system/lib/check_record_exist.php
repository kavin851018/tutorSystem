<?php
// This function is used to check if the specific record has existed.
/*
Input:
	table: the specific table which will be checked.
	column: the specific column which will be checked.
	data: a data which will be used to check if it has existed in this table.
	conn: database connection.
Output:
	boolean: true(exist) or false(doesn't exist)
*/
function check_record_exist($table, $column, $data, $conn)
{
	$sql = "Select Count(*) From $table Where $column='$data'";
	$result = mysql_query($sql, $conn);
	$row = mysql_fetch_row($result);
	if( $row[0] == 0 )
		return false;
	else
		return true;
}
?>