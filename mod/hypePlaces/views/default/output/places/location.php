<?php

namespace hypeJunction\Places;

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof Place) {
	return true;
}

$components = $entity->getAddress();
unset($components['country_code']);
$value = implode(', ', array_filter($components));

if (!$value) {
	return true;
}

echo elgg_view('output/url', array(
	'text' => $value,
	'href' => "//maps.google.com/maps?q=$value",
	'target' => '_blank'
));