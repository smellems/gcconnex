<?php

/* hypeForum
 *
 * Forum functionality for Elgg
 * @package hypeJunction
 * @subpackage hypeForum
 *
 * @author Ismayil Khayredinov <ismayil.khayredinov@gmail.com>
 * @copyright Copyrigh (c) 2011, Ismayil Khayredinov
 */

elgg_register_event_handler('init', 'system', 'hj_forum_init');

function hj_forum_init() {

	$plugin = 'hypeForum';

	if (!elgg_is_active_plugin('hypeFramework')) {
		register_error(elgg_echo('hj:framework:disabled', array($plugin, $plugin)));
		disable_plugin($plugin);
	}

	$shortcuts = hj_framework_path_shortcuts($plugin);

// Libraries
	elgg_register_library('hj:forum:base', $shortcuts['lib'] . 'forum/base.php');
	elgg_register_library('hj:forum:setup', $shortcuts['lib'] . 'forum/setup.php');

// Load PHP library
	elgg_load_library('hj:forum:base');

// Register pagehandlers for the forum
	elgg_register_entity_url_handler('object', 'hjforumtopic', 'hj_forumtopic_url_handler');

	elgg_register_page_handler('forum', 'hj_forum_page_handler');

	elgg_register_menu_item('site', array(
		'name' => 'forum',
		'text' => elgg_echo('forum'),
		'href' => 'forum',
	));

	$css_url = elgg_get_simplecache_url('css', 'hj/forum/base');
	elgg_register_css('hj.forum.base', $css_url);

	$js_url = elgg_get_simplecache_url('js', 'hj/forum/base');
	elgg_register_js('hj.forum.base ', $js_url);

	// Allow writing to hjforum containers
	elgg_register_plugin_hook_handler('container_permissions_check', 'object', 'hj_forum_container_permissions_check');

	elgg_register_widget_type('hjforumtopic', elgg_echo('hj:forum:widget'), elgg_echo('hj:forum:widgetdescription'), 'forum', true);
	elgg_register_plugin_hook_handler('hj:framework:widget:types', 'all', 'hj_forum_get_forum_section_types_hook');

//Check if the initial setup has been performed, if not porform it
	if (!elgg_get_plugin_setting('hj:forum:setup', 'hypeForum')) {
		elgg_load_library('hj:forum:setup');
		if (hj_forum_setup()) {
			system_message('hypeForum was successfully configured');
		}
	}

	elgg_register_plugin_hook_handler('register', 'menu:hjentityhead', 'hj_forum_entity_menu');
	elgg_register_plugin_hook_handler('register', 'menu:hjsegmenthead', 'hj_forum_main_menu');
	elgg_register_plugin_hook_handler('register', 'menu:hjsectionfoot', 'hj_forum_topic_menu');

	elgg_register_event_handler('create', 'object', 'hj_forum_topic_segment_setup');
	elgg_register_event_handler('update', 'object', 'hj_forum_topic_segment_setup');

	elgg_register_entity_type('object', 'hjforumtopic');
	elgg_register_plugin_hook_handler('search_types', 'get_types', 'hj_forum_custom_types_posts_hook');
	elgg_register_plugin_hook_handler('search', 'hjforumpost', 'hj_forum_search_posts_hook');

	elgg_register_plugin_hook_handler('hj:framework:field:process', 'all', 'hj_forum_add_last_action');

	register_notification_object('object', 'hjforumpost', elgg_echo('hj:forum:newpost'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'hj_forum_notify_message');
}

function hj_forumtopic_url_handler($entity) {
	return "forum/$entity->guid";
}

function hj_forum_page_handler($page) {
	$plugin = 'hypeForum';
	$shortcuts = hj_framework_path_shortcuts($plugin);
	$pages = $shortcuts['pages'] . 'forum/';

	elgg_load_css('hj.forum.base');
	elgg_load_js('hj.forum.base');

	if ($page[0] == 'sync') {
		include "{$pages}sync.php";
		return true;
	}

	$entity_guid = elgg_extract(0, $page, false);
	$entity = get_entity($entity_guid);

	if (!$entity) {
		include "{$pages}forum.php";
		return true;
	}

	if ($entity->children && $entity->children == 'forumtopic') {
		$segment_container_guid = $entity->guid;
	} else {
		$segment_container_guid = $entity->container_guid;
	}
	$segments = hj_framework_get_entities_by_priority('object', 'hjsegment', null, $segment_container_guid);

	if (is_array($segments)) {
		$bread = true;
		$crumb = $segments[0];
		$crumbs[] = $crumb;
		while ($bread) {
			if (elgg_instanceof($crumb, 'object', 'hjforumtopic')) {
				$crumbs[] = $crumb;
			}
			$crumb = get_entity($crumb->container_guid);
			if (!elgg_instanceof($crumb, 'object', 'hjsegment') && !elgg_instanceof($crumb, 'object', 'hjforumtopic')) {
				$bread = false;
			}
		}
		for ($i = sizeof($crumbs) - 1; $i > 0; $i--) {
			elgg_push_breadcrumb($crumbs[$i]->title, $crumbs[$i]->getURL());
		}
	}

	set_input('e', $entity_guid);

	if ($entity->children && $entity->children == 'forumtopic') {
		include "{$pages}forum.php";
		return true;
	} else {
		include "{$pages}topic.php";
		return true;
	}
}

function hj_forum_container_permissions_check($hook, $type, $return, $params) {
	$container = elgg_extract('container', $params, false);
	$subtype = elgg_extract('subtype', $params, false);

	if (elgg_instanceof($container, 'object', 'hjforumtopic')
			|| $subtype == 'hjforumtopic') {
		return true;
	}

	return $return;
}

function hj_forum_get_forum_section_types_hook($hook, $type, $return, $params) {
	$context = elgg_extract('context', $params, false);

	if ($context && $context == 'forum') {
		$return = array('hjforumtopic');
	}
	return $return;
}

function hj_forum_entity_menu($hook, $type, $return, $params) {
	$entity = elgg_extract('entity', $params);

	if (elgg_instanceof($entity, 'object', 'hjforumtopic') && $entity->canAnnotate()) {
		$data = hj_framework_json_query($params['reply_params']);
		unset($params['reply_params']);

		$reply = array(
			'name' => 'reply',
			'title' => elgg_echo('hj:forum:reply'),
			'text' => elgg_view('input/button', array('value' => elgg_echo('hj:forum:reply'), 'class' => 'elgg-button-action')),
			'rel' => 'fancybox',
			'href' => "action/framework/entities/edit",
			'data-options' => $data,
			'class' => "hj-ajaxed-edit",
			'priority' => 300
		);
		$return[] = ElggMenuItem::factory($reply);
	}

	if (elgg_instanceof($entity, 'object', 'hjforumtopic') && $entity->canAdminister()) {
		$params = hj_framework_extract_params_from_params($params['params']);
		$data = hj_framework_json_query($params);

		$edit = array(
			'name' => 'edit',
			'title' => elgg_echo('hj:framework:edit'),
			'text' => elgg_view('input/button', array('value' => elgg_echo('hj:framework:edit'), 'class' => 'elgg-button-action')),
			'rel' => 'fancybox',
			'href' => "action/framework/entities/edit",
			'data-options' => $data,
			'class' => "hj-ajaxed-edit",
			'priority' => 800
		);
		$return[] = ElggMenuItem::factory($edit);

// AJAXed Delete Button
		$delete = array(
			'name' => 'delete',
			'title' => elgg_echo('hj:framework:delete'),
			'text' => elgg_view('input/button', array('value' => elgg_echo('hj:framework:delete'), 'class' => 'elgg-button-action')),
			'href' => "action/framework/entities/delete?e=$entity->guid",
			'class' => 'hj-ajaxed-remove',
			'id' => "hj-ajaxed-remove-{$entity->guid}",
			'priority' => 900,
		);
		$return[] = ElggMenuItem::factory($delete);
	}

	return $return;
}

function hj_forum_main_menu($hook, $type, $return, $params) {

// Extract available parameters
	$entity = elgg_extract('entity', $params);

	$container_guid = elgg_extract('container_guid', $params['params']);
	$container = get_entity($container_guid);

	$section = elgg_extract('subtype', $params['params']);
	$handler = elgg_extract('handler', $params['params']);

	$data = hj_framework_json_query($params);
	$url = hj_framework_http_build_query($params);

	if (elgg_instanceof($entity, 'object', 'hjsegment') && $entity->handler == 'hjforumtopic') {
		$return = array();
	}

	if (elgg_instanceof($container, 'object', 'hjforumtopic') && $container->canAdminister()) {
// Add widget
		$widget = array(
			'name' => 'widget',
			'title' => elgg_echo('hj:forum:addnewcategory'),
			'text' => elgg_view('input/button', array('value' => elgg_echo('hj:forum:addnewcategory'), 'class' => 'elgg-button-action')),
			'href' => "action/framework/widget/add",
			'data-options' => $data,
			'id' => "hj-ajaxed-addwidget-{$entity->guid}",
			'class' => "hj-ajaxed-addwidget",
			'target' => "#elgg-object-{$entity->guid}",
			'priority' => 100
		);
		$return[] = ElggMenuItem::factory($widget);

		$cont_params = hj_framework_extract_params_from_entity($container);
		$cont_params['target'] = "elgg-object-$container->guid";
		$data = hj_framework_json_query($cont_params);


		$edit = array(
			'name' => 'edit',
			'title' => elgg_echo('hj:framework:edit'),
			'text' => elgg_view('input/button', array('value' => elgg_echo('hj:framework:edit'), 'class' => 'elgg-button-action')),
			'rel' => 'fancybox',
			'href' => "action/framework/entities/edit",
			'data-options' => $data,
			'class' => "hj-ajaxed-edit",
			'priority' => 800
		);
		$return[] = ElggMenuItem::factory($edit);

// AJAXed Delete Button
		$delete = array(
			'name' => 'delete',
			'title' => elgg_echo('hj:framework:delete'),
			'text' => elgg_view('input/button', array('value' => elgg_echo('hj:framework:delete'), 'class' => 'elgg-button-action')),
			'href' => "action/framework/entities/delete?e=$container->guid",
			'class' => 'hj-ajaxed-remove',
			'id' => "hj-ajaxed-remove-{$entity->guid}",
			'priority' => 900,
		);
		$return[] = ElggMenuItem::factory($delete);
	}

	return $return;
}

function hj_forum_topic_menu($hook, $type, $return, $params) {

	$container_guid = elgg_extract('container_guid', $params['params']);
	$container = get_entity($container_guid);

	$widget_guid = elgg_extract('widget_guid', $params['params']);
	$widget = get_entity($widget_guid);

	$segment_guid = elgg_extract('segment_guid', $params['params']);
	$segment = get_entity($segment_guid);

	$section = elgg_extract('subtype', $params['params']);

	$data = hj_framework_json_query($params);

	if ($container && elgg_instanceof($container) && $section == 'hjforumtopic' && elgg_is_logged_in()) {
		$return = array();
		if ($container->canAdminister() || ($container->status == 'open' && $container->getContainerEntity()->getSubtype() == 'hjforumtopic')) {
// AJAXed Add Button
			$add = array(
				'name' => 'add',
				'title' => elgg_echo('hj:forum:addnewforumtopic'),
				'text' => elgg_view('input/button', array('value' => elgg_echo('hj:forum:addnewforumtopic'), 'class' => 'elgg-button-action')),
				'href' => "action/framework/entities/edit",
				'data-options' => $data,
				'is_action' => true,
				'rel' => 'fancybox',
				'class' => "hj-ajaxed-add",
				'priority' => 200);
			$return[] = ElggMenuItem::factory($add);
		}
	}

	return $return;
}

function hj_forum_topic_segment_setup($event, $object_type, $entity) {

	if ($entity->getSubtype() == 'hjforumtopic') {
		$forum = $entity;

		$segments = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'hjsegment',
			'container_guid' => $forum->guid,
			'limit' => 1
				));

		$segment = new ElggObject($segments[0]->guid);
		$segment->title = $forum->title;
		$segment->access_id = $forum->access_id;
		$segment->owner_guid = $forum->owner_guid;
		$segment->subtype = 'hjsegment';
		$segment->container_guid = $forum->guid;
		$segment_guid = $segment->save();

		$segment->priority = 1;
		$segment->handler = 'hjforumtopic';

		if ($segment_guid) {
			$segment = get_entity($segment_guid);
			$segment->addWidget('hjforumtopic', null, 'forum');
		}
	}

	return true;
}

function hj_forum_custom_types_posts_hook($hook, $type, $return, $params) {
	$return[] = 'hjforumpost';
	return $return;
}

function hj_forum_search_posts_hook($hook, $type, $value, $params) {
	$db_prefix = elgg_get_config('dbprefix');

	$query = sanitise_string($params['query']);
	$limit = sanitise_int($params['limit']);
	$offset = sanitise_int($params['offset']);

	$params['type_subtype_pairs'] = array('object' => 'hjannotation');
	$params['metadata_name_value_pairs'] = array(
		'name' => 'annotation_name', 'value' => 'hjforumpost', 'operand' => '='
	);

	$params['joins'] = array(
		"JOIN {$db_prefix}metadata md on e.guid = md.entity_guid",
		"JOIN {$db_prefix}metastrings msn_n on md.name_id = msn_n.id",
		"JOIN {$db_prefix}metastrings msv_n on md.value_id = msv_n.id"
	);

	$fields = array('string');
	$params['wheres'] = array(
		"(msn_n.string = 'annotation_value')",
		search_get_where_sql('msv_n', $fields, $params, FALSE)
	);

	$params['count'] = TRUE;
	$count = elgg_get_entities_from_metadata($params);

	// no need to continue if nothing here.
	if (!$count) {
		return array('entities' => array(), 'count' => $count);
	}

	$params['count'] = FALSE;
	$entities = elgg_get_entities_from_metadata($params);

	// add the volatile data for why these entities have been returned.
	foreach ($entities as $key => $entity) {
		$desc = search_get_highlighted_relevant_substrings($entity->annotation_value, $params['query']);
		$entity->setVolatileData('search_annotation_value', $desc);
	}

	return array(
		'entities' => $entities,
		'count' => $count,
	);
}

function hj_forum_add_last_action($hook, $type, $return, $params) {
	$entity = elgg_extract('entity', $params, false);

	if (elgg_instanceof($entity, 'object', 'hjannotation') && $entity->annotation_name == 'hjforumpost') {
		$forum = get_entity($entity->container_guid);
		$check = true;
		$parent = $forum;
		while ($check) {
			update_entity_last_action($parent->guid, time());
			$parent = $parent->getContainerEntity();
			if (elgg_instanceof($parent, 'object', 'hjforumtopic')) {
				$return = $parent;
			} else {
				$check = false;
			}
		}
	}
	return $return;
}