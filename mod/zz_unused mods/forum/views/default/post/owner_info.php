<?php
	/**
	 * @file views/default/post/owner_info.php
	 * @brief Displays owner info for posts
	 */

	echo elgg_echo('forum:created').' ';
	echo friendly_time($vars['entity']->time_created);
	echo ' '.elgg_echo('forum:by');
	
	$owner = get_entity($vars['entity']->owner_guid);
?>

<a href="<?php echo $owner->getUrl(); ?>"><?php echo $owner->name; ?></a>