<?php

namespace hypeJunction\Places;

$entity = elgg_extract('entity', $vars);

echo '<div>';
echo '<label>' . elgg_echo('places:settings:params[checkin_duration]') . '</label>';
echo '<div class="elgg-text-help">' . elgg_echo('places:settings:hint:checkin_duration') . '</div>';
echo elgg_view('input/text', array(
	'name' => 'params[checkin_duration]',
	'value' => $entity->checkin_duration
));
echo '</div>';
