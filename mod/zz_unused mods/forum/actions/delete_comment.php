<?php
	/**
	 * @file actions/delete_comment.php
	 * @brief Deletes post comments
	 */

	action_gatekeeper();
	
	// Get the comment(annotation) ID
	$comment_id = get_input('comment_id');
	
	if ($comment_id) {
		$user = get_loggedin_user();
		
		// Check If the user can edit this comment
		if (can_edit_comment($comment_id,$user->guid)) {
			// Delete the comment(annotation)
			if (delete_annotation($comment_id)) {
				//Show a confirmation message
				system_message(elgg_echo('forum:comment_deleted_successfully'));
			} else {
				// Show a error message
				system_messages(sprintf(elgg_echo('forum:errors:comment_cant_be_deleted'),$comment_id),'errors');
			}
		}
	}
	
	// Forward the user to the last page that He visited
	forward($_SERVER['HTTP_REFERER']);
?>