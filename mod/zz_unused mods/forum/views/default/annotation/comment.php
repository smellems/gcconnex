<?php
	/**
	 * @file views/default/annotation/comment.php
	 * @brief Handle the comments for post entities
	 */

	$post = get_entity($vars['annotation']->entity_guid);
	
	echo elgg_view('post/comment',array('comment'=>$vars['annotation'],'post'=>$post));
?>
