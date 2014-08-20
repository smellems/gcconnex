<?php

namespace hypeJunction\Places;

/**
 * Get an array of icon sizes for this entity
 * @param ElggEntity $entity
 * @return array
 */
function get_icon_sizes($entity) {

	$config = elgg_get_config('icon_sizes');
	$config = elgg_trigger_plugin_hook('entity:icon:sizes', 'object', array(
		'entity' => $entity,
			), $config);

	return $config;
}