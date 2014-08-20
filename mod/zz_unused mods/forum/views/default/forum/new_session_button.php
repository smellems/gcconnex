<?php
	/**
	 * @file views/default/forum/new_session_button.php
	 * @brief Displays a button for create new forums
	 */

	if (can_moderate_forum($vars['entity']->guid)) {
?>
		<div class="forum_button"><a href="<?php echo $vars['url']; ?>pg/forums/new/<?php echo $vars['entity']->guid; ?>"><?php echo elgg_echo('forum:new_session'); ?></a></div>
<?php
	} 
?>