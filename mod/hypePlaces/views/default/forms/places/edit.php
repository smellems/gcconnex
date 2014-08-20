<?php

namespace hypeJunction\Places;

$entity = elgg_extract('entity', $vars);
$container = elgg_extract('container', $vars);

$required = elgg_format_attributes(array(
	'title' => elgg_echo('places:required'),
	'class' => 'required'
		));
?>
<fieldset class="has-legend">
	<legend><?php echo elgg_echo('places:place:about') ?></legend>
	<div>
		<label <?php echo $required ?>><?php echo elgg_echo('places:place:title') ?></label>
		<?php
		echo elgg_view('input/text', array(
			'name' => 'title',
			'value' => elgg_extract('title', $vars, $entity->title),
			'required' => true,
		));
		?>
	</div>
	<div>
		<label><?php echo elgg_echo('places:place:icon') ?></label>
		<?php
		echo elgg_view('input/file', array(
			'name' => 'icon',
			'value' => ($entity->icontime),
		));
		?>
	</div>
	<div>
		<label><?php echo elgg_echo('places:place:description') ?></label>
		<?php
		echo elgg_view('input/longtext', array(
			'name' => 'description',
			'value' => elgg_extract('description', $vars, $entity->description),
		));
		?>
	</div>
	<div>
		<label><?php echo elgg_echo('places:place:category') ?></label>
		<?php
		echo elgg_view('input/category', array(
			'value' => elgg_extract('category', $vars),
			'entity' => $entity,
		));
		?>
	</div>
	<div>
		<label><?php echo elgg_echo('places:place:tags') ?></label>
		<?php
		echo elgg_view('input/tags', array(
			'name' => 'tags',
			'value' => elgg_extract('tags', $vars, $entity->tags),
		));
		?>
	</div>
	<div>
		<label><?php echo elgg_echo('tag_names:specialties') ?></label>
		<?php
		echo elgg_view('input/tags', array(
			'name' => 'specialties',
			'value' => elgg_extract('specialties', $vars, $entity->specialties),
		));
		?>
	</div>

	<?php
	if (elgg_view_exists('input/markertype')) {
		?>
		<div>
			<label><?php echo elgg_echo('places:place:markertype') ?></label>
			<?php
			echo elgg_view('input/markertype', array(
				'name' => 'markertype',
				'value' => elgg_extract('markertype', $vars, $entity->markertype),
			));
			?>
		</div>
		<?php
	}
	?>
</fieldset>
<fieldset class="has-legend">
	<legend><?php echo elgg_echo('places:place:address') ?></legend>
	<?php
	echo elgg_view('forms/places/postal_address', array(
		'prefix' => 'address',
		'value' => elgg_extract('address', $vars, ($entity instanceof Place) ? $entity->getAddress() : array()),
		'required' => true,
	));
	?>
</fieldset>
<fieldset class="has-legend">
	<legend><?php echo elgg_echo('places:place:contact') ?></legend>
	<?php
	echo elgg_view('forms/places/contact_details', $vars);
	?>
</fieldset>

<fieldset class="has-legend">
	<legend><?php echo elgg_echo('places:place:tools') ?></legend>
	<div>
		<?php
		echo '<label>' . elgg_view('input/checkbox', array(
			'name' => 'tools[checkins]',
			'default' => false,
			'value' => true,
			'checked' => (isset($entity->checkins)) ? $entity->checkins : true,
		)) . elgg_echo('places:place:tools:checkins') . '</label>';
		?>
	</div>
</fieldset>

<div>
	<label><?php echo elgg_echo('places:place:access_id') ?></label>
	<?php
	echo elgg_view('input/access', array(
		'name' => 'access_id',
		'value' => elgg_extract('access_id', $vars, ($entity) ? $entity->access_id : get_default_access()),
	));
	?>
</div>

<div class="elgg-foot text-right">
	<?php
	echo elgg_view('input/hidden', array(
		'name' => 'guid',
		'value' => elgg_extract('guid', $vars, $entity->guid),
	));
	echo elgg_view('input/hidden', array(
		'name' => 'container_guid',
		'value' => elgg_extract('container_guid', $vars, $container->guid),
	));
	echo elgg_view('input/submit', array(
		'value' => elgg_echo('save')
	));
	?>
</div>