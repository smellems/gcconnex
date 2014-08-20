<?php

namespace hypeJunction\Places;

$filter_context = elgg_extract('filter_context', $vars, 'featured');

switch ($filter_context) {

	default :
	case 'featured' :
		$list = elgg_list_entities_from_metadata(array(
			'types' => 'object',
			'subtypes' => Place::SUBTYPE,
			'metadata_name_value_pairs' => array(
				'name' => 'featured', 'value' => true,
			),
			'list_type' => 'gallery',
			'gallery_class' => 'places-gallery',
			'full_view' => false,
		));
		break;

	case 'all' :
		$list = elgg_list_entities(array(
			'types' => 'object',
			'subtypes' => Place::SUBTYPE,
			'list_type' => 'gallery',
			'gallery_class' => 'places-gallery',
			'full_view' => false,
		));
		break;

	case 'owner' :
		$page_owner = elgg_get_page_owner_entity();
		$list = elgg_list_entities(array(
			'types' => 'object',
			'subtypes' => Place::SUBTYPE,
			'owner_guids' => $page_owner->guid,
			'full_view' => false,
		));
		break;

	case 'bookmarked' :
		$page_owner = elgg_get_page_owner_entity();
		$list = elgg_list_entities_from_relationship(array(
			'types' => 'object',
			'subtypes' => Place::SUBTYPE,
			'relationship' => 'bookmarked',
			'relationship_guid' => $page_owner->guid,
			'full_view' => false,
		));
		break;
}

if (!$list) {
	$list = '<p>' . elgg_echo('places:list:empty') . '</p>';
}

echo $list;
