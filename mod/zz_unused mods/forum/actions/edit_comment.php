<?php
	/**
	 * @file actions/edit_comment.php
	 * @brief Add comments to post entities
	 */

	action_gatekeeper();

	$post_guid = get_input('post_guid');
	$comment = get_input('comment_text');
	$comment_id = get_input('comment_id');
	
	// Check if there is a comment ID
	if (!$comment_id) {
		// If there is not comment ID then the user is creating a new comment
		if (create_annotation($post_guid,'comment',$comment,'text',0,ACCESS_PUBLIC)) {
			// Shows comment creation confirmating message
			system_message(elgg_echo('forum:comment_saved_successfully'));
		} else {
			// Shows comment creation error message
			system_messages(sprintf(elgg_echo('forum:errors:invalid_post_guid'),$post_guid),'errors');
		}
	} else {
		// Get the loggedin user
		$user = get_loggedin_user();
		// Check if the user can edit the comment
		if (can_edit_comment($comment_id)) {
			// Check again in accordance with elgg default access system
			if (can_edit_extender($comment_id,'annotation',$user->guid)) {
				// Update the comment text(value)
				if (update_annotation($comment_id,'comment',$comment,'text',0,2)) {
					// Get the comment annotation
					$comment_annotation = get_annotation($comment_id);

					// Shows a confirmation message for update the comment content
					system_message(elgg_echo('forum:comment_updated'));
					//Forward the user to the page of the post that owns the comment
					forward(get_entity_url($comment_annotation->entity_guid));
				}
			}
		}
	}
	
	forward($_SERVER['HTTP_REFERER']);
?>