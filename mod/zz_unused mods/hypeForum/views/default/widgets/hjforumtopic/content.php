<?php

/**
 * View Forum Widget Contents
 * @return string HTML
 */
$widget = elgg_extract('entity', $vars, false);

if (!$widget) {
	return true;
}

$segment = $widget->getContainerEntity();
$section = $vars['entity']->section;

if (!$limit = $vars['entity']->num_display)
	$limit = 5;

$sticky = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'hjforumtopic',
	'metadata_name_value_pairs' => array(
		array('name' => 'widget', 'value' => $widget->guid),
		array('name' => 'sticky', 'value' => 'true')
	),
	'limit' => 0,
	'order_by' => 'e.time_created asc'
		));

$target = "hj-list-$segment->guid-$widget->guid-$section";

$db_prefix = elgg_get_config('dbprefix');
$params = array(
	'type' => 'object',
	'subtype' => 'hjforumtopic',
	'metadata_name_value_pairs' => array(
		array('name' => 'widget', 'value' => $widget->guid),
		array('name' => 'sticky', 'value' => 'false')
	),
	'limit' => 5,
	'order_by' => 'e.last_action desc'
);

$params['count'] = true;
$content_count = elgg_get_entities_from_metadata($params) + sizeof($sticky);
$params['count'] = false;

$data_options = array(
	'widget_guid' => $widget->guid
);

$view_params = array(
	'full_view' => false,
	'list_id' => $target,
	'list_class' => 'hj-view-list',
	'item_class' => 'hj-view-entity elgg-state-draggable hj-forum-topics-list',
	'pagination' => true,
	'data-options' => htmlentities(json_encode($data_options), ENT_QUOTES, 'UTF-8'),
	'limit' => $limit,
	'count' => $content_count,
	'base_url' => 'forum/sync'
);

$content = elgg_get_entities_from_metadata($params);

$content = elgg_view_entity_list(array_merge($sticky, $content), $view_params);

unset($view_params['data-options']);

$form = hj_framework_get_data_pattern('object', $section);

$params = array(
	'subtype' => $section,
	'form_guid' => $form->guid,
	'container_guid' => $segment->container_guid,
	'segment_guid' => $segment->guid,
	'widget_guid' => $widget->guid,
	'owner_guid' => elgg_get_logged_in_user_guid(),
	'context' => 'forum',
	'handler' => 'hjforumtopic',
	'target' => $target,
	'fbox_x' => '800',
	'dom_order' => 'append'
);

$params = array_merge($view_params, $params);
$params = hj_framework_extract_params_from_params($params);

$headers = elgg_view('hj/forum/headers', $params);

$footer_menu = elgg_view_menu('hjsectionfoot', array(
	'handler' => 'hjsection',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz hj-menu-hz hj-forum-topic-menu',
	'params' => $params
		));

//if (sizeof($content_array) > 0) {
//    echo $headers;
//} else {
//    echo elgg_echo('hj:forum:noforumtopics');
//}
echo $headers;
echo $content;
echo $footer_menu;