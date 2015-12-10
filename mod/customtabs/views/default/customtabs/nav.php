<?php
/**
	 * Elgg Custom Tabs plugin
	 *
	 * @package Elgg Custom Tabs
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Alex Falk, RiverVanRain
	 * @URL http://o.wzm.me/crewz/p/1983/personal-net
	 * @copyright (c) organiZm 2k13
	 */

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
		'url' => "customtabs/tab3",
		'selected' => $vars['selected'] == 'tab3',
	),
);

echo elgg_view('navigation/tabs', array('tabs' => $tabs));
