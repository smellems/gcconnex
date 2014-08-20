<?php
	/**
	 * @file start.php
	 * @brief Set the forum settings into elgg system
	 */

	/**
	 * Set plugin forum into elgg system
	 */
	function forum_init() {
		global $CONFIG;
		
		can_edit_entity(4);
		
		elgg_extend_view('css','forum/css');
		register_translations($CONFIG->pluginspath.'forum/languages',true);
		
		register_page_handler('forums','forums_page_handler');
		register_page_handler('post','post_page_handler');
		
		register_entity_url_handler('forum_url_handler','object','forum');
		register_entity_url_handler('post_url_handler','object','post');
	}

	// Include the forum plugin functions
	require_once('lib/forum.php');

	/**
	 * Set forum menu and submenu links into elgg system
	 */
	function forum_pagesetup() {
		global $CONFIG;

		if (get_forums()) {
			if (!get_main_forum_guid() || (get_plugin_setting('enable_main_forum_concept','forum') != 'yes')) {
				add_menu(elgg_echo('forum'),$CONFIG->wwwroot.'pg/forums/all');
			} else {
				add_menu(elgg_echo('forum'),$CONFIG->wwwroot.'pg/forums');
			}
		}
		
		if (isadminloggedin()) {
			// If It is the administration page then display the documentation link
			if (get_context() == "admin") {
				// Add the all forums link in the left sidebar column
				add_submenu_item(elgg_echo('forum:view_all_forums'),$CONFIG->wwwroot.'pg/forums/all','forum');
				add_submenu_item(elgg_echo('forum:doc'),$CONFIG->wwwroot.'mod/forum/doc/index.html','forum');
			// If It is some page of forum plugin then display the create new forum link
			} else if (get_context() == "forum") {
				// Add the all forums link in the left sidebar column
				add_submenu_item(elgg_echo('forum:view_all_forums'),$CONFIG->wwwroot.'pg/forums/all','forum');
				// Get the guid for the current forum being displayed and create a subforum but if there is no forum being displayed then just create a new independent forum
				$entity_guid = get_input('entity_guid','');
				add_submenu_item(elgg_echo('forum:new_forum'),$CONFIG->wwwroot.'pg/forums/new/'.$entity_guid,'forum');
			}
		}
	}

	/**
	 * Handle the forum pages
	 * 
	 * @param $page
	 */
	function forums_page_handler($page) {
		global $CONFIG;

		if (isset($page[0])) {
			switch($page[0]) {
				case 'all':
					include($CONFIG->pluginspath.'forum/all_forums.php');
					break;
					
				case 'new':
					// If We are creating a subforum then pass the container forum guid as an elgg input for the next files
					set_input('container_forum_guid',$page[1]);					
					include($CONFIG->pluginspath.'forum/edit_forum.php');
					break;
				
				case 'edit':
					set_input('entity_guid',$page[1]);
					include($CONFIG->pluginspath.'forum/edit_forum.php');
					break;
					
				default:
					// If the URL is fine, try to display the forum
					if (is_numeric($page[0])) {
						set_input('entity_guid',$page[0]);
						
						set_input('sort_by',$page[1]);
						// Displays the forum full view page
						include($CONFIG->pluginspath.'forum/forum_view.php');
					} else {
						// Displays the wrong url page
						include($CONFIG->pluginspath.'forum/wrong_url.php');
					}
					break;
			}
		} else {
			// Displays the forum full view page
			include($CONFIG->pluginspath.'forum/forum_view.php');
		}
	}

	/**
	 * Return the URL to access a forum entity
	 * 
	 * @param $entity
	 */
	function forum_url_handler($entity) {
		global $CONFIG;
		
		$url = $CONFIG->wwwroot.'pg/forums/'.$entity->guid;
		
		return $url;
	}

	/**
	 * Return the URL to access a post entity
	 * 
	 * @param $entity
	 */
	function post_url_handler($entity) {
		global $CONFIG;
		
		$url = $CONFIG->wwwroot.'pg/post/'.$entity->guid;
		
		return $url;
	}

	/**
	 * Handle the post pages
	 * 
	 * @param $page
	 */
	function post_page_handler($page) {
		global $CONFIG;

		if (isset($page[0])) {
			switch($page[0]) {
				case 'new':
					set_input('forum_guid',$page[1]);					
					include($CONFIG->pluginspath.'forum/edit_post.php');
					break;

				case 'edit':
					set_input('entity_guid',$page[1]);					
					include($CONFIG->pluginspath.'forum/edit_post.php');
					break;

				default:
					set_input('entity_guid',$page[0]);

					// If the user is editing some comment than pass the comment id for the views
					$comment_id = explode('#',$page[2]);
					set_input('comment_id',$comment_id[0]);

					include($CONFIG->pluginspath.'forum/post_view.php');
					break;
			}
		}
	}

	/**
	 * Handle allowed users to post into a forum
	 *  
	 * @param $hook
	 * @param $type
	 * @param $returnvalue
	 * @param $params
	 */
	function create_posts_permissions_check($hook,$type,$returnvalue,$params) {
		if (can_post_in_forum($params['container']->guid,$params['user']->guid) || $params['container']->guid == $params['user']->guid) {
			return true;
		}
	}

	/**
	 * Check if an user can edit a post:
	 * A user can edit a post if: He is the owner, He is a admin or He can moderate the forum that the post belongs
	 * 
	 * @param $hook
	 * @param $type
	 * @param $returnvalue
	 * @param $params
	 */
	function edit_posts_permissions_check($hook,$type,$returnvalue,$params) {
		if ($params['entity']) {
			if ($params['entity']->getSubtype()=='post') {
				if (($params['entity']->owner_guid == $params['user']->guid) || (can_moderate_forum($params['entity']->container_guid)) || (isadminloggedin())) {
					return true;
				}
			}
		}
	}
	
	register_elgg_event_handler('init','system','forum_init');
	register_elgg_event_handler('pagesetup','system','forum_pagesetup');
	
	register_plugin_hook('container_permissions_check','object','create_posts_permissions_check');
	
	register_plugin_hook('permissions_check','object','edit_posts_permissions_check');

	global $CONFIG;

	register_action('forum/edit_forum',false,$CONFIG->pluginspath.'forum/actions/edit_forum.php',true);
	register_action('forum/edit_post',false,$CONFIG->pluginspath.'forum/actions/edit_post.php');
	register_action('forum/delete_entity',false,$CONFIG->pluginspath.'forum/actions/delete_entity.php');
	register_action('forum/edit_comment',false,$CONFIG->pluginspath.'forum/actions/edit_comment.php');
	register_action('forum/delete_comment',false,$CONFIG->pluginspath.'forum/actions/delete_comment.php');
	register_action('post/close_topic',false,$CONFIG->pluginspath.'forum/actions/close_topic.php');
	register_action('post/stick',false,$CONFIG->pluginspath.'forum/actions/stick_topic.php');
	register_action('post/important',false,$CONFIG->pluginspath.'forum/actions/important_status.php');
?>