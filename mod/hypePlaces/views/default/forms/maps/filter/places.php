<?php

namespace hypeJunction\Places;

$query = get_input('query', array());
$location = get_input('location', array());
$radius = get_input('radius', HYPEMAPS_SEARCH_RADIUS);

$body .= '<div>';
$body .= '<label>' . elgg_echo('maps:filter:objects:attributes') . '</label>';
$body .= elgg_view('input/text', array(
	'name' => 'query[object]',
	'value' => elgg_extract('object', $query)
		));
$body .= '</div>';

$body .= '<div>';
$body .= '<label>' . elgg_echo('maps:filter:objects:tags') . '</label>';
$body .= elgg_view('input/text', array(
	'name' => 'query[tags]',
	'value' => elgg_extract('tags', $query)
		));
$body .= '</div>';

$user = elgg_get_logged_in_user_entity();

$body .= '<div>';
$body .= '<label>' . elgg_echo('maps:filter:objects:location') . '</label>';

$body .= '<div class="maps-filter-location">';
$body .= elgg_view('input/location', array(
	'name' => 'location[find]',
	'value' => elgg_extract('find', $location),
		));
$body .= '</div>';
$body .= '</div>';

$body .= '<div>';
$body .= '<label>' . elgg_echo('maps:filter:objects:radius') . '</label>';
$body .= '<div class="maps-filter-radius">';
$metric_system = elgg_get_plugin_setting('metric_system', PLUGIN_ID);
$key = 'maps:proximity:' . $metric_system;
$body .= elgg_view('input/dropdown', array(
	'name' => 'radius',
	'value' => $radius,
	'options_values' => array(
		0 => elgg_echo('maps:filter:radius:none'),
		5 => elgg_echo($key, array(5)),
		10 => elgg_echo($key, array(10)),
		25 => elgg_echo($key, array(25)),
		100 => elgg_echo($key, array(100)),
		500 => elgg_echo($key, array(500))
	)
		));
$body .= '</div>';
$body .= '</div>';

$footer .= elgg_view('input/submit', array(
	'value' => elgg_echo('filter'),
		));

echo elgg_view_module('aside', elgg_echo('places:search'), $body, array(
	'footer' => $footer
		));