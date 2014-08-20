<?php
/*
*	The sorted display page
*	Drop-down with sort options passed in the array from the main view
*/
// array of things we can / will sort by
$sort_types = array(
'name-a'	=>	'name asc',

);
	$out = "";
	
	$sort_use = $vars['sorts'];

	$out .= "Sort Dropdown <br />";
	
	return $out;
?>