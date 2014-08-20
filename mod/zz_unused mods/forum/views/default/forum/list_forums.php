<?php
	/**
	 * @file views/default/forum/list_forums.php
	 * @brief Displays a list of forums or subforums
	 */
?>

<div class="forum_container">
	<?php
		if (!$vars['hidden_session_button']) {
			// Button for create a new session	
			echo elgg_view('forum/new_session_button',$vars);
		}
		
		// Displays the header for a forum list
		echo elgg_view('forum/listing_forums_header',$vars);
		
		// Displays the forum list
		echo list_forums($vars['entity']->guid);
	?>
</div>