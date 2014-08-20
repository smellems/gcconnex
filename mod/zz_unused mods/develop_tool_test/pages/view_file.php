<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
	// Load Elgg engine
	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";
 

	// check if developer submitted code
	if (isset($_REQUEST['button_submit']))
	{
		$plugin_name = $_GET["plugin"];
		$plugin_lang = $_GET["lang"];
		$plugin_lang_file = $_POST["display_language"];

		write_changes_to_file($plugin_name, $plugin_lang, $plugin_lang_file);

		window.close();
	}

	$connection = mysql_connect("localhost","root","gcped!a");
	mysql_select_db("elggprod2", $connection);


	if (!$connection) 
	{
		fwrite($log, "cache error: unable to connect to database server\r\n" );
		exit;
	}

	$plugin_name = $_GET["plugin"];
	$plugin_lang = $_GET["lang"];

	$query = "SELECT * FROM language_management WHERE PluginName = '" . $plugin_name . "'";
	$result = mysql_query($query); 
	if (!$result)
	{
		fwrite($log, "\r\n\r\nThere was an error to the SELECT query - " . mysql_error() . "\r\n\r\n");
	}

	$language_storage = "";
	
	//while ($row = mysql_fetch_array($result))
	//{
	//	$language_storage .= $row['English'] . "\r\n\r\n";
	//}

	/* PLUGIN NAME | ENGLISH | FRENCH | ETC */

	$row = mysql_fetch_row($result);

	if ($plugin_lang === 'English')
	{
		$language_storage = $row[1];
	}
		else 
			if ($plugin_lang === 'French')
			{
				$language_storage = $row[3];
			}

	echo "<form name='form1' method='post'>";
	//echo "<br>Developer: <input type='text' name='developer'><br><br>";
	//echo "<br>developer: <b><u>" . get_loggedin_user()->username . "</u></b><br><br>";
	echo "<textarea name='display_language' cols='100' rows='50'>" . $language_storage . "</textarea><br />";
	echo "<br />";

	echo "<input type='submit' name='button_submit' value='SAVE CHANGES'>";
	echo "</form>";

	// put notification alert box here
	mysqli_close($connection);
?>

