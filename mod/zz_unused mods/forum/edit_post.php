<?php
	/**
	 * @file mod/forum/edit_post.php
	 * @brief To show the new post creation form page
	 */
	
	require_once(dirname(dirname(dirname(__FILE__))).'/engine/start.php');
	
	// Post guid
	$entity_guid = get_input('entity_guid');

	// Get the container of the post
	if ($post = get_entity($entity_guid)) {
		$forum_guid = $post->container_guid;
	} else {
		if (!$forum_guid = get_input('forum_guid')) {
			$forum_guid = get_main_forum_guid();
		}
	}

	// Check if the use has access to this forum
	forum_gatekeeper($forum_guid);

	$forum = get_entity($forum_guid);
	
	$area2 = elgg_view('forum/listing_forums_header');
	// List the forum that the user is creating a new post
	$area2 .= elgg_view_entity($forum);
	
	if (!$post) {
		$area2 .= '<br /><br /><h3 class="align_center">'.elgg_echo('forum:create_new_topic').'</h3>';
	}
	// The edit post form
	$area2 .= elgg_view('post/forms/edit_post',array('entity'=>$post,'forum_guid'=>$forum_guid));
	
	// Add the default elgg one column laytout
	$page_body = elgg_view_layout('one_column_left_sidebar',$area1,$area2);
	
	page_draw(elgg_echo('forum:new_post'),$page_body);
?>