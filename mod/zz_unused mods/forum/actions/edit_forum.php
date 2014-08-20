<?php
	/**
	 * @file actions/edit_forum.php
	 * @brief Handle the edition of foruns
	 */

	action_gatekeeper();
	admin_gatekeeper();

	$user = get_loggedin_user();
	$entity_guid = get_input('entity_guid');
	$container_forum_guid = get_input('container_forum_guid');

	// Get the forum entity inputs
	$forum_name = get_input('forum_name');
	$forum_order = get_input('forum_order');
	$forum_description = get_input('forum_description');
	$main_forum = get_input('main_forum');
	
	// Array input with filled with the groups GUIDS
	$allowed_view = get_input('allowed_view');
	
	// Array input with filled with the groups GUIDS
	$allowed_post = get_input('allowed_post');
	
	// Array input with filled with the groups GUIDS
	$allowed_moderate = get_input('allowed_moderate');
	
	$access_id = get_input('access_id',ACCESS_PUBLIC);
	
	$error_message = '';

	if (!$forum_name) {
		$error_message .= elgg_echo('forum:errors:blank_forum_name');
	}
	if (!$forum_order) {
		if ($error_message)	{
			$error_message .= '<br />';
		}
		$error_message .= elgg_echo('forum:errors:blank_forum_order');
	}
	if (!$forum_description) {
		if ($error_message) {
			$error_message .= '<br />';
		}
		$error_message .= elgg_echo('forum:errors:blank_forum_description');
	}
	if (!$main_forum) {
		$main_forum = 'no';
	}
	
	if ($error_message) {
		$_SESSION['forum_edit_error'] = true;
		$_SESSION['forum_name'] = $forum_name;
		$_SESSION['forum_order'] = $forum_order;
		$_SESSION['forum_description'] = $forum_description;
		$_SESSION['main_forum'] = $main_forum;
		$_SESSION['allowed_view'] = serialize($allowed_view);
		$_SESSION['allowed_post'] = serialize($allowed_post);
		$_SESSION['allowed_moderate'] = serialize($allowed_moderate);

		system_messages($error_message,'errors');
		forward($_SERVER['HTTP_REFERER']);
	} else {
		
		//If the user can not moderate this forum then forward him to the last page that He visited
		if ($entity_guid && !can_moderate_forum($entity_guid)) {
			forward($_SERVER['HTTP_REFERER']);
		}

		// If It is not possible to get an entity then lets create a new forum entity instead of edit
		if (!$forum = get_entity($entity_guid)) {
			$forum = new ElggObject();
		}

		// Add the basic attributes
		$forum->title = $forum_name;
		$forum->description = $forum_description;
		$forum->subtype = 'forum';
		$forum->access_id = $access_id;
		// If there is a container forum then lets change the container attribute otherwise do not change this attribute
		if ($container_forum_guid) {
			$forum->container_guid = $container_forum_guid;
		}
		
		// Save the entity object and lets create some metadatas
		if ($forum->save()) {
			// Setting the forum listing order
			$forum->order = $forum_order;
			
			// Check if this forum was setted up as main forum
			if ($main_forum == 'yes') {
				// Change the last main forum attributes and the new main forum too
				set_main_forum($forum->guid);
			} else {
				// Remove the main forum metadata from this forum
				remove_metadata($forum->guid,'main_forum');
			}

			// It's necessary remove the metadata before updating in case of multi-medatadas
			remove_metadata($forum->guid,'visualization_groups');
			if ($allowed_view && !empty($allowed_view)) {
				$forum->visualization_groups = $allowed_view;
			}
			
			// It's necessary remove the metadata before updating in case of multi-medatadas
			remove_metadata($forum->guid,'posting_groups');
			if ($allowed_post && !empty($allowed_post)) {
				$forum->posting_groups = $allowed_post;
			}
			
			// It's necessary remove the metadata before updating in case of multi-medatadas
			remove_metadata($forum->guid,'moderation_groups');
			if ($allowed_moderate && !empty($allowed_moderate)) {
				$forum->moderation_groups = $allowed_moderate;
			}

			// Let's add some information to the river
			if (!$entity_guid) {
				// Add to river that a new forum was created
				add_to_river('forum/river/default_view','create',$user->getGUID(),$forum->guid,2);
			} else {
				// Add to river that a forum was updated
				add_to_river('forum/river/default_view','update',$user->getGUID(),$forum->guid,2);
			}
			
			// Unsetting the pre-filled edit forum form values
			unset($_SESSION['forum_edit_error']);
			unset($_SESSION['forum_name']);
			unset($_SESSION['forum_description']);
			unset($_SESSION['main_forum']);
			
			// Check if the user is creating or updating a forum
			if ($entity_guid) {
				// Save confirmation message for forum update 
				$message = sprintf(elgg_echo('forum:forum_edited'),$forum->title);
			} else {
				// Save confirmation message for forum creation
				$message = sprintf(elgg_echo('forum:forum_saved'),$forum->title);
			}
			
			global $CONFIG;
		
			// Shows the message
			system_message($message);
			forward($CONFIG->wwwroot.'pg/forums/all');
		}
	}
?>