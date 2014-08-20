<?php

// CSS FORMATTING
echo "<style type='text/css'>";

echo "table.db-table      { border-right:1px solid #ccc; border-bottom:1px solid #ccc; }";
echo "table.db-table th   { background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }";
echo "table.db-table td   { padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }";

echo "</style>";

?>

<script type="text/javascript">
// JAVASCRIPT

function newPopUp(url)
{
	var popupWindow = window.open(
		url, 
		'popupWindow', 
		'height=900, width=900, left=10, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes')

	var timer = setInterval(function()
	{
		if (popupWindow.closed)
		{
			clearInterval(timer);
			//alert('closed');
			location.reload();
		}
	}, 30);
}

</script>

<?php

echo "<table cellpadding='0' cellspacing='0' class='db-table'>";
// NOTE: SOME HEADINGS ARE DISABLED
echo '<tr> <th>Plugin</th> <th>English</th> <th>English File</th> <th>French</th> <th>French File</th> <th>Translation Status</th> <th>Author</th> <th>Last Modified by & Time</th> <!--<th>Note</th>--> </tr>';

//$plugin_name = array();
// contains all data about language files
$plugin_db = get_plugins_database();

//for($tr = 0; $tr < $rows; $tr++)
$plugin_count = 0;
while ($row = mysql_fetch_array($plugin_db))
{ 
	$plugin_count++;

	// variables that will store the plugin information that will be passed to new page and data that will populate the table
	$pass_plugin_name = $row['PluginName'];
	$file_en_time = $row['English_Modified_Time'];
	$file_fr_time = $row['French_Modified_Time'];
	$file_filetype = $row['Plugin_Author'];
	$file_translation = $row['Translated'];
	$file_modified_by = $row['Plugin_Info'];

	//plugin|english|english file|french|french file|translation status|filetype
	echo "<tr>"; 
	echo "<td>" . $plugin_count . ". " . $pass_plugin_name . "</td>";
	echo "<td> <a href=\"Javascript:newPopUp('http://192.168.0.100/elgg-prod2/mod/develop_tool_test/pages/view_file.php?plugin=" . $pass_plugin_name . "&lang=English');\"> ENGLISH </a></td>";
	echo "<td>" . $file_en_time . "</td>";
	echo "<td> <a href=\"Javascript:newPopUp('http://192.168.0.100/elgg-prod2/mod/develop_tool_test/pages/view_file.php?plugin=" . $pass_plugin_name . "&lang=French');\"> FRENCH </a></td>"; 
	echo "<td>" . $file_fr_time . "</td>";
	echo "<td>" . $file_translation . "</td>"; 
	echo "<td>" . $file_filetype . "</td>";
	echo "<td>" . $file_modified_by . "</td>";
	echo "</tr>"; 
} 
 
echo "</table>"; 

echo "<div>";
echo "<br>";

?>

<a href="Javascript:newPopUp('http://192.168.0.100/elgg-prod2/mod/develop_tool_test/pages/view_all_files.php');">View Master Language File</a>

<?php
echo "</div>";



// extra space
echo "<br>";

