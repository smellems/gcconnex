<?php

namespace hypeJunction\Places;

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity) {
	register_error(elgg_echo('places:error:not_found'));
	forward(REFERER);
}

if (!check_entity_relationship(elgg_get_logged_in_user_guid(), 'bookmarked', $guid)) {
	add_entity_relationship(elgg_get_logged_in_user_guid(), 'bookmarked', $guid);
	add_to_river('framework/river/places/bookmark', 'stream:places:bookmark', elgg_get_logged_in_user_guid(), $entity->guid, $entity->access_id, time());
	system_message(elgg_echo('places:bookmark:create:success'));
	forward(REFERER);
}

register_error(elgg_echo('places:bookmark:create:error'));
forward(REFERER);