<?php
	/**
	 * @file forum_view.php
	 * @brief Handle the forum visualization
	 */

	require_once(dirname(dirname(dirname(__FILE__))).'/engine/start.php');

	// Forum guid
	$entity_guid = get_input('entity_guid');
	
	// Get forum entity from the passed guid or the main forum entity
	if (!$forum = get_entity($entity_guid)) {
		$forum = get_main_forum();
	}
	
	// If It was possible to get the forum then display It
	if ($forum) {
		// Check if the user has access to this forum
		forum_gatekeeper($forum->guid);
		// Use elgg entity view system for display the forum
		$area2 = elgg_view_entity($forum,true);
	} else {
		// If there is no forum for be displayed then show a explanation text
		$area2 = elgg_echo('forum:errors:no_main_forum');
	}
	
	$page_body = elgg_view_layout('one_column',$area2,$area3);

	page_draw($forum->title,$page_body);
?>