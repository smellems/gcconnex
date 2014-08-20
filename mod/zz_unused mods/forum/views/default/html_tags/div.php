<?php
	/**
	 * @file views/default/html_tags/div.php
	 * @brief Handle the display of the div html tag
	 */

	$class = ($vars['class']) ? 'class = '.$vars['class'] : '';
	$js = $vars['js'];
?>

<div <?php echo $class;?>>
	<?php echo $vars['body']; ?>
</div>