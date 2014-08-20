<?php

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity) {
	register_error(elgg_echo('places:error:not_found'));
	forward(REFERER);
}

if (!elgg_trigger_plugin_hook('permissions_check', 'places', array(
			'action' => 'unfeature',
			'entity' => $entity
				), true)) {
	register_error(elgg_echo('places:error:permissions'));
	forward(REFERER);
}

$entity->featured = true;

system_message(elgg_echo('places:feature:success', array($entity->title)));
forward(REFERER);
