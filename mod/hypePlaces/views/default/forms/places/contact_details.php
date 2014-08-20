<?php

namespace hypeJunction\Places;

$entity = elgg_extract('entity', $vars);

?>

<div>
	<label><?php echo elgg_echo('places:place:phone') ?></label>
	<?php
	echo elgg_view('input/text', array(
		'name' => 'phone',
		'value' => elgg_extract('phone', $vars, $entity->phone),
	));
	?>
</div>

<div>
	<label><?php echo elgg_echo('places:place:website') ?></label>
	<?php
	echo elgg_view('input/text', array(
		'name' => 'website',
		'value' => elgg_extract('website', $vars, $entity->website),
	));
	?>
</div>

<div>
	<label><?php echo elgg_echo('places:place:twitter') ?></label>
	<?php
	echo elgg_view('input/text', array(
		'name' => 'twitter',
		'value' => elgg_extract('twitter', $vars, $entity->twitter),
	));
	?>
</div>