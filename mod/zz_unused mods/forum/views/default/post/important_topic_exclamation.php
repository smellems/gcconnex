<?php
	/**
	 * @file views/default/post/important_topic_exclamation.php
	 * @brief Displays a customized exclamation for important topics
	 */

	if($vars['entity']) {
		if ($vars['entity']->important_topic == 'yes') {
			$class= ($vars['class']) ? ($vars['class']) : 'important_topic_exclamation topic_icon';
?>
			<span class="<?php echo $class; ?>">(!)</span>
<?php
		}
	} 
?>