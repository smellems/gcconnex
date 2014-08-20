<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
	// Load Elgg engine
	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";
 
	$connection = mysql_connect("localhost","root","gcped!a");
	mysql_select_db("elggprod2", $connection);


	if (!$connection) 
	{
		fwrite($log, "cache error: unable to connect to database server\r\n" );
		exit;
	}


	$query = "SELECT * FROM language_management";
	$result = mysql_query($query); 
	if (!$result)
	{
		fwrite($log, "\r\n\r\nThere was an error to the SELECT query - " . mysql_error() . "\r\n\r\n");
	}

	$language_storage = "";
	
	while ($row = mysql_fetch_array($result))
	{
		$language_storage .= $row['English'] . "\r\n\r\n";
	}

	echo "<textarea name='display_language' cols='100' rows='50'>" . $language_storage . "</textarea><br />";	

	mysqli_close($connection);
?>