<?php
	/**
	 * @file views/default/object/post.php
	 * @brief Handle the post display views
	 */

	if ($vars['full']) {
		echo elgg_view('post/full_view',$vars);
	} else {
		echo elgg_view('post/listing_view',$vars);
	}
?>