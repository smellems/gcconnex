<?php

$user = elgg_get_logged_in_user_entity();

$filter_context = elgg_extract('filter_context', $vars, 'all');

$context = elgg_get_context();

$all_href = (isset($vars['all_link'])) ? $vars['all_link'] : "phloor_body_background/all";
$url_prefix = "";
if($context == 'admin') {
	$all_href = "$context/appearance/phloor_body_background/all";
	$url_prefix .= "admin/appearance/";
}
// generate a list of default tabs
$tabs = array(
    // none by default
);

if(elgg_is_admin_logged_in()) {
	$tabs['site'] = array(
		'text' => elgg_echo('site'),
		'href' => "phloor_body_background/site",
		'selected' => ($filter_context == 'site'),
		'priority' => 1,
	);
}

$tabs['all'] = array(
	'text' => elgg_echo('all'),
	'href' => $all_href,
	'selected' => ($filter_context == '' || $filter_context == 'all'),
	'priority' => 2,
);

if(elgg_is_logged_in()) {
	$tabs['mine'] = array(
		'text' => elgg_echo('mine'),
		'href' => $url_prefix . "phloor_body_background/owner/{$user->username}",
		'selected' => ($filter_context == 'mine'),
		'priority' => 3,
	);
}

foreach ($tabs as $name => $tab) {
	$tab['name'] = $name;
	elgg_register_menu_item('filter', $tab);
}

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

