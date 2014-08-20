<?php
	/**
	 * @file mod/forum/all_forums.php
	 * @brief Display manage forums admin page
	 */

	// To list all forum entities
	$area1 = elgg_view('forum/list_forums');
	
	// Add one div with class forum container
	$area1 = elgg_view('html_tags/div',array('class'=>'forum_container','body'=>$area1));
	
	// Add one div with class forum_wrapper
	$area1 = elgg_view('html_tags/div',array('class'=>'forum_wrapper', 'body'=>$area1));
	
	// Add the default elgg one column layout
	$page_body = elgg_view_layout('one_column',$area1);

	page_draw(elgg_echo('forums:all_forums'),$page_body);
?>