<?php

namespace hypeJunction\Places;

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof Place) {
	register_error(elgg_echo('places:error:not_found'));
	forward(REFERER);
}

if (!$entity->isCheckedIn()) {
	if ($id = $entity->checkIn()) {
		add_to_river('framework/river/places/checkin', 'stream:places:checkin', elgg_get_logged_in_user_guid(), $entity->guid, $entity->access_id, time(), $id);
		system_message(elgg_echo('places:checkin:success', array($entity->title)));
		forward(REFERER);
	}
}

register_error(elgg_echo('places:checkin:error', array($entity->title)));
forward(REFERER);
