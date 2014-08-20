<?php
	/**
	 * @file mod/forum/wrong_url.php
	 * @brief Shows a errors page for wrong URLS
	 */

	require_once(dirname(dirname(dirname(__FILE__))).'/engine/start.php');

	$title = elgg_echo('forum:wrong_url');
	
	$area2 = elgg_view('forum/wrong_url');
	
	$page_body = elgg_view_layout('two_column_left_sidebar',$area1,$area2);
	
	page_draw($title,$page_body);
?>