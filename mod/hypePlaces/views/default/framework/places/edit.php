<?php

namespace hypeJunction\Places;

$sticky_values = elgg_get_sticky_values('places/edit');
if (is_array($sticky_values)) {
	$vars = array_merge($vars, $sticky_values);
}

echo elgg_view_form('places/edit', array(
	'enctype' => 'multipart/form-data',
	'class' => 'places-form',
		), $vars);
