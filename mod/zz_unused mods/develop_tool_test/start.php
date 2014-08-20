<?php
/*
 *
 * Elgg develop tool test
 *
 * @package develop_tool_test
 * @author Christine Yu
 *
 */ 

elgg_register_event_handler('init','system','develop_tool_test_init'); 

function develop_tool_test_init()
{ 

	// debugging purpose (logging)
	$log = fopen(dirname( __FILE__ ) . "/Log.txt", 'w');
	fwrite($log, "start logging - develop_tool_test" . "\r\n" );

	elgg_register_page_handler('develop_tool_test', 'develop_tool_test_page_handler');

	// database connection
	global $CONFIG;
	fwrite($log, "Connecting to Database... \r\n");

	$connection = mysql_connect("localhost","root","gcped!a");
	mysql_select_db("elggprod2", $connection);


	if (!$connection) 
	{
		fwrite($log, "cache error: unable to connect to database server\r\n" );
		exit;
	}

	// create a table
	fwrite($log, "Creating Table...\r\n" );
		
	$query = "CREATE TABLE language_management (PluginName VARCHAR(255) NOT NULL, PRIMARY KEY(PluginName), 
		English MEDIUMTEXT, English_Modified_Time VARCHAR(50), French MEDIUMTEXT, French_Modified_Time VARCHAR(50), 
		Plugin_Author VARCHAR(50), Plugin_Filepath VARCHAR(255), Plugin_Info VARCHAR(255), Translated INT NOT NULL)";

	$result = mysql_query($query); 
	if (!$result)
	{
		fwrite($log, "\r\n\r\nThere was an error to the CREATE query - " . mysql_error() . "\r\n\r\n");
	}

	// run query
	mysql_query($query); 

	// go to the root directory of mod to scan list of folders
	$elgg_root = strstr(dirname(__FILE__), 'mod', true);
	fwrite($log, "elgg root: " . $elgg_root . "\r\n" );

	$mod_directory = $elgg_root . "mod";
	fwrite($log, "mod directory: " . $mod_directory . "\r\n" );

	$en = " ";
	$fr = " ";

	// read directory contents
	if ($handle = opendir($mod_directory))
	{
		while (false !== ($file = readdir($handle)))
		{
			fwrite($log, "checking... " . $file . " in " . $mod_directory . "/" . $file . "\r\n" );

			if ($file != '.' && $file != '..' && is_dir($mod_directory . "/" . $file))
			{

				fwrite($log, "found! - folder: " . $file . "\r\n" );
				// save directory of the mod
				$plugin_path = $mod_directory . "/" . $file;

				// determine whether it's customized, core, community (CUSTOM|CORE|COMMUNITY)
				fwrite($log, "looking for... " . $plugin_path . "/manifest.xml" . "\r\n" );
				if (!file_exists($plugin_path . "/manifest.xml"))
				{

					fwrite($log, "manifest is missing - " . $plugin_path . "/manifest.xml \r\n" );
					
				}
				// load xml file
				$xml=simplexml_load_file($plugin_path . '/manifest.xml');

				// extracting author
				fwrite($log, "extracting author... " . $xml->author . "\r\n" );

				$plugin_author =  $xml->author;

				$sub_directory = $mod_directory . "/" . $file . "/" . "languages";
				fwrite($log, "checking language folder... " . $sub_directory . "\r\n" );

				// check for language file
				if (file_exists($sub_directory) && $handle2 = opendir($sub_directory))
				{
					while (false !== ($file2 = readdir($handle2)))
					{
						if ($file2 != '.' && $file2 != '..' && ($file2 == 'en.php' || $file2 == 'fr.php'))
						{
							//fwrite($log, "file2: " . $file2 . " \r\n" );
							
							//fwrite($log, "file2: " . $file2 . " \r\n" );

							if ($file2 == 'en.php') 
							{ 
								//fwrite($log, "directory: " . $sub_directory  . "/" . $file2 . "\r\n");
								$en = file_get_contents($sub_directory . "/" . $file2);
								$en_date = date ("F d Y H:i:s.", filemtime($sub_directory . "/" . $file2));								
							}

							if ($file2 == 'fr.php')
							{
								//fwrite($log, "directory: " . $sub_directory . "/" .  $file2 . "\r\n");
								$fr = file_get_contents($sub_directory . "/" . $file2);
								$fr_date = date ("F d Y H:i:s.", filemtime($sub_directory . "/" . $file2));
							}
						}
					}
			
					closedir($handle2);
				}

				$en_filtered =  str_replace('"', '\'', $en);
				$fr_filtered =  str_replace('"', '\'', $fr);

				//$en_filtered =  str_replace('/', '^', $en_filtered);
				//$fr_filtered =  str_replace('/', '^', $fr_filtered);

				if ($en_filtered == " ")
				{
					$en_filtered = " NOT FOUND ";
				} 

				if ($fr_filtered == " ")
				{
					$fr_filtered = " NOT FOUND ";
				}


				$plugin_path =  str_replace('/', '^', $plugin_path);
				
				//$query = "INSERT INTO language_management VALUES ( '" . $file . "', \"" .   $en_filtered . "\", \""  . $fr_filtered . "\", 0)";
				//PLUGIN|ENGLISH|ENGLISHTIME|FRENCH|FRENCHTIME|TYPE|PATH|TRANSLATION
				$query = "INSERT INTO language_management VALUES ('" . $file . "', \"" .   $en_filtered . "\", '" . $en_date . "' ,
				 \""  . $fr_filtered . "\", '" . $fr_date . "', '" . $plugin_author . "', '" . $plugin_path . "', ' ', 0)";


				fwrite($log, "query - " . $query . "\r\n");
				$result = mysql_query($query); 
				
				if (!$result)
				{
					fwrite($log, "\r\n\r\nThere was an error to the INSERT query - " . mysql_error() . "\r\n\r\n");
				}
				
				// reset variable for next row
				$en_date = " ";
				$fr_date = " ";
				$en = " ";
				$fr = " ";
				$en_filtered = " ";
				$fr_filtered = " ";
			}
		}
		closedir($handle);
	}

	// close log file
	fwrite($log, "end logging - develop_tool_test" . "\r\n" );
	fclose($log);

	// close connection
	mysqli_close($connection);

}



function get_plugins_database()
{
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

	// close connection
	mysqli_close($connection);

	return $result;	
}




function write_changes_to_file($p_name, $p_lang, $p_file)
{
	// debugging purpose (logging)
	$log = fopen(dirname( __FILE__ ) . "/Log1.txt", 'w');
	fwrite($log, "start logging - develop_tool_test - WRITING - " . dirname( __FILE__ ) . "/Log1.txt" . "\r\n" );

	$connection = mysql_connect("localhost","root","gcped!a");
	mysql_select_db("elggprod2", $connection);

	if (!$connection) 
	{
		fwrite($log, "cache error: unable to connect to database server\r\n" );
		exit;
	}

	$query = "SELECT * FROM language_management WHERE PluginName= '" . $p_name . "'";
	$result = mysql_query($query); 
	if (!$result)
	{
		fwrite($log, "\r\n\r\nThere was an error to the SELECT query - " . mysql_error() . "\r\n\r\n");
	}

	$row = mysql_fetch_row($result);
	// set new timestamp
	$corrected_url =  str_replace('^', '/', $row[6]);
	fwrite($log, "\r\n\r\n" . "currently modifying..." . $p_name . "in ---> " . $corrected_url . "\r\n\r\n");

	if ($p_lang === 'English')
	{
		if (!file_exists($corrected_url . "/languages/en.php"))
		{
			fwrite($log, "\r\n\r\n LANGUAGE FILE DOESN'T EXIST? WHY?? - " . $corrected_url . "/languages/en.php" . "\r\n\r\n");
		} else {
			$modified_time = date ("F d Y H:i:s.", filemtime($corrected_url . "/languages/en.php"));
			$query = "UPDATE language_management SET Plugin_Info='". get_loggedin_user()->username . " & " . date("Y-m-d H:i:s",time())  . "', " . $p_lang . "=\"" . $p_file . "\" WHERE PluginName='" . $p_name . "'";
			fwrite($log, "\r\n\r\n asdasdasdsadsadasdas updating the modification time!" . "\r\n\r\n");
		}

	} else if ($p_lang === 'French') {
		if (!file_exists($corrected_url . "/languages/fr.php"))
		{
			fwrite($log, "\r\n\r\n LANGUAGE FILE DOESN'T EXIST? WHY??\r\n\r\n");
		} else {
			$modified_time = date ("F d Y H:i:s.", filemtime($corrected_url . "/languages/fr.php"));
			$query = "UPDATE language_management SET Plugin_Info='" . get_loggedin_user()->username . " & " . date("Y-m-d H:i:s",time()) . "', " . $p_lang . "=\"" . $p_file . "\" WHERE PluginName='" . $p_name . "'";
			fwrite($log, "\r\n\r\n asdsadasdsadasdsadsad updating the modification time!" . "\r\n\r\n");
		}
	}

	$result = mysql_query($query); 
	if (!$result)
	{
		fwrite($log, "\r\n\r\n asdf There was an error to the UPDATE query - " . mysql_error() . "\r\n\r\n");
	}

	$query = "SELECT * FROM language_management WHERE PluginName= '" . $p_name . "'";
	$result = mysql_query($query); 
	if (!$result)
	{
		fwrite($log, "\r\n\r\nThere was an error to the SELECT query - " . mysql_error() . "\r\n\r\n");
	}

	$row = mysql_fetch_row($result);

	$plugin_filepath = $row[6];

	// update file
	if ($p_lang === "English")
	{
		fwrite($log, "UPDATING FILE... ENGLISH LANGUAGE FILE IS BEING MODIFIED" . "\r\n" );
	}

	if ($p_lang === "French")
	{
		fwrite($log, "UPDATING FILE... FRENCH LANGUAGE FILE IS BEING MODIFIED" . "\r\n" );
	}

	$plugin_filepath = str_replace('^', '/', $plugin_filepath);


	if ($p_lang === "English")
	{
		//rename($plugin_filepath . '/languages/en.php', $plugin_filepath . '/languages/en.php.old');
		$plugin_filepath = $plugin_filepath . '/languages/en.php';

	}

	if ($p_lang === "French")
	{
		//rename($plugin_filepath . '/languages/fr.php', $plugin_filepath . '/languages/fr.php.old');
		$plugin_filepath = $plugin_filepath . '/languages/fr.php';
	}

	if (!file_exists($plugin_filepath))
	{
		echo "asdf ERROR: The file doesn't exist (filepath)";
	} else {

		//$shell = "perm_script.sh";
		//$cmd = shell_exec($shell);


		$modify_file = fopen($plugin_filepath, "w");


		fwrite($log, "modifying -----> " . $plugin_filepath . "\r\n" );
		fwrite($log, "==================" . "\r\n" );
		fwrite($log, "writing:  -----> " . $p_file . "\r\n" );
		fwrite($log, "==================" . "\r\n" );

		fwrite($modify_file, $p_file);
		fclose($modify_file);

		//chmod($plugin_filepath, 755);
	}


	mysqli_close($connection);
	
	// close log file
	fwrite($log, "end logging - develop_tool_test - WRITING" . "\r\n" );
	fclose($log);


	$connection = mysql_connect("localhost","root","gcped!a");
	mysql_select_db("elggprod2", $connection);

//============================================

if ($p_lang === 'English')
	{
		if (!file_exists($plugin_filepath))
		{
			fwrite($log, "\r\n\r\n LANGUAGE FILE DOESN'T EXIST? WHY?? - " . $corrected_url . "/languages/en.php" . "\r\n\r\n");
		} else {
			$modified_time = date ("F d Y H:i:s.", filemtime($plugin_filepath));
			$query = "UPDATE language_management SET English_Modified_Time='" . $modified_time . "' WHERE PluginName='" . $p_name . "'";
			fwrite($log, "\r\n\r\n language file --> " . $corrected_url . "/languages/en.php =====> " . $modified_time. "\r\n\r\n");
		}

	} else if ($p_lang === 'French') {
		if (!file_exists($corrected_url . "/languages/fr.php"))
		{
			fwrite($log, "\r\n\r\n LANGUAGE FILE DOESN'T EXIST? WHY??\r\n\r\n");
		} else {
			$modified_time = date ("F d Y H:i:s.", filemtime($plugin_filepath));
			$query = "UPDATE language_management SET French_Modified_Time='" . $modified_time . "' WHERE PluginName='" . $p_name . "'";
		}
	}

	$result = mysql_query($query); 
	if (!$result)
	{
		fwrite($log, "\r\n\r\n asdf There was an error to the UPDATE query - " . mysql_error() . "\r\n\r\n");
	}

	// ========================




	mysqli_close($connection);



	echo ">>>>>>>> DONE WRITING >>>>>>>>>>" . $plugin_filepath;
}