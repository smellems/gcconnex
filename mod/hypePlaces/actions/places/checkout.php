<?php

namespace hypeJunction\Places;

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof Place) {
	register_error(elgg_echo('places:error:not_found'));
	forward(REFERER);
}

if ($entity->isCheckedIn()) {

	$checkins = elgg_get_annotations(array(
		'guids' => $entity->guid,
		'annotation_owner_guids' => elgg_get_logged_in_user_guid(),
		'annotation_names' => 'checkin',
		'annotation_created_time_lower' => time() - $entity->getCheckinDuration(),
	));

	foreach ($checkins as $ci) {
		$ci->delete();
	}
	
	system_message(elgg_echo('places:checkout:success', array($entity->title)));
	forward(REFERER);
}

register_error(elgg_echo('places:checkout:error', array($entity->title)));
forward(REFERER);
