<?php
	/**
	 * @file views/default/post/new_post_button.php
	 * @brief Displays the button for create new posts
	 */

	if (can_post_in_forum($vars['entity']->guid)) {
?>
		<div class="forum_button"><a href="<?php echo $vars['url']; ?>pg/post/new/<?php echo $vars['entity']->guid; ?>"><?php echo elgg_echo('forum:new_topic'); ?></a></div>
<?php
	} 
?>