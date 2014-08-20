<?php

/**
 * Places
 * Directory of Businesses, Places of Interests and Private Locations
 *
 * @package hypeJunction
 * @subpackage Places
 *
 * @author Ismayil Khayredinov <ismayil.khayredinov@gmail.com>
 */

namespace hypeJunction\Places;

const PLUGIN_ID = 'hypePlaces';
const PAGEHANDLER = 'places';

require_once __DIR__ . '/vendors/autoload.php';

require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/lib/events.php';
require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/page_handlers.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');
elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\pagesetup');
elgg_register_event_handler('upgrade', 'system', __NAMESPACE__ . '\\upgrade');

function init() {

	/**
	 * Handle pages and URLs
	 */
	elgg_register_page_handler(PAGEHANDLER, __NAMESPACE__ . '\\page_handler');
	elgg_register_entity_url_handler('object', 'hjplace', __NAMESPACE__ . '\\url_handler');

	/**
	 * Add places to search
	 */
	elgg_register_entity_type('object', 'hjplace');
	elgg_register_tag_metadata_name('specialties');

	/**
	 * JS, CSS and Views
	 */
	elgg_extend_view('css/elgg', 'css/framework/places/css');

	// Load fonts
	elgg_register_css('fonts.font-awesome', '/mod/' . PLUGIN_ID . '/vendors/fonts/font-awesome.css');
	elgg_load_css('fonts.font-awesome');
	elgg_register_css('fonts.open-sans', '/mod/' . PLUGIN_ID . '/vendors/fonts/open-sans.css');
	elgg_load_css('fonts.open-sans');

	elgg_extend_view('js/elgg', 'js/framework/places/interface');

	/**
	 * Register actions
	 */
	$actions_path = __DIR__ . '/actions/';
	elgg_register_action('places/edit', $actions_path . 'places/edit.php');
	elgg_register_action('places/delete', $actions_path . 'places/delete.php');
	elgg_register_action('places/feature', $actions_path . 'places/feature.php', 'admin');
	elgg_register_action('places/unfeature', $actions_path . 'places/unfeature.php', 'admin');
	elgg_register_action('places/bookmark', $actions_path . 'places/bookmark.php');
	elgg_register_action('places/unbookmark', $actions_path . 'places/unbookmark.php');
	elgg_register_action('places/checkin', $actions_path . 'places/checkin.php');
	elgg_register_action('places/checkout', $actions_path . 'places/checkout.php');

	/**
	 * Register hooks
	 */
	elgg_register_plugin_hook_handler('permissions_check', 'widget_layout', __NAMESPACE__ . '\\widget_layout_permissions_check');

	elgg_register_plugin_hook_handler('register', 'menu:entity', __NAMESPACE__ . '\\entity_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:entity', __NAMESPACE__ . '\\interactions_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', __NAMESPACE__ . '\\owner_block_menu_setup');

	elgg_register_widget_type('places', elgg_echo('places'), elgg_echo('places:widget:description'));

	elgg_register_plugin_hook_handler('search:site', 'maps', __NAMESPACE__ . '\\setup_site_search_maps');
	
	// Icons
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', __NAMESPACE__ . '\\entity_icon_url');
	elgg_register_plugin_hook_handler('entity:icon:sizes', 'object', __NAMESPACE__ . '\\entity_icon_sizes');

	// Add group option
	if (HYPEMAPS_GROUP_PLACES) {
		add_group_tool_option('places', elgg_echo('places:groupoption:enable'), true);
		elgg_extend_view('groups/tool_latest', 'framework/places/group_module');
	}

	elgg_register_widget_type('places_about', elgg_echo('places:widgets:about'), elgg_echo('places:widgets:about:desc'), 'places');
	elgg_register_widget_type('places_activity', elgg_echo('places:widgets:activity'), elgg_echo('places:widgets:activity:desc'), 'places');
	
}