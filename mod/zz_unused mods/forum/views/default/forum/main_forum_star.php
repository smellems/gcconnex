<?php
	/**
	 * @file views/default/forum/main_forum_star.php
	 * @brief Displays the star img only for the main forum 
	 */

	// If this forum is the main forum then show the star before the title
	if (is_main_forum($vars['entity']->guid)) {
?>
		<img class='float_left' src="<?php echo $vars['url']; ?>mod/forum/graphics/star.png" />
<?php
	}
?>