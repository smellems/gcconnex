<?php

/**
 * Main activity stream list page
 */
$options = array();

$page_type = preg_replace('[\W]', '', $vars['page_type']);
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));

$id = sanitize_int($vars['guid']);

//sanity check
if (!is_numeric($id)) {
	register_error(elgg_echo('activity_tabs:invalid:id'));
	forward('activity', 'activity_tabs_invalid_id');
}

$selector = "type=$type";

if ($type != 'all') {
	$options['type'] = $type;
	if ($subtype) {
		$options['subtype'] = $subtype;
	}
}

$title = elgg_echo('activity_tabs:collection');
$page_filter = 'activity_tab';

$members = get_members_of_access_collection($id, true);

$options['subject_guids'] = $members;

$options['no_results'] = elgg_echo('river:none');
$activity = elgg_list_river($options);

$content = elgg_view('core/river/filter', array('selector' => $selector));

$sidebar = elgg_view('core/river/sidebar');

$params = array(
	'content' => $content . $activity,
	'sidebar' => $sidebar,
	'filter_context' => $page_filter,
	'class' => 'elgg-river-layout',
);

$body = elgg_view_layout('content', $params);
