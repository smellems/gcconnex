<?php

$tabs = array(
	'tab1' => array(
		'title' => elgg_echo('customtabs:tab1'),
		'url' => "customtabs/tab1",
		'selected' => $vars['selected'] == 'tab1',
	),
	'tab2' => array(
		'title' => elgg_echo('customtabs:tab2'),
		'url' => "customtabs/tab2",
		'selected' => $vars['selected'] == 'tab2',
	),
	'tab3' => array(
		'title' => elgg_echo('customtabs:tab3'),
		'url' => "ml",
		'selected' => $vars['selected'] == 'tab3',
	),
);

echo elgg_view('navigation/tabs', array('tabs' => $tabs));