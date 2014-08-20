<?php
	/**
	 * @file actions/edit_post.php
	 * @brief Handle the edition of posts
	 */

	action_gatekeeper();

	// Get the loggedin user entity
	$user = get_loggedin_user();
	// Get the post guid
	$entity_guid = get_input('entity_guid');
	
	// Get post attributes
	$post_title = get_input('post_title');
	$post_message = get_input('post_message');
	$post_tags = get_input('post_tags');
	$access_id = get_input('access_id',ACCESS_PUBLIC);
	$container_id = get_input('forum_guid');
	
	$error_message = '';

	if (!$forum = get_entity($container_id)) {
		if ($error_message)	{
			$error_message .= '<br />';
		}
		$error_message .= sprintf(elgg_echo('forum:errors:cant_find_forum'),$container_id);
	}
	if (!$post_title) {
		if ($error_message) {
			$error_message .= '<br />';
		}
		$error_message .= elgg_echo('forum:errors:blank_post_title');
	}
	if (!$post_message) {
		if ($error_message) {
			$error_message .= '<br />';
		}
		$error_message .= elgg_echo('forum:errors:blank_post_message');
	}
	
	if ($error_message) {
		$_SESSION['post_edit_error'] = true;
		$_SESSION['post_title'] = $post_title;
		$_SESSION['post_message'] = $post_message;
		$_SESSION['post_tags'] = $post_tags;
		
		system_messages($error_message,'errors');
		forward($_SERVER['HTTP_REFERER']);
	} else {
		
		// If there is a post and the user can not edit It then forward him to the last page that He visited
		if ($entity_guid) {
			if (!can_edit_entity($entity_guid)) {
				forward($_SERVER['HTTP_REFERER']);
			}
		}
		
		// If there is not a post entity then lets create a new one
		if (!$post = get_entity($entity_guid)) {
			$post = new ElggObject();
		}

		// Save elgg entity attribute
		$post->title = $post_title;
		$post->description = $post_message;
		$post->subtype = 'post';
		$post->access_id = $access_id;
		$post->container_guid = $container_id;
		
		// Try to save the elgg entity attributes
		if ($post->save()) {
			// Check if the user is creating or updating the entity
			if (!$entity_guid) {
				// Shows creation message for posts
				add_to_river('forum/river/default_view','create',$user->getGUID(),$post->guid,2);
			} else {
				// Shows update message for posts
				add_to_river('forum/river/default_view','update',$user->getGUID(),$post->guid,2);
			}
			
			// Add the tags metadata
			$tags_array = string_to_tag_array($post_tags);
			$post->tags = $tags_array;
			
			// Unsetting the pre-filled edit post form values
			unset($_SESSION['post_edit_error']);
			unset($_SESSION['post_title']);
			unset($_SESSION['post_message']);
			unset($_SESSION['post_tags']);
			
			// Check if the user is creating or updating an entity
			if ($entity_guid) {
				// Save the editing message for posts
				$message = sprintf(elgg_echo('forum:post_edited'),$post->title);
			} else {
				// Save the creation message for posts
				$message = sprintf(elgg_echo('forum:post_created'),$post->title);
			}
			
			// Check if there is some views counting system and ask for update the last view time
			if (trigger_plugin_hook('views_counting_system','plugin')) {
				$params= array('entity'=>$post);
				trigger_plugin_hook('update_last_view_time_hook','plugin',$params);
			}
			
			global $CONFIG;

			// Shows the message
			system_message($message);
			forward($CONFIG->wwwroot.'pg/forums/'.$container_id);
		}
	}
?>