<?php

namespace hypeJunction\Places;

$entity = elgg_extract('entity', $vars);
?>
<div class="places-profile-header">
	<?php
	if ($entity->featured) {
		?>
		<div class="places-featured-ribbon">
			<div class="banner">
				<div class="text"><?php echo elgg_echo('places:featured') ?></div>
			</div>
		</div>
		<?php
	}
	?>

	<div class="places-profile-map">
		<?php
		echo elgg_view('framework/places/staticmap', array(
			'entity' => $entity,
			'width' => '800x200',
			'scale' => 2,
		));
		?>
	</div>
	<div class="places-profile-details">
		<?php
		echo elgg_view_entity($entity, array(
			'full_view' => false,
		));
		?>
	</div>
</div>

<?php
echo elgg_view_layout('widgets', array(
	'num_columns' => 2,
	'exact_match' => true,
));

