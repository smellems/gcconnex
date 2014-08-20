<?php
	/**
	 * @file mod/forum/edit_forum.php
	 * @brief Allow the admins to create new forums
	 */

	// Forum guid
	$entity_guid = get_input('entity_guid',0);

	// Container forum guid
	$container_forum = get_input('forum_guid');

	// Forum entity
	$forum = get_entity($entity_guid);
	
	// Check if the use has access for this forum
	forum_gatekeeper($forum->guid);
	
	// Check if the user can create new forums into this forum
	edit_forum_gatekeeper($forum->guid);
	
	// Displays the forum edit form
	$area2 = elgg_view('forum/forms/edit_forum',array('entity'=>$forum,'container_forum_guid'=>$container_forum));

	// Add default elgg one column layout
	$page_body = elgg_view_layout('one_column_left_sidebar',$area1,$area2);

	page_draw(elgg_echo('forum:new_forum'),$page_body);
?>