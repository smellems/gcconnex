<?php
	/**
	 * @file views/default/post/lock.php
	 * @brief Displays the lock image for post with locked status
	 */

	if ($vars['entity']->status == 'closed') {
		$class = (isset($vars['class'])) ? ($vars['class']) : 'topic_icon';
?>
<img alt="<?php echo elgg_echo('forum:closed'); ?>" title="<?php echo elgg_echo('forum:closed'); ?>" class="<?php echo $class; ?>" src="<?php echo $vars['url']; ?>mod/forum/graphics/padlock.jpg" />
<?php 
	}
?>