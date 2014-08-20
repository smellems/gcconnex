<?php

namespace hypeJunction\Places;

/**
 * Digital products pagehandler
 *
 * @param array $page		Array of URL segments
 * @param string $handler	Handler name
 * @return boolean
 */
function page_handler($page, $handler) {

	elgg_push_breadcrumb(elgg_echo('places'), $handler);

	$context = elgg_extract(0, $page, 'all');

	switch ($context) {

		case 'all' :
		case 'featured' :

			elgg_register_title_button('places', 'create');

			$title = elgg_echo("places:$context");
			elgg_push_breadcrumb($title);

			$vars = array(
				'filter_context' => $context
			);

			$content = elgg_view('framework/places/list', $vars);
			$filter = elgg_view('framework/places/filter', $vars);
			$sidebar = elgg_view('framework/places/sidebar', $vars);
			break;

		case 'owner' :

			$username = $page[1];
			if ($username) {
				$user = get_user_by_username($username);
			} else if (elgg_is_logged_in()) {
				$user = elgg_get_logged_in_user_entity();
			}

			elgg_set_page_owner_guid($user->guid);

			if (elgg_get_logged_in_user_guid() == $user->guid) {
				elgg_register_title_button('places', 'create');
				$title = elgg_echo('places:mine');
			} else {
				$title = elgg_echo('places:owner', array($user->name));
			}

			elgg_push_breadcrumb($user->name, $handler . '/owner/' . $user->username);

			$vars = array(
				'filter_context' => $context
			);

			$content = elgg_view('framework/places/list', $vars);
			$filter = elgg_view('framework/places/filter', $vars);
			$sidebar = elgg_view('framework/places/sidebar', $vars);
			break;

		case 'group' :

			$group = get_entity($page[1]);

			if (!elgg_instanceof($group, 'group')) {
				return false;
			}

			elgg_set_page_owner_guid($group->guid);

			if ($group->canWriteToContainer(0, 'object', Place::SUBTYPE)) {
				elgg_register_title_button('places', 'create');
			}

			elgg_push_breadcrumb($group->name, $handler . '/group/' . $group->guid);

			$content = elgg_view('framework/places/group', $vars);
			$filter = false;
			$sidebar = false;
			break;

		case 'bookmarked' :

			gatekeeper();

			$username = $page[1];
			if ($username) {
				$user = get_user_by_username($username);
			} else if (elgg_is_logged_in()) {
				$user = elgg_get_logged_in_user_entity();
			}

			if (!$user->canEdit()) {
				return false;
			}

			elgg_set_page_owner_guid($user->guid);

			if (elgg_get_logged_in_user_guid() == $user->guid) {
				elgg_register_title_button('places', 'create');
				$title = elgg_echo('places:bookmarked:mine');
			} else {
				$title = elgg_echo('places:bookmarked:owner', array($user->name));
			}

			elgg_push_breadcrumb($user->name, $handler . '/owner/' . $user->username);
			elgg_push_breadcrumb($title, $handler . '/bookmarked/' . $user->username);

			$vars = array(
				'filter_context' => $context
			);

			$content = elgg_view('framework/places/list', $vars);
			$filter = elgg_view('framework/places/filter', $vars);
			$sidebar = elgg_view('framework/places/sidebar', $vars);
			break;

		case 'view' :
		case 'profile' :

			$entity_guid = $page[1];
			$entity = get_entity($entity_guid);

			if (!$entity instanceof Place) {
				return false;
			}

			$container = $entity->getContainerEntity();
			if (elgg_instanceof($container, 'group')) {
				elgg_set_page_owner_guid($container->guid);
				group_gatekeeper(true);
				elgg_push_breadcrumb($container->name, $handler . '/group/' . $container->guid);
			} else {
				$owner = $entity->getOwnerEntity();
				elgg_push_breadcrumb($owner->name, $handler . '/owner/' . $owner->username);
			}

			elgg_set_page_owner_guid($entity->guid);

			$title = $entity->title;
			elgg_push_breadcrumb($title);

			$header_override = '';
			$content = elgg_view('framework/places/profile', array(
				'entity' => $entity,
			));
			$sidebar = elgg_view('framework/places/sidebar', array(
				'entity' => $entity,
			));
			$filter = false;
			break;

		case 'create' :

			$container_guid = $page[1];
			$container = get_entity($container_guid);
			if (elgg_instanceof($container) && !$container->canWriteToContainer(0, 'object', Place::SUBTYPE)) {
				return false;
			}

			$title = elgg_echo('places:create');
			$content = elgg_view('framework/places/edit', array(
				'container' => $container
			));
			$filter = false;
			$sidebar = elgg_view('framework/places/sidebar', array(
				'container' => $container
			));
			break;

		case 'edit' :

			$entity_guid = $page[1];
			$entity = get_entity($entity_guid);
			if (!$entity instanceof Place || !$entity->canEdit()) {
				return false;
			}

			$title = elgg_echo('places:edit', array($entity->title));
			$content = elgg_view('framework/places/edit', array(
				'entity' => $entity
			));
			$filter = false;
			$sidebar = elgg_view('framework/places/sidebar', array(
				'entity' => $entity
			));
			break;

		case 'icon':
			$guid = elgg_extract(1, $page, 0);
			$size = elgg_extract(2, $page, 'medium');

			$entity = get_entity($guid);
			$config = get_icon_sizes($entity);
			if (!array_key_exists($size, $config)) {
				$size = 'medium';
			}

			set_input('guid', $guid);
			set_input('size', $size);

			include dirname(dirname(__FILE__)) . "/pages/icon/icon.php";
			exit;
	}

	if ($content) {
		if (elgg_is_xhr()) {
			echo $content;
		} else {
			$layout = elgg_view_layout('content', array(
				'header_override' => (isset($header_override)) ? $header_override : null,
				'title' => $title,
				'content' => $content,
				'filter' => $filter,
				'sidebar' => $sidebar,
			));
			echo elgg_view_page($title, $layout);
		}
		return true;
	}

	return false;
}

/**
 * Prettify URLs
 * @param ElggObject $entity
 * @return string
 */
function url_handler($entity) {

	switch ($entity->getSubtype()) {
		case Place::SUBTYPE :
			$friendly_title = elgg_get_friendly_title($entity->title);
			return elgg_normalize_url(PAGEHANDLER . '/profile/' . $entity->guid . '/' . $friendly_title);
	}
}
