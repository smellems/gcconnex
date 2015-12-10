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

function customtabs_init() {
global $CONFIG;
elgg_register_page_handler('customtabs','customtabs_page_handler');
				
			// Add menu link
$item = new ElggMenuItem('customtabs', elgg_echo('customtabs'), 'customtabs');
elgg_register_menu_item('site', $item);

if(!elgg_in_context('admin')){
elgg_register_menu_item('page', array(
			'section' => 'customtabs',
			'name' => 'customtabs',
			'text' => elgg_echo('customtabs'),
			'title' => elgg_echo('customtabs'),
			'href' => "/customtabs",
		//	'contexts' => array('activity'),
			'link_class' => 	'elgg-state-selected',
			'priority' => 100,
			));				
	}
}

function customtabs_page_handler($page) {
	$base = elgg_get_plugins_path() . 'customtabs';

	if (!isset($page[0])) {
		$page[0] = 'tab1';
	}

	$vars = array();
	$vars['page'] = $page[0];


require_once "$base/index.php";
	
return true;
}
	
elgg_register_event_handler('init', 'system', 'customtabs_init');
?>
