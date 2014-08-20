<?php
/**
 *	PHP part of the AJAX
*/

$f = $_GET["AJAXfunc"];
$q = $_GET["args"];

if ( $f != null && $f != '' )
{
	require_once( elgg_get_plugins_path() . 'gcAJAX/includes.php' );
	processAJAX( $f, $q );
}

function processAJAX ( $f, $q ){
	global $AJAXfunctions;
	//$AJAXfunctions[count($AJAXfunctions)] = 'regAJAX';
	$out = '';
	
	if ( in_array( $f, $AJAXfunctions ) ){
		$args = $q;//array('admin@tbs-sct.gc.ca', '123', 'test');
		$out = call_user_func_array( $f, $args );
		//regAJAX( $args );
		
	//echo '*TESTING* ==> ' . $args[0];
	}
	else
		echo 'Test: ' . $f . ' != ' . $AJAXfunctions[0];
		
	return out;
}

return '';

?>