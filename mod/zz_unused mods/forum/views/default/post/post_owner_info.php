<?php
	/**
	 * @file views/default/post/post_owner_info.php
	 * @brief Displays info for the post owner while showing the post full view
	 */

	$class = (isset($vars['class'])) ? ($vars['class']) : 'post_owner_info';
?>

<div class="<?php echo $class; ?>">
	<?php
		echo elgg_echo('forum:created').' '.friendly_time($vars['entity']->time_created);
		$owner = $vars['entity']->getOwnerEntity();
	?>
	<a href="<?php echo $owner->getUrl(); ?>"><?php echo elgg_echo('forum:by').' '.$owner->name; ?></a>
</div>