<?php
/*
This function is used to insert a record into a specific table. User does not care about the consistency between the input data and 
the format of the specific table. All un-match column will be set as ''(none).

Input:
	table(string): 	the specific table which will be inserted record
	rec(object): 	the insert record.
	conn(resource): database connection.

Output:
	boolean: true(successful) or false(falied)
*/
function insert_record($table, $rec, $conn)
{
	$sql = "Show Columns From $table";
	$result = mysql_query($sql, $conn);
	$sql = "Insert Into $table Values(";
	$num_row = 0;
	
	$record = get_object_vars($rec);
	$column = array_keys($record);
	$n = count($column);

	while( $row = mysql_fetch_assoc($result) )
	{
		$column_find = false;
		// Check if any data will be inserted into this column.
		for( $i=0; $i<$n; $i++)
		{
			if( $column[$i] == $row['Field'] )
			{
				$column_find = true;
				break;
			}
		}
		
		if( $column_find )
			$value = $record[$column[$i]];
		else
		{
			// check if the column type is datetime, set its default value as 0000-00-00 00:00:00.
			if( $row['Type'] == "datetime" )
				$value = "0000-00-00 00:00:00";
			else
				$value = "";
		}
		
		if( $num_row != 0)
			$c1 = ",";
		else
			$c1 = "";
		
		// check if the column is password.
		if( $row['Field'] == "password" )
		{
			$c2_1 = "PASSWORD(";
			$c2_2 = ")";
		}
		else
		{
			$c2_1 = "";
			$c2_2 = "";
		}


		// check the type. If type is int, do not concatenate '.
		if( substr($row['Type'], 0, 3) == "int" )
			$c3 = "";
		else
			$c3 = "'";

		$sql .= $c1 . $c2_1 . $c3 . $value . $c3 . $c2_2;
		$num_row++;
	}
	
	$sql .= ")";
//	echo $sql . "<br>";
	mysql_query($sql, $conn) or die(mysql_error());
	mysql_free_result($result);
}
?>