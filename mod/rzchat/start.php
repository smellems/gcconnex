<?php
/**
 * @version 1.0
 * @copyright Copyright (C) 2014 rayzzz.com. All rights reserved.
 * @license GNU/GPL2, see LICENSE.txt
 * @website http://rayzzz.com
 * @twitter @rayzzzcom
 * @email rayzexpert@gmail.com
 */

function rzchat_init() {
	$sModule = "rzchat";
	elgg_register_page_handler($sModule, $sModule . '_page_handler');
	$item = new ElggMenuItem($sModule, elgg_echo($sModule), $sModule);
	elgg_register_menu_item('site', $item);
	
	elgg_register_menu_item('topbar', array(
			'name' => $sModule,
			'href' => $sModule . "/",
			'title' => elgg_echo($sModule),
			'priority' => 600,
	));
	
	elgg_register_js($sModule, elgg_get_site_url() . "mod/" . $sModule . "/js/swfobject.js");
}

function rzchat_page_handler($page) {
	$sModule = "rzchat";
	$params = array(
		'content' => elgg_view('main'),
		'title' => elgg_echo($sModule),
		'sidebar' => "",
		'filter_override' => "",
	);
	elgg_load_js($sModule);
	$body = elgg_view_layout('content', $params);
	echo elgg_view_page(elgg_echo($sModule), $body);
	
	return true;
}
	
elgg_register_event_handler('init', 'system', 'rzchat_init');
?>