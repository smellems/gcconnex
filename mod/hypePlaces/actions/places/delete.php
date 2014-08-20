<?php

namespace hypeJunction\Places;

$guid = get_input('guid');
$entity = get_entity($guid);

$title = $entity->title;

if (($entity) && ($entity->canEdit())) {
	if ($entity->delete()) {
		system_message(elgg_echo('places:delete:success', array($title)));
	} else {
		register_error(elgg_echo('places:delete:error', array($title)));
	}
} else {
	register_error(elgg_echo('places:delete:error', array($title)));
}

forward(REFERER);
