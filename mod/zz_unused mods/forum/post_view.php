<?php
	/**
	 * @file post_view.php
	 * @brief Handle the post visualization
	 */

	require_once(dirname(dirname(dirname(__FILE__))).'/engine/start.php');

	// Post guid
	$entity_guid = get_input('entity_guid');
	// Post entity
	$entity = get_entity($entity_guid);
	
	// Check if the user has access to this post
	forum_gatekeeper($entity->container_guid);

	// Use elgg entity view system for display the post (the view that will be used is views/default/post/full_view.php
	$area2 = elgg_view_entity($entity,true);
	
	// Add the comments forms after the post view
	$area2 .= elgg_view('post/forms/comment',array('entity'=>$entity));
	
	// Add the comments lists after the comment form
	$area2 .= list_comments($entity->guid);
	
	// Apply the default elgg one column layout
	$page_body = elgg_view_layout('one_column_left_sidebar',$area1,$area2,$area3);

	page_draw($entity->title,$page_body);
?>