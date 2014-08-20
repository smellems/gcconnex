<?php
	/**
	 * @file lib/forum.php
	 * @brief Forum plugin lib
	 */

	/**
	 * Set the forum as the main forum of the current elgg site
	 * 
	 * @param $forum_guid Int The guid of a forum entity
	 * @return true | false Depends on success
	 */
	function set_main_forum($forum_guid) {
		if($forum = get_entity($forum_guid)) {
			if($main_forum_guid = get_main_forum_guid()) {
				remove_metadata($main_forum_guid,'main_forum');
			}
			
			$forum->main_forum = true;
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * Returns the main forum guid
	 * 
	 * @return Ing The guid of the main forum
	 */
	function get_main_forum_guid() {
		$options = array(
			'metadata_names'=>'main_forum',
			'metadata_values'=>true,
			'types'=>'object',
			'subtype'=>'forum',
			'limit'=>1,
			);
		if ($main_forum = elgg_get_entities_from_metadata($options)) {
			if (is_array($main_forum)) {
				$main_forum = $main_forum[0];
			}			
			return $main_forum->guid;
		}
		return false;
	}
	
	/**
	 * Check if the forum is the main forum of the current site
	 * 
	 * @param $forum_guid Int The guid of any forum entity
	 * @return true | false Depends on success
	 */
	function is_main_forum($forum_guid) {
		if ($forum_guid) {
			$main_forum_guid = get_main_forum_guid();
			
			if ($forum_guid == $main_forum_guid) {
				return true;
			}
		}		
		return false;
	}

	/**
	 * Handle the access to forums according to their settings
	 * 
	 * @param $forum_guid Int The guid of a forum entity
	 * @param $user Int The guid of an user
	 */
	function forum_gatekeeper($forum_guid,$user_guid) {
		if (can_see_forum($forum_guid,$user_guid)) {
			return true;
		}

		system_message('forward');
		$forum = get_entity($forum_guid);		
		//system_messages(sprintf(elgg_echo('forum:errors:cant_see_forum'),$forum->title),'errors');
		forward($_SERVER['HTTP_REFERER']);
	}
	
	/**
	 * Check if the user can see the forum content
	 * 
	 * @param $forum_guid Int The GUID of a forum entity
	 * @param $user_guid Int The GUID of an user
	 */
	function can_see_forum($forum_guid,$user_guid) {
		if (isadminloggedin()) {
			return true;
		}

		if ($forum = get_entity($forum_guid)) {
			if (!$user = get_entity($user_guid)) {
				$user = get_loggedin_user();
			}

			switch ($forum->access_id) {
				case 0:
					// If the loggedin user is the entity owner then return true
					if (can_edit_entity($forum->guid,$user->guid)) {
						return true;
					}
					break;

				case 1:
					// If the entity has "loggedin" access then return true because the user was checked at the last if
					return true;

				case 2:
					// Get access collection allowed to see the forum content
					$allowed_groups = get_forum_allowed_visualization_groups($forum_guid);

					// If the the forum has visualization option setted as public or loggedin so all users can see the forum
					if (in_array(1,$allowed_groups) || in_array(2,$allowed_groups)) {
						return true;
					}
					
					// Get the access collection which the user is allowed to see
					$access_array = get_access_array($user_guid);
					
					// If some access collection that the user has is allowed to see the forum then return true
					foreach($access_array as $access) {
						if (in_array($access,$allowed_groups)) {
							return true;
						}
					}
					break;
			}
		}
		return false;
	}
	
	/**
	 * Get a list of allowed visualization groups for a forum
	 * Ps.: The visualiation groups are access collection IDS.
	 *  
	 * @param $forum_guid Int The GUID of a forum
	 * @return Array Return an array of access_collection IDS
	 */
	function get_forum_allowed_visualization_groups($forum_guid) {
		if ($forum = get_entity($forum_guid))	{
			// The visualization groups are represented as multi metadatas called "visualization_groups"
			$visualization_groups = $forum->visualization_groups;
			if ($visualization_groups && !is_array($visualization_groups)) {
				$visualization_groups = array($visualization_groups);
			}
			
			// Get the access collection ID for each visualization group of the forum
			$return = array();
			foreach($visualization_groups as $visualization_group_guid) {
				if ($visualization_group_guid == 1 || $visualization_group_guid == 2) {
					// For the case of default groups: loggedin and public
					$return[] = $visualization_group_guid;
				} else {
					$group = get_entity($visualization_group_guid);
					$return[] = $group->group_acl;
				}
			}
			
			return $return;
		}

		return false;
	}
	
	/**
	 * Check if a group can see the forum content.
	 * Obs: If a forum don't have any visualization groups then the forum will have public visualization access
	 * 
	 * @param $forum_guid Int A GUID of a forum entity
	 * @param $group_guid Int A GUID of a group entity
	 * @return true | false Depends on success
	 */
	function group_can_see_forum($forum_guid,$group_guid) {
		if ($group = get_entity($group_guid)) {
			$allowed_visualization_groups = get_forum_allowed_visualization_groups($forum_guid);
			// If the the forum has visualization option setted as public or loggedin so all groups can see the forum
			if (in_array(1,$allowed_visualization_groups) || in_array(2,$allowed_visualization_groups))	{
				return true;
			}
			
			if (in_array($group->group_acl,$allowed_visualization_groups) && $allowed_visualization_groups) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Check if a group can post in the forum
	 * 
	 * @param $forum_guid Int A GUID of a forum entity
	 * @param $group_guid Int A GUID of a group entity
	 * @return true | false Depends on success
	 */
	function group_can_post_in_forum($forum_guid,$group_guid) {
		if ($group = get_entity($group_guid)) {
			$allowed_posting_groups = get_forum_allowed_posting_groups($forum_guid);
			
			// If the the forum has posting option setted as loggedin so all groups can post into the forum
			if (in_array(1,$allowed_posting_groups)) {
				return true;
			}
			
			if (in_array($group->group_acl,$allowed_posting_groups)) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Get a list of allowed edition groups for a forum.
	 * 
	 * @param $forum_guid Int A GUID of a forum entity
	 * @return Array Return an array of access_collection IDS
	 */
	function get_forum_allowed_posting_groups($forum_guid) {
		if ($forum = get_entity($forum_guid)) {
			// The edition groups are represented as multi metadatas called "edition_groups"
			$posting_groups = $forum->posting_groups;
			
			if ($posting_groups && !is_array($posting_groups)) {
				$posting_groups = array($posting_groups);
			}

			// Get the access collection ID for each posting group of the forum
			$return = array();
			foreach($posting_groups as $posting_group_guid) {
				if ($posting_group_guid == 1 || $posting_group_guid == 2) {
					$return[] = $posting_group_guid;
				} else {
					$group = get_entity($posting_group_guid);
					$return[] = $group->group_acl;
				}
			}
			return $return;
		}
		return false;		
	}
	
	/**
	 * Check if a group can moderate a forum
	 * 
	 * @param $forum_guid Int A GUID of a forum entity
	 * @param $group_guid Int A GUID of a group entity
	 * @return true | false Depends on success
	 */	
	function group_can_moderate_forum($forum_guid,$group_guid) {
		if ($group = get_entity($group_guid)) {
			$moderation_groups = get_forum_moderation_groups($forum_guid);
			// If the the forum has moderate option setted as loggedin so all groups can moderate the forum
			if (in_array(1,$moderation_groups)) {
				return true;
			}
			
			if (in_array($group->group_acl,$moderation_groups)) {
				return true;
			}
		}
		return false;		
	}

	/**
	 * Get a list of allowed moderation groups for a forum
	 * 
	 * @param $forum_guid Int A GUID of a forum entity
	 * @return Array Return an array of access_collection IDS
	 */	
	function get_forum_moderation_groups($forum_guid) {
		if ($forum = get_entity($forum_guid)) {
			// The edition groups are represented as multi metadatas called "edition_groups"
			$moderation_groups = $forum->moderation_groups;
			if ($moderation_groups && !is_array($moderation_groups)) {
				$moderation_groups = array($moderation_groups);
			}
			
			// Get the access collection ID for each visualization group of the forum
			$return = array();
			foreach($moderation_groups as $moderation_group_guid) {
				if ($moderation_group_guid == 1 || $moderation_group_guid == 2) {
					$return[] = $moderation_group_guid;
				} else {
					$group = get_entity($moderation_group_guid);
					$return[] = $group->group_acl;
				}
			}
			return $return;
		}
		return false;		
	}

	/**
	 * Get a list of subforums to a forum
	 * 
	 * @param $forum_guid Int A GUID of a forum entity
	 * @return Array Return an array of access_collection IDS
	 */	
	function get_subforums($forum_guid,$count=false,$recursive=false){
		if ($forum_guid) {
			$options = array(
				'count'=>$count,
				'types'=>'object',
				'subtypes'=>'forum',
				'container_guids'=>$forum_guid
				);
			$forums = elgg_get_entities($options);

			if ($recursive) {
				if ($count) {
					$options = array(
						'types'=>'object',
						'subtypes'=>'forum',
						'container_guids'=>$forum_guid
						);
					$subforums = elgg_get_entities($options);
				} else {
					$subforums = $forums;
				}				
				foreach($subforums as $subforum) {
					if ($count) {
						$forums += get_subforums($subforum->guid,true,false);
					} else {
						$forums = array_merge($forums,get_subforums($subforum->guid,false,false));
					}
				}
			}
			return $forums;
		}
		return false;
	}
	
	/**
	 * Get posts for a forum
	 * 
	 * @param $forum_guid Int A GUID  of a fourm
	 * @param $count If it's true than the funtion will return the number of posts only
	 */
	function get_posts($forum_guid,$options) {
		if ($forum_guid) {
			if (!is_array($options)) {
				$options = array();
			}
			// Set the defaults configuration for list posts
			$defaults = array(
				'container_guids'=>$forum_guid,
				'type'=>'object',
				'subtype'=>'post');
			// Merge the default configuration with the options chose by the user
			$options = array_merge($defaults,$options);
			
			if ($options['remove_important_topics']) {
				// Set the options for remove important topics from the result of elgg_get_entities()
				$options = remove_important_topic_options($options);
			}
			
			// Set the options for order the posts by the time that They became sticky
			$options = order_by_sticked_time($options);
			
			// If We are not getting important topics than let's execute the default code
			if (!$options['important_posts']) {
				$posts = get_ordered_posts_array($options);
			// If We are getting important topics then let's get them through the function elgg_get_entities_from_metadata()
			} else {
				$options['metadata_name_value_pairs'] = array('important_topic'=>'yes');
				$posts = elgg_get_entities_from_metadata($options);
			}
			
			// If the recursive options is setted up lets get the subforums and subposts
			if ($options['recursive']) {
				$subforums = get_subforums($forum_guid,false,false);
				foreach($subforums as $subforum) {
					if ($options['count']) {
						$posts += get_posts($subforum->guid,$options);
					} else {
						$posts = array_merge($posts,get_posts($subforum->guid,$options));
					}
				}
			}

			return $posts;
		}
		return false;
	}
	
	/**
	 * Try to get an array of posts ordered in accordance to $options['sort_by']
	 */
	function get_ordered_posts_array($options) {
		switch ($options['sort_by']) {
			case 'most_recent_asc':
				$options['order_by'] = ' e.time_created asc';
				break;
			case 'most_popular_desc':
				// Check if there is some views counting system
				if (trigger_plugin_hook('views_counting_system','plugin')) {
					$options['order_by'] = 'desc';
					// Ask for the entitites ordered by views counting triggering a hook
					$posts = trigger_plugin_hook('get_entities_by_views_counter_hook','plugin',$options); 
				}
				break;
			case 'most_popular_asc':
				// Check if there is some views counting system
				if (trigger_plugin_hook('views_counting_system','plugin')) {
					$options['order_by'] = 'asc';
					// Ask for the entitites ordered by views counting triggering a hook
					$posts = trigger_plugin_hook('get_entities_by_views_counter_hook','plugin',$options); 
				}
				break;
			case 'rate_average_desc':
				if (trigger_plugin_hook('rating_system','plugin')) {
					$options['order_by'] = 'desc';
					// Ask for the entitites ordered by rate average triggering a hook
					$posts = trigger_plugin_hook('get_entities_by_rate_average','plugin',$options);
				}
				break;
			case 'rate_average_asc':
				if (trigger_plugin_hook('rating_system','plugin')) {
					$options['order_by'] = 'asc';
					// Ask for the entitites ordered by rate average triggering a hook
					$posts = trigger_plugin_hook('get_entities_by_rate_average','plugin',$options);
				}
				break;
		}
		
		// If there is no posts got from the plugin hook then lets use the default get entities system
		if (!$posts) {
			$posts = elgg_get_entities($options);
		}
		
		return $posts;
	}
	/**
	 * Set the $options variable with specifics values for list imoportant topic entitites
	 * 
	 * @param $options
	 */
	function remove_important_topic_options($options){
		global $CONFIG;
		
		// Join the metadatas that inform if the topic is a important topic or no
		$important_string_id = get_metastring_id('important_topic');
		
		// If there is no important sring ID It is because this elgg installation never had any important topic, so there is no reason for remove them (and You will get a bug if You try)
		if($important_string_id) {
			$join = ' LEFT JOIN '.$CONFIG->dbprefix.'metadata m ON ((e.guid=m.entity_guid)AND(m.name_id='.$important_string_id.'))';
			if (is_array($options['joins'])) {
				$options['joins'][] = $join;
			} else if($options['joins']) {
				$options['joins'] = array($options['joins'],$join);
			} else {
				$options['joins'] = array($join);
			}
			
			// Select the columns that will be returned by the JOIN
			$select = 'm.*';
			if (is_array($options['selects'])) {
				$options['selects'][] = $select;
			} else if($options['selects']) {
				$options['selects'] = array($options['selects'],$select);
			} else {
				$options['selects'] = array($select);
			}
			
			// Remove the entities that has important_topic setted any value different of "yes" or NULL
			$yes_id = get_metastring_id('yes');
			
			if ($yes_id) {
				$options['wheres'] .= ' ((m.value_id!='.$yes_id.')||(ISNULL(m.value_id))) ';
			} else {
				$options['wheres'] .= ' ISNULL(m.value_id) ';
			}
		}
		
		return $options;
	}
	
	/**
	 * List posts for a forum
	 */
	function list_posts($forum_guid,$options) {
		if (!$options) {
			$options = array();
		}
		$defaults = array(
			'container_guids'=>$forum_guid,
			'type'=>'object',
			'subtype'=>'post',
			'offset'=>(int) max(get_input('offset', 0), 0),
			'limit'=>(int) max(get_input('limit', 10), 0),
			'full_view' => false,
			'view_type_toggle'=>'post_listing',
			'pagination'=>TRUE);
		$options = array_merge($defaults,$options);
		
		// If We are listing important topics then let's set another default configurations
		if ($options['important_posts']) {
			$options['pagination'] = false;
			$options['limit'] = 999999;
		}

		// Count how many posts We have for use It in the pagination system
		$posts_counter = get_posts($forum_guid,array_merge(array('count'=>true),$options));

		// Get the posts
		$posts = get_posts($forum_guid,$options);
		// Show the posts using the default elgg listing system
		return elgg_view_entity_list($posts, $posts_counter, $options['offset'],$options['limit'], $options['full_view'], $options['view_type_toggle'], $options['pagination']);
	}
	
	/**
	 * List posts marked as important
	 * 
	 * @param $forum_guid
	 * @param $options
	 */
	function list_important_posts($forum_guid,$options) {
		$defaults = array(
			'offset' => (int) max(get_input('offset', 0), 0),
			'limit' => (int) max(get_input('limit', 10), 0),
			'full_view' => TRUE,
			'view_type_toggle' => FALSE,
			'pagination' => TRUE
			);
		$options = array_merge($defaults, $options);

		$posts_counter = get_important_posts($forum_guid,true);
		$posts = get_important_posts($forum_guid);
	
		return elgg_view_entity_list($posts, $posts_counter, $options['offset'],
		$options['limit'], $options['full_view'], $options['view_type_toggle'], $options['pagination']);
	}
	
	/**
	 * Just an alias for get_posts()...
	 * 
	 * @param $forum_guid
	 * @param $count
	 * @param $recursive
	 */
	function get_topics($forum_guid,$count=false,$recursive=false) {
		return get_posts($forum_guid,$count,$recursive);
	}
	
	/**
	 * Get comments for forums and topics
	 * 
	 * @param $entity_guid
	 * @param $count
	 * @return Array | Int An array of comment entities or the number of comments
	 */
	function get_comments($entity_guid,$count=false,$recursive=false) {
		if ($entity = get_entity($entity_guid)) {
			$comments = 0;

			if ($entity->getSubtype() == 'forum') {
				$posts = get_posts($entity_guid);
				foreach($posts as $post) {
					if ($count) {
						$comments += get_comments($post->guid,true,false);
					} else {
						$comments = array_merge($comments,get_comments($post->guid,false,false));
					}
				}

				if ($recursive) {
					$subforums = get_subforums($entity_guid);
					foreach($subforums as $subforum) {
						if ($count) {
							$comments += get_comments($subforum->guid,$count,false);
						} else {
							$comments = array_merge($comments,get_comments($subforum->guid,$count,false));
						}
					}
				}
			} else {
				$comments = get_annotations($entity_guid,'object','post','comment','',0,999999,0,'desc');

				if (!is_array($comments) && $comments) {
					$comments = array($comments);
				}
				
				if ($count) {
					if (!empty($comments)) {
						$comments = count($comments);
					} else {
						return 0;
					}
				}
			}
			return $comments;
		}
		return false;
	}
	
	/**
	 * Get the main forum entity
	 * 
	 * @return Entity | false Returns the main forum entity
	 */
	function get_main_forum() {
		return get_entity(get_main_forum_guid());
	}

	/**
	 * 
	 * Enter description here ...
	 * @param $entity_guid
	 * @param $suffix
	 */
	function get_breadcrumbs($entity_guid,$suffix=false) {
		$html = '';
		
		if ($entity = get_entity($entity_guid)) {
			// If the entity have setted the container_guid
			if ($entity->container_guid != $entity->owner_guid) {
				$html .= get_breadcrumbs($entity->container_guid);
				$html .= ' -> ';
			} else {
				global $CONFIG;
				
				$all_forums = $CONFIG->wwwroot.'pg/forums/all/';
				$html .= '<a href="'.$all_forums.'">'.elgg_echo('forum:all_sessions').'</a> -> '; 
			}
			
			$html .= '<a href="'.$entity->getUrl().'">';
			$html .= $entity->title;
			$html .= '</a>';
			if ($suffix) {
				$html .= ' -> ';
				$html .= $suffix;
			}
			return $html;
		}
		return false;
	}

	/**
	 * Verify if a comment may be edited according with the owner and if the comment is the last
	 * comment created for its entity
	 * 
	 * @param $comment_id
	 * @param $user_guid
	 * @return true | false Depends on success
	 */
	function can_edit_comment($comment_id,$user_guid) {
		if ($comment = get_annotation($comment_id)) {
			// Admins can edit any comment
			if (isadminloggedin()) {
				return true;
			}

			// Get all comments for this topic
			$post_comments = get_annotations($comment->entity_guid);

			$last_comment = true;
			foreach($post_comments as $post_comment) {
				// If some comment was created after this comment so It is not the last comment
				if ($comment->time_created < $post_comment->time_created) {
					$last_comment = false;
				}
			}
			
			// If this comment don't is the last comment than It can't be edited
			if (!$last_comment) {
				return false;
			}
			
			if (!$user_guid) {
				$user = get_loggedin_user();
				$user_guid = $user->guid;
			}
			return can_edit_extender($comment->id,'annotation',$user_guid);
		}
		return false;
	}

	/**
	 * Returns a human-readable list of comments on a particular entity.
	 */
	function list_comments($entity_guid) {
		$entity = get_entity($entity_guid);
		return elgg_view('post/list_comments',array('entity'=>$entity));
	}
	
	/**
	 * Check if an user can post in a forum
	 * 
	 * @param $forum_guid
	 * @param $user_guid
	 * @return true | false Depends on success
	 */
	function can_post_in_forum($forum_guid,$user_guid) {
		if (!$user = get_entity($user_guid)) {
			if (!$user = get_loggedin_user()) {
				return false;
			}
		}
		
		if ($user->isAdmin()) {
			return true;
		}

		if ($posting_groups = get_forum_allowed_posting_groups($forum_guid)) {
			// If the the forum has posting option setted as loggedin so all users can post into the forum
			if (in_array(1,$allowed_groups)) {
				return true;
			}
			
			if ($access_array = get_access_array($user->guid)) {
				foreach($access_array as $access)	{
					if (in_array($access,$posting_groups)) {
						return true;
					}
				}
			}
		}
		return false;
	}
	
	/**
	 * Check if an user can moderate a forum
	 * 
	 * @param unknown_type $forum_guid
	 * @param unknown_type $user_guid
	 * @return boolean
	 */
	function can_moderate_forum($forum_guid,$user_guid) {
		if (!$user = get_entity($user_guid)) {
			if (!$user = get_loggedin_user()) {
				return false;
			}
		}
		
		if ($user->isAdmin()) {
			return true;
		}
		
		if ($moderation_groups = get_forum_moderation_groups($forum_guid)) {
			// If the the forum has moderate option setted as loggedin so all users can moderate the forum
			if (in_array(1,$allowed_groups)) {
				return true;
			}
			
			if ($access_array = get_access_array($user->guid)) {
				foreach($access_array as $access) {
					if (in_array($access,$moderation_groups))	{
						return true;
					}
				}
			}
		}
	}
	
	/**
	 * Handle the access to forums according to their settings
	 * 
	 * @param unknown_type $forum_guid
	 * @param unknown_type $user_guid
	 */
	function edit_forum_gatekeeper($forum_guid,$user_guid=false) {
		if (can_edit_forum($forum_guid,$user_guid)) {
			return true;
		}
		forward($_SERVER['HTTP_REFERER']);
	}
	
	/**
	 * Check if the user can see the forum content
	 * 
	 * @param $forum_guid
	 * @param $user_guid
	 */
	function can_edit_forum($forum_guid,$user_guid=false) {
		if (isadminloggedin()) {
			return true;
		}

		if (!$user = get_entity($user_guid)) {
			$user = get_loggedin_user();
		}
		
		if ($user) {
			$access_array = get_access_array($user->guid);
			$allowed_edition = get_forum_moderation_groups($forum_guid);
			
			if (!empty($allowed_edition)) {
				foreach($access_array as $access) {
					if (in_array($access,$allowed_edition)) {
						return true;
					}
				}
			}
		}
		return false;		
	}
		
	/**
	 * Get the base forums (forums that are not subforums)
	 * 
	 * @return Array A list of forums
	 */
	function get_forums($forum_guid) {
		// Getting the forum entities
		$options = array(
			'type'=>'object',
			'subtype'=>'forum',
			'full_view'=>false,
			'limit'=>999999,
			'container_guid'=>$forum_guid
			);
		$forums = elgg_get_entities($options);
		
		// Getting the GUIDS of returned forums
		$guids = array();
		foreach($forums as $forum) {
			$guids[] = $forum->guid;
		}
	
		// Getting the forums that are not subforums
		$base_forums = array();
		foreach ($forums as $forum) {
			if (!in_array($forum->container_guid,$guids)) {
				$base_forums[] = $forum;
			}
		}
		$base_forums = sort_forum_array($base_forums);
		
		return $base_forums;
	}
	
	/**
	 * Return a html string for visualization a array of forums
	 */
	function list_forums($forum_guid) {
		if ($forums = get_forums($forum_guid)) {
			return elgg_view_entity_list($forums,count($forums),0,999999,false,'',false);
		}
	}
	
	function sort_forum_array($forum_array)
	{
		$ordered_array = array();
		
		if (is_array($forum_array) && $forum_array) {
			$size = count($forum_array);
			
			if ($size > 1) {
				$m = floor($size/2);
				$left_array = array_slice($forum_array,0,$m);
				$right_array = array_slice($forum_array,$m);
				
				$left_array = sort_forum_array($left_array);
				$right_array = sort_forum_array($right_array);
				
				$i = 0;
				$j = 0;
				$k = 0;
				
				while($k < $size) {
					if ($left_array[$i] && $right_array[$j]) {
						if ($left_array[$i]->order <= $right_array[$j]->order) {
							$ordered_array[$k] = $left_array[$i];
							$i++;
						} else {
							$ordered_array[$k] = $right_array[$j];
							$j++;
						}
					} else if(!$left_array[$i]) {
						$ordered_array[$k] = $right_array[$j];
						$j++;
					} else {
						$ordered_array[$k] = $left_array[$i];
						$i++;
					}
					
					$k++;
				}
			} else {
				$ordered_array = $forum_array;
			}
		}

		return $ordered_array;
	}
	
	/**
	 * Add some options for list the entities in accordance to the sticky status
	 * 
	 * @param $options
	 */
	function order_by_sticked_time($options) {
		// Get the metastring_id for "stick"
		$metastring_id = get_metastring_id('stick');
		
		// If the metastring stick exists in the database
		if ($metastring_id) {
			global $CONFIG;
			
			// Join the metadata "stick" named as sm for each post
			$join = ' LEFT JOIN '.$CONFIG->dbprefix.'metadata sm ON ((e.guid=sm.entity_guid)AND(sm.name_id='.$metastring_id.'))';
			if (is_array($options['joins'])) {
				$options['joins'][] = $join;
			} else if($options['joins']) {
				$options['joins'] = array($options['joins'],$join);
			} else {
				$options['joins'] = array($join);
			}
			
			// Order by the time created of the stick metadata
			$options['order_by'] .= ' sm.time_created desc, e.time_created desc';
		} // If there is no metastring_id then We don't have to do anything
		
		return $options;
	}
	
	/**
	 * Check if a topic is updated for an specific user.
	 * 
	 * @param unknown_type $topic_guid
	 * @param unknown_type $user_guid
	 */
	function is_topic_updated($topic_guid,$user_guid) {
		$topic = get_entity($topic_guid);
		if(!$user = get_entity($user_guid)) {
			$user = get_loggedin_user();
		}

		if($topic && $user) {
			if (trigger_plugin_hook('views_counting_system','plugin')) {
				$params = array('entity'=>$topic,'user_guid'=>$user_guid);
				$last_view_time = trigger_plugin_hook('get_last_view_time_hook','plugin',$params,0);
				
				// If the last time that the user saw the entity is less than the last time that the entity was updated then the topic is updated to him
				return trigger_plugin_hook('did_see_last_update_hook','plugin',$params);
			}
		}
		
		return null;
	}
	
	function did_see_last_comment($topic_guid,$user_guid) {
		$topic = get_entity($topic_guid);

		if ($topic) {
			if (!$user = get_entity($user_guid)) {
				$user = get_loggedin_user();
			}

			if (trigger_plugin_hook('views_counting_system','plugin') && ($user)) {
				// Let's get all the comments NOT CREATED by this user
				$comment_string = get_metastring_id('comment');
				if ($comment_string) {
					global $CONFIG;
					$query = ' SELECT a.* FROM '.$CONFIG->dbprefix.'annotations a WHERE (a.name_id='.$comment_string.')AND(a.entity_guid='.$topic_guid.')AND(a.owner_guid!='.$user->guid.')AND';
					$query .= get_access_sql_suffix("a");
					$query .=  ' ORDER BY a.time_created desc ';
					$comments = get_data($query, "row_to_elggannotation");
				}

				if ($comments) {
					$last_comment = $comments[0];
					
					$params = array('entity'=>$topic);
					$last_view_time = trigger_plugin_hook('get_last_view_time_hook','plugin',$params);
					if (($last_view_time > $last_comment->time_created) && ($last_view_time)) {
						return true;
					} else {
						false;
					}
				} else {
					return true;
				}
			} else {
				// If there is no views counting system or if there is no loggedin user then return true because It will be not good if all topics shows the icon: "new comment"
				return true;
			}
		}
		
		return null;
	}
?>