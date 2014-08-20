<?php

namespace hypeJunction\Places;

$entity = elgg_extract('entity', $vars);
$full = elgg_extract('full_view', $vars);

$title = elgg_view('output/url', array(
	'text' => $entity->title,
	'href' => $entity->getURL(),
		));

if (!elgg_in_context('widgets')) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $entity,
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
		'handler' => PAGEHANDLER,
	));
}

if ($entity->description && $full) {
	$description = elgg_view('output/longtext', array(
		'value' => ($full) ? $entity->description : elgg_get_excerpt($entity->description)
	));
}

$subtitle[] = elgg_view('output/places/location', array(
	'entity' => $entity,
		));

if ($entity->phone) {
	$subtitle[] = $entity->phone;
}
if ($entity->website) {
	$subtitle[] = elgg_view('output/url', array(
		'text' => elgg_echo('places:place:website'),
		'href' => $entity->website,
	));
}
if ($entity->twitter) {
	$twitter = str_replace('@@', '@', "@$entity->twitter");
	$subtitle[] = elgg_view('output/url', array(
		'text' => $twitter,
		'href' => "https://twitter.com/$twitter",
		'target' => '_blank',
	));
}
if ($entity->specialties) {
	$subtitle[] = elgg_view('output/tags', array(
		'value' => $entity->specialties,
		'icon_class' => 'places-icon-specialties',
	));
}

$subtitle = implode('', array_map(function($elem) {
			return "<div class=\"places-meta\">$elem</div>";
		}, $subtitle));

if (elgg_in_context('gallery')) {
	$icon = elgg_view_entity_icon($entity, '325x200');
	if ($entity->featured) {
		$ribbon = '<div class="places-featured-ribbon"><div class="banner"><div class="text">' . elgg_echo('places:featured') . '</div></div></div>';
	}
	echo elgg_view_module('aside', $title, $ribbon . $icon . $subtitle, array(
		'footer' => $metadata
	));
} else {

	$icon = elgg_view_entity_icon($entity, 'medium');
	$summary = elgg_view('object/elements/summary', array(
		'entity' => $entity,
		'title' => $title,
		'subtitle' => $subtitle,
		'metadata' => $metadata,
		'content' => $description,
	));
	$icon .= $interactions;
	
	if ($full) {
		echo elgg_view('object/elements/full', array(
			'icon' => $icon,
			'entity' => $entity,
			'summary' => $summary,
				//'body' => elgg_view('breeds/animal/breeds', $vars)
		));
	} else {
		echo elgg_view_image_block($icon, $summary);
	}
}