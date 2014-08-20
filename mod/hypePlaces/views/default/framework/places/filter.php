<?php

namespace hypeJunction\Places;

$filter_context = elgg_extract('filter_context', $vars, 'all');

$tabs = array(
//	'featured' => array(
//		'name' => 'featured',
//		'text' => elgg_echo('places:filter:featured'),
//		'href' => PAGEHANDLER . '/featured',
//		'selected' => ($filter_context == 'featured'),
//		'priority' => 100
//	),
	'all' => array(
		'name' => 'all',
		'text' => elgg_echo('places:filter:all'),
		'href' => PAGEHANDLER . '/all',
		'selected' => ($filter_context == 'all'),
		'priority' => 200
	),
);

if (elgg_is_logged_in()) {
	$page_owner = elgg_get_page_owner_entity();
	$user = elgg_get_logged_in_user_entity();
	$tabs['owner'] = array(
		'name' => 'owner',
		'text' => elgg_echo('places:filter:mine'),
		'href' => PAGEHANDLER . '/owner/' . $user->username,
		'selected' => ($filter_context == 'owner' && $page_owner->guid == $user->guid),
		'priority' => 300
	);
	$tabs['bookmarks'] = array(
		'name' => 'bookmarked',
		'text' => elgg_echo('places:filter:bookmarked'),
		'href' => PAGEHANDLER . '/bookmarked/' . $user->username,
		'selected' => ($filter_context == 'bookmarked' && $page_owner->guid == $user->guid),
		'priority' => 400
	);
}

if (elgg_is_active_plugin('hypeMaps')) {
	$tabs['search'] = array(
		'name' => 'search',
		'text' => elgg_echo('places:search'),
		'href' => 'maps/search/places',
		'priority' => 900
	);
}

foreach ($tabs as $tab) {
	elgg_register_menu_item('filter:places', $tab);
}

echo elgg_view_menu('filter:places', array(
	'sort_by' => 'priority',
	'class' => 'elgg-menu-filter'
));
