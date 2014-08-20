<?php

// grab the message from the database!




$english = array(

	'notice:message' => 'Et eos offendit dissentias, ut partem nemore vituperatoribus eum. Quo ex ridens adipiscing, omnesque torquatos ad sit. Assum nihil invidunt te mea. Est purto intellegam cu, ei eos eirmod veritus. Eos dicat noluisse accusata ei, ad has atqui debitis.',

);			
add_translation('en', $english);


function getMsg()
{
	global $CONFIG;

	$result = '';

	$c_connex = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, 'c_mdb');

	$sql = 'SELECT * FROM ';

	//mysqli_query($c_connex, $sql);

	mysqli_close($c_connex);

	return $result;
}

?>