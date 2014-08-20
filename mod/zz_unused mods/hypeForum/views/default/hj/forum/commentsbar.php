<?php
$entity = elgg_extract('entity', $vars, false);
$offset = get_input('offset', 0);
$limit = get_input('limit', 10);

if (!elgg_instanceof($entity, 'object', 'hjforumtopic')) {
	return true;
}

$container_guid = $entity->guid;
$selector_id = $guid;

$options = array(
	'type' => 'object',
	'subtype' => 'hjannotation',
	'owner_guid' => null,
	'container_guid' => $container_guid,
	'metadata_name_value_pairs' => array(
		array('name' => 'annotation_name', 'value' => 'hjforumpost'),
		array('name' => 'annotation_value', 'value' => '', 'operand' => '!='),
	),
	'count' => true,
	'limit' => 0
);

$count = elgg_get_entities_from_metadata($options);
$options['count'] = false;

$posts = elgg_get_entities_from_metadata($options);
$posts_view = elgg_view_entity_list($posts, array(
	'list_id' => "hj-annotations-$entity->guid",
	'list_class' => "hj-annotation-forum-posts",
	'full_view' => true,
	'pagination' => false
));

if (elgg_is_logged_in()) {
	$comments_input = elgg_view('hj/forum/postinput', $vars);
}

echo $posts_view;
echo $comments_input;