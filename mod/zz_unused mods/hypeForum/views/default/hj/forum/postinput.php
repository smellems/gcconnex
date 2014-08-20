<?php

$entity = elgg_extract('entity', $vars, false);

if (!$entity) {
	return true;
}

$form = hj_framework_get_data_pattern('object', 'hjannotation', 'hjforumpost');
$form->class = 'hj-forum-post-reply';

$reply_params = array(
	'target' => "hj-annotations-$entity->guid",
	'full_view' => true,
	'form_guid' => $form->guid,
	'owner_guid' => elgg_get_logged_in_user_guid(),
	'subtype' => 'hjannotation',
	'entity_guid' => null,
	'handler' => 'hjforumpost',
	'event' => 'create',
	'ajaxify' => false,
	'owner_guid' => elgg_get_logged_in_user_guid(),
	'container_guid' => $entity->guid
);

$reply_params = hj_framework_extract_params_from_params($reply_params);

echo elgg_view_entity($form, $reply_params);
