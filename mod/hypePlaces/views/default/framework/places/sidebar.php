<?php

namespace hypeJunction\Places;

$entity = elgg_extract('entity', $vars);

if ($entity instanceof Place) {
	echo elgg_view_menu('product:page', array(
		'entity' => $entity,
		'sort_by' => 'priority',
		'class' => 'elgg-menu-page',
		'show_section_headers' => true,
	));
}

