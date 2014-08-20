<?php
	/**
	 * @file views/default/post/comment.php
	 * @brief Displays the comments for post entities
	 * 
	 */
?>

<div class='comment'>
	<div class='comment_header'>
		<?php
			// If the loggedin user can edit the entity then show the edit and delete button
			if ($vars['user']) {
				if (can_edit_comment($vars['comment']->id)) {
		?>
					<div class='float_right'>
						<a href="<?php echo $vars['url']; ?>pg/post/<?php echo $vars['post']->guid; ?>/edit_comment/<?php echo $vars['comment']->id; ?>#comment_form"><?php echo elgg_echo('forum:edit'); ?></a>
						/
						<?php echo elgg_view('output/confirmlink',array('text'=>elgg_echo('forum:delete'),'href'=>$vars['url'].'action/forum/delete_comment?comment_id='.$vars['comment']->id)); ?>
					</div>
		<?php
				}
			}
		?>
	</div>
	<div class='comment_body'>
		<?php
			echo $vars['comment']->value;
		?>
	</div>
	<br />
	<div class='comment_footer'>
		<div class='float_right'>
		<?php
			echo elgg_echo('forum:created').' '.friendly_time($vars['comment']->time_created);
			$owner = $vars['comment']->getOwnerEntity();
			echo elgg_echo('forum:by').' '.$owner->name;
		?>
		</div>
	</div>
	<div class='clearfloat'></div>
</div>