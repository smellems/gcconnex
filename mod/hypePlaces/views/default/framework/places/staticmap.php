<?php

namespace hypeJunction\Places;

$entity = elgg_extract('entity', $vars);

if (!elgg_instanceof($entity)) {
	return true;
}

$src = elgg_http_add_url_query_elements("//maps.googleapis.com/maps/api/staticmap", array(
	'center' => $entity->location,
	'zoom' => elgg_extract('zoom', $vars, 15),
	'size' => elgg_extract('size', $vars, '800x200'),
	'markers' => "icon:{$entity->getIconURL('marker')}%7C{$entity->location}",
	'key' => elgg_get_plugin_setting('google_api_key', PLUGIN_ID),
	'scale' => elgg_extract('scale', $vars, 2),
		));

echo elgg_view('output/url', array(
	'text' => elgg_view('output/img', array(
		'src' => $src,
		'class' => 'places-static-map',
	)),
	'href' => "//maps.google.com/maps?q=$entity->location",
	'target' => '_blank'
));
