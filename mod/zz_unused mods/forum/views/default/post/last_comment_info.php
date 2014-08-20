<?php
	/**
	 * @file views/default/post/last_comment_info.php
	 * @brief Displays who created and what time that the last comment was created
	 */

	if ($comments = get_comments($vars['entity']->guid)) {
		$last_comment = $comments[0];

		echo elgg_echo('forum:by');
		$owner = get_entity($last_comment->owner_guid);
?>
		<a href="<?php echo $owner->getUrl(); ?>"><?php echo $owner->name; ?></a>,
		<br />
<?php
		echo friendly_time($vars['entity']->time_created);
	} else {
		echo elgg_echo('forum:no_comments_created');
	}
?>