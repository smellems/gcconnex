<?php
	/**
	 * @file views/default/object/forum.php
	 * @brief Handle the forum display views
	 */

	if ($vars['full']) {
		echo elgg_view('forum/full_view',$vars);
	} else {
		echo elgg_view('forum/listing_view',$vars);
	}
?>