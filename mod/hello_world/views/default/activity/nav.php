<?php
/**
 * Members navigation
 */

// cyu - modified 02-13-2015: overwrites the existing view to include the navigation option tab in members page
$tabs = array(
    'all' => array(
		'title' => elgg_echo('activity:label:all'),
		'url' => "activity/all",
		'selected' => $vars['selected'] == 'all',
	),
	'mine' => array(
		'title' => elgg_echo('activity:label:mine'),
		'url' => "activity/mine",
		'selected' => $vars['selected'] == 'mine',
	),
	'friends' => array(
		'title' => elgg_echo('activity:label:friends'),
		'url' => "activity/friends",
		'selected' => $vars['selected'] == 'friends',
	),
	
	'myDepartment' => array(
		'title' => elgg_echo('c_bin:myDepartment'),
		'url' => "activity/myDepartment",
		'selected' => $vars['selected'] == 'myDepartment',
	),
);

echo elgg_view('navigation/tabs', array('tabs' => $tabs));
