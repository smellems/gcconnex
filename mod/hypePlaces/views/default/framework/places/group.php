<?php

namespace hypeJunction\Places;

$page_owner = elgg_get_page_owner_entity();

$list = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => Place::SUBTYPE,
	'container_guids' => $page_owner->guid,
	'full_view' => false,
		));

if (!$list) {
	$list = '<p>' . elgg_echo('places:list:empty') . '</p>';
}

echo $list;
