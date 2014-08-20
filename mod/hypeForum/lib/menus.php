<?php

// Site menu
elgg_register_menu_item('site', array(
	'name' => 'forum',
	'text' => elgg_echo('forums'),
	'href' => 'forum',
));

elgg_register_plugin_hook_handler('register', 'menu:entity', 'hj_forum_entity_menu');
elgg_register_plugin_hook_handler('register', 'menu:title', 'hj_forum_entity_title_menu');
elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'hj_forum_owner_block_menu');

/**
 * Forum menus
 */
function hj_forum_entity_menu($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, false);

	if (!elgg_instanceof($entity))
		return $return;

	switch ($entity->getSubtype()) {

		default :
			return $return;
			break;

		case 'hjforum' :

			if (HYPEFORUM_SUBSCRIPTIONS && elgg_is_logged_in()) {
				$items['subscription'] = array(
					'text' => ($entity->isSubscribed()) ? elgg_echo('hj:forum:subscription:remove') : elgg_echo('hj:forum:subscription:create'),
					'href' => $entity->getSubscriptionURL(),
					'class' => 'elgg-button-forum-subscription',
					'priority' => 500
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforum') && HYPEFORUM_SUBFORUMS) {
				$items['create:subforum'] = array(
					'text' => elgg_echo('hj:forum:create:subforum'),
					'href' => "forum/create/forum/$entity->guid",
					'class' => 'elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforumtopic')) {
				$items['create:topic'] = array(
					'text' => elgg_echo('hj:forum:create:topic'),
					'href' => "forum/create/topic/$entity->guid",
					'class' => 'elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 855
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforumcategory') && HYPEFORUM_CATEGORIES && $entity->enable_subcategories) {
				$items['create:category'] = array(
					'text' => elgg_echo('hj:forum:create:category'),
					'href' => "forum/create/category/$entity->guid",
					'class' => 'elgg-button-create-entity',
					'data-callback' => 'refresh:lists::framework',
					'data-toggle' => 'dialog',
					'priority' => 860
				);
			}

			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'data-uid' => $entity->guid,
					'priority' => 995
				);
				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}
			break;

		case 'hjforumtopic' :

			if (HYPEFORUM_SUBSCRIPTIONS && elgg_is_logged_in()) {
				$items['subscription'] = array(
					'text' => ($entity->isSubscribed()) ? elgg_echo('hj:forum:subscription:remove') : elgg_echo('hj:forum:subscription:create'),
					'href' => $entity->getSubscriptionURL(),
					'class' => ($entity->isSubscribed()) ? 'elgg-button-forum-subscription elgg-state-active' : 'elgg-button-forum-subscription',
					'priority' => 500
				);
			}

			if (HYPEFORUM_BOOKMARKS && elgg_is_logged_in()) {
				$items['bookmark'] = array(
					'text' => ($entity->isBookmarked()) ? elgg_echo('hj:forum:bookmark:remove') : elgg_echo('hj:forum:bookmark:create'),
					'href' => $entity->getBookmarkURL(),
					'class' => ($entity->isBookmarked()) ? 'elgg-button-forum-bookmark elgg-state-active' : 'elgg-button-forum-bookmark',
					'priority' => 500
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforumpost')) {
				$items['create:forumpost'] = array(
					'text' => elgg_echo('hj:forum:create:post'),
					'href' => "forum/create/post/$entity->guid#reply",
					'class' => 'elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
				$items['create:forumpost:quote'] = array(
					'text' => elgg_echo('hj:forum:create:post:quote'),
					'href' => "forum/create/post/$entity->guid?quote=$entity->guid#reply",
					'class' => 'elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
			}
			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'data-uid' => $entity->guid,
					'priority' => 995
				);
				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}
			break;


		case 'hjforumpost' :
			$topic = $entity->getContainerEntity();
			if ($topic->canWriteToContainer(0, 'object', 'hjforumpost')) {
				$items['create:forumpost:quote'] = array(
					'text' => elgg_echo('hj:forum:create:post:quote'),
					'href' => "forum/create/post/$topic->guid?quote=$entity->guid#reply",
					'class' => 'elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
			}

			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'data-uid' => $entity->guid,
					'priority' => 995
				);
				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}
			break;

		case 'hjforumcategory' :

			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'editedcategory::framework:forum',
					'data-uid' => $entity->guid,
					'priority' => 850
				);
				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}

			break;
	}

	if ($items) {
		foreach ($items as $name => $item) {
			foreach ($return as $key => $val) {
				if (!$val instanceof ElggMenuItem) {
					unset($return[$key]);
				}
				if ($val instanceof ElggMenuItem && $val->getName() == $name) {
					unset($return[$key]);
				}
			}
			$item['name'] = $name;
			$return[$name] = ElggMenuItem::factory($item);
		}
	}

	return $return;
}

function hj_forum_entity_title_menu($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, false);

	if (!elgg_instanceof($entity))
		return $return;

	switch ($entity->getSubtype()) {

		case 'hjforum' :

			if (HYPEFORUM_SUBSCRIPTIONS) {
				$items['subscription'] = array(
					'text' => ($entity->isSubscribed()) ? elgg_echo('hj:forum:subscription:remove') : elgg_echo('hj:forum:subscription:create'),
					'href' => $entity->getSubscriptionURL(),
					'class' => ($entity->isSubscribed()) ? 'elgg-button elgg-button-action elgg-button-forum-subscription elgg-state-active' : 'elgg-button elgg-button-action elgg-button-forum-subscription',
					'priority' => 500
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforum') && HYPEFORUM_SUBFORUMS) {
				$items['create:subforum'] = array(
					'text' => elgg_echo('hj:forum:create:subforum'),
					'href' => "forum/create/forum/$entity->guid",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforumtopic')) {
				$items['create:topic'] = array(
					'text' => elgg_echo('hj:forum:create:topic'),
					'href' => "forum/create/topic/$entity->guid",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 855
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforumcategory') && HYPEFORUM_CATEGORIES && $entity->enable_subcategories) {
				$items['create:category'] = array(
					'text' => elgg_echo('hj:forum:create:category'),
					'href' => "forum/create/category/$entity->guid",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'priority' => 860
				);
			}

			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button elgg-button-action elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-uid' => $entity->guid,
					'priority' => 995
				);

				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button elgg-button-delete elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}

			break;

		case 'hjforumtopic' :

			if (HYPEFORUM_SUBSCRIPTIONS && !$entity->getContainerEntity()->isSubscribed()) {
				$items['subscription'] = array(
					'text' => ($entity->isSubscribed()) ? elgg_echo('hj:forum:subscription:remove') : elgg_echo('hj:forum:subscription:create'),
					'href' => $entity->getSubscriptionURL(),
					'class' => ($entity->isSubscribed()) ? 'elgg-button-forum-subscription elgg-state-active' : 'elgg-button-forum-subscription',
					'priority' => 500
				);
			}

			if (HYPEFORUM_BOOKMARKS) {
				$items['bookmark'] = array(
					'text' => ($entity->isBookmarked()) ? elgg_echo('hj:forum:bookmark:remove') : elgg_echo('hj:forum:bookmark:create'),
					'href' => $entity->getBookmarkURL(),
					'class' => ($entity->isBookmarked()) ? 'elgg-button elgg-button-action elgg-button-forum-bookmark elgg-state-active' : 'elgg-button elgg-button-action elgg-button-forum-bookmark',
					'priority' => 500
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforumpost')) {
				$items['create:forumpost'] = array(
					'text' => elgg_echo('hj:forum:create:post'),
					'href' => "forum/create/post/$entity->guid#reply",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
				$items['create:forumpost:quote'] = array(
					'text' => elgg_echo('hj:forum:create:post:quote'),
					'href' => "forum/create/post/$entity->guid?quote=$entity->guid#reply",
					'parent_name' => 'options',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
			}

			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button elgg-button-action elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-uid' => $entity->guid,
					'priority' => 995
				);

				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button elgg-button-delete elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}
			break;
	}

	if ($items) {
		foreach ($items as $name => $item) {
			foreach ($return as $key => $val) {
				if (!$val instanceof ElggMenuItem) {
					unset($return[$key]);
				}
				if ($val instanceof ElggMenuItem && $val->getName() == $name) {
					unset($return[$key]);
				}
			}
			$item['name'] = $name;
			$return[$name] = ElggMenuItem::factory($item);
		}
	}

	return $return;
}

function hj_forum_register_dashboard_title_buttons($dashboard = 'site') {

	switch ($dashboard) {

		case 'site' :

			if (elgg_is_admin_logged_in()) {

				$site = elgg_get_site_entity();

				elgg_register_menu_item('title', array(
					'name' => 'create:forum',
					'text' => elgg_echo('hj:forum:create:forum'),
					'href' => "forum/create/forum/$site->guid",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 100
				));

				if (HYPEFORUM_CATEGORIES_TOP) {
					elgg_register_menu_item('title', array(
						'name' => 'create:category',
						'text' => elgg_echo('hj:forum:create:category'),
						'href' => "forum/create/category/$site->guid",
						'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
						'data-callback' => 'newcategory::framework:forum',
						'data-toggle' => 'dialog',
						'priority' => 200
					));
				}
			}

			break;

		case 'group' :

			$group = elgg_get_page_owner_entity();

			if ($group->canWriteToContainer()) {
				elgg_register_menu_item('title', array(
					'name' => 'create:forum',
					'text' => elgg_echo('hj:forum:create:forum'),
					'href' => "forum/create/forum/$group->guid",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 100
				));

				if (HYPEFORUM_CATEGORIES_TOP) {
					elgg_register_menu_item('title', array(
						'name' => 'create:category',
						'text' => elgg_echo('hj:forum:create:category'),
						'href' => "forum/create/category/$group->guid",
						'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
						'data-callback' => 'newcategory::framework:forum',
						'data-toggle' => 'dialog',
						'priority' => 200
					));
				}
			}
			break;
	}
}

function hj_forum_owner_block_menu($hook, $type, $return, $params) {
	$entity = elgg_extract('entity', $params);

	if (HYPEFORUM_GROUP_FORUMS && elgg_instanceof($entity, 'group') && $entity->forums_enable !== 'no') {
		$return[] = ElggMenuItem::factory(array(
					'name' => 'group:forums',
					'text' => elgg_echo('hj:forum:group'),
					'href' => "forum/group/$entity->guid"
				));
	}

	return $return;
}