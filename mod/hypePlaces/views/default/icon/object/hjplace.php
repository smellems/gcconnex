<?php

namespace hypeJunction\Places;

$entity = elgg_extract('entity', $vars);

$requested_size = $size = elgg_extract('size', $vars);

$places_config = get_icon_sizes($entity);

if (array_key_exists($requested_size, $places_config)) {
	$values = elgg_extract($requested_size, $places_config);
	$requested_w = $values['w'];
} else {
	list($requested_w, $requested_h) = explode('x', $requested_size);
}

$class = elgg_extract('img_class', $vars, 'places-icon centered');

$title = htmlspecialchars($entity->title, ENT_QUOTES, 'UTF-8', false);

$url = $entity->getURL();
if (isset($vars['href'])) {
	$url = $vars['href'];
}

$img = elgg_view('output/img', array(
	'src' => $entity->getIconURL($vars['size']),
	'class' => $class,
	'width' => $requested_w,
	'height' => $requested_h,
		));


if ($url) {

	$params = array(
		'href' => $url,
		'text' => $img,
		'title' => $title . ": " . elgg_strip_tags($entity->description),
		'is_trusted' => true,
		'data-guid' => $entity->guid,
	);

	if ($class) {
		$params['class'] = $class;
	}

	echo elgg_view('output/url', $params);
} else {
	echo $img;
}
