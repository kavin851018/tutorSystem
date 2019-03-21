<?php
/*
This function is used to find out the time of the last posted topic which is a child topic of the specific topic.
Input:
	$parent: (String) The parent which will be used to find the last topic
	$conn: (resource) database connection.
Output:
	$row: (array) The row of the last post topic.
*/
function find_last_post_topic($parent, $conn)
{
	// Select out all child topic of this parent.
	$sql = "Select * From forum Where parent='$parent'";
	$result_child = mysql_query($sql, $conn) or die(mysql_error());
	$n = mysql_num_rows($result_child);
	
	// If this topic has childs, recursively find the last post topic.
	if( $n )
	{
		// Select out the last time which is the child of this parent
		$sql = "Select MAX(post_time) From forum Where parent='$parent'";
		$result_max_time = mysql_query($sql, $conn) or die(mysql_error());
		$max = mysql_fetch_row($result_max_time);
		
		// Select out the topic which is last posted.
		$sql = "Select MAX(post_time) From forum Where parent='$parent'";
		$result_max = mysql_query($sql, $conn) or die(mysql_error());
		$max_row = mysql_fetch_array($result_max);
		
		while( $row = mysql_fetch_array($result_child) )
		{
			$return_row = find_last_post_topic($row['id'], $conn);
			if( $return_row['post_time'] > $max[0] )
			{
				$max[0] = $return_row['post_time'];
				unset($max_row);
				$max_row = $return_row;
			}
		}
		
		return $max_row;
	}
	else // This topic has no child, just return itself.
	{
		$sql = "Select * From forum Where id='$parent'";
		$result = mysql_query($sql, $conn) or die(mysql_error());
		$row = mysql_fetch_array($result);
		return $row;
	}
}
?>