<?php

namespace hypeJunction\places;

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity) {
	register_error(elgg_echo('places:error:not_found'));
	forward(REFERER);
}

if (check_entity_relationship(elgg_get_logged_in_user_guid(), 'bookmarked', $guid)) {
	remove_entity_relationship(elgg_get_logged_in_user_guid(), 'bookmarked', $guid);

	elgg_delete_river(array(
		'action_type' => 'stream:places:bookmark',
		'subject_guid' => elgg_get_logged_in_user_guid(),
		'object_guid' => $entity->guid
	));

	system_message(elgg_echo('places:bookmark:remove:success'));
	forward(REFERER);
}

register_error(elgg_echo('places:bookmark:remove:error'));
forward(REFERER);