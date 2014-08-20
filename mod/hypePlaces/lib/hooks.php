<?php

namespace hypeJunction\Places;

use ElggMenuItem;

/**
 * Get icon URL hook
 *
 * @param string $hook		Equals 'entity:icon:url'
 * @param string $type		Equals 'object'
 * @param array $return		Current URL
 * @param array $params		Additional params
 * @return array			Updated URL
 * @return string
 */
function entity_icon_url($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);
	$size = elgg_extract('size', $params, 'medium');

	if (elgg_instanceof($entity, 'object', Place::SUBTYPE)) {
		if (!$entity->icontime) {
			return elgg_normalize_url('mod/' . PLUGIN_ID . '/graphics/icon/' . $size . '.png');
		}
		return elgg_normalize_url("places/icon/{$entity->guid}/{$size}");
	}

	return $return;
}

/**
 * Icon size config
 *
 * @param string $hook		Equals 'entity:icon:sizes'
 * @param string $type		Equals 'object'
 * @param array $return		Current config
 * @param array $params		Additional params
 * @return array			Updated config
 */
function entity_icon_sizes($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	if (!elgg_instanceof($entity, 'object', Place::SUBTYPE)) {
		return $return;
	}

	$config = array(
		'125' => array(
			'w' => 125,
			'h' => 125,
			'square' => false,
			'upscale' => true
		),
		'325x200' => array(
			'w' => 325,
			'h' => 200,
			'square' => false,
			'upscale' => true,
			'croppable' => true,
		),
	);
	return (is_array($return)) ? array_merge($return, $config) : $config;
}

/**
 * Setup entity menus
 * 
 * @param string $hook
 * @param string $type
 * @param array $return
 * @param array $params
 * @return array
 */
function entity_menu_setup($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	if (!$entity instanceof Place) {
		return $return;
	}

	if (elgg_is_admin_logged_in()) {
		$featured = $entity->featured;
		$on_action = 'action/places/feature?guid=' . $entity->guid;
		$off_action = 'action/places/unfeature?guid=' . $entity->guid;
		$on_text = elgg_echo('places:feature');
		$off_text = elgg_echo('places:unfeature');
		$return[] = ElggMenuItem::factory(array(
					'name' => 'feature',
					'data-guid' => $entity->guid,
					'data-on' => $on_action,
					'data-off' => $off_action,
					'data-on-text' => $on_text,
					'data-off-text' => $off_text,
					'data-place' => true,
					'data-counter' => 'features',
					'data-count' => 0,
					'data-status' => ($featured) ? 'on' : 'off',
					'href' => ($featured) ? $off_action : $on_action,
					'text' => ($featured) ? $off_text : $on_text,
		));
	}

	return $return;
}

/**
 * Setup user interaction menus
 *
 * @param string $hook
 * @param string $type
 * @param array $return
 * @param array $params
 * @return array
 */
function interactions_menu_setup($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	if (!$entity instanceof Place) {
		return $return;
	}

	if (elgg_is_logged_in()) {
		$bookmarked = check_entity_relationship(elgg_get_logged_in_user_guid(), 'bookmarked', $entity->guid);
		$count = elgg_get_entities_from_relationship(array(
			'relationship' => 'bookmarked',
			'relationship_guid' => $entity->guid,
			'inverse_relationship' => true,
			'count' => true
		));
		$on_action = 'action/places/bookmark?guid=' . $entity->guid;
		$off_action = 'action/places/unbookmark?guid=' . $entity->guid;
		$on_text = elgg_echo('places:bookmark');
		$off_text = elgg_echo('places:unbookmark');
		$return[] = ElggMenuItem::factory(array(
					'name' => 'bookmark',
					'data-guid' => $entity->guid,
					'data-on' => $on_action,
					'data-off' => $off_action,
					'data-on-text' => $on_text,
					'data-off-text' => $off_text,
					'data-place' => true,
					'data-status' => ($bookmarked) ? 'on' : 'off',
					'link_class' => 'show-counter',
					'data-counter' => 'bookmarks',
					'data-count' => $count,
					'href' => ($bookmarked) ? $off_action : $on_action,
					'text' => ($bookmarked) ? $off_text : $on_text,
		));

		if ($entity->checkins) {
			$checked_in = $entity->isCheckedIn();
			$count = $entity->getCheckins(array('count' => true));
			$on_action = 'action/places/checkin?guid=' . $entity->guid;
			$off_action = 'action/places/checkout?guid=' . $entity->guid;
			$on_text = elgg_echo('places:checkin');
			$off_text = elgg_echo('places:checkout');
			$return[] = ElggMenuItem::factory(array(
						'name' => 'checkin',
						'data-guid' => $entity->guid,
						'data-on' => $on_action,
						'data-off' => $off_action,
						'data-on-text' => $on_text,
						'data-off-text' => $off_text,
						'data-place' => true,
						'data-status' => ($checked_in) ? 'on' : 'off',
						'link_class' => 'show-counter',
						'data-counter' => 'checkins',
						'data-count' => $count,
						'href' => ($checked_in) ? $off_action : $on_action,
						'text' => ($checked_in) ? $off_text : $on_text,
			));
		}
	}

	return $return;
}

/**
 * Setup owner block menu
 *
 * @param string $hook		Equals 'register'
 * @param string $type		Equals 'menu:owner_block'
 * @param array $return		Current menu items
 * @param array $params		Additional params
 * @return array			Updated menu
 */
function owner_block_menu_setup($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	if (elgg_instanceof($entity, 'group') && $entity->places_enable !== 'no') {
		$return[] = ElggMenuItem::factory(array(
					'name' => 'group:places',
					'text' => elgg_echo('places:group'),
					'href' => PAGEHANDLER . "/group/$entity->guid"
		));
	} else if (elgg_instanceof($entity, 'user')) {
		$return[] = ElggMenuItem::factory(array(
					'name' => 'user:albums',
					'text' => elgg_echo('places'),
					'href' => PAGEHANDLER . "/owner/$entity->username"
		));
	}

	return $return;
}

/**
 * Allow place owners to add widgets
 *
 * @param string $hook		Equals 'permissions_check'
 * @param string $type		Equals 'widget_layout'
 * @param boolean $return	Current permission
 * @param array $params		Additional params
 * @return boolean			Filtered permission
 */
function widget_layout_permissions_check($hook, $type, $return, $params) {

	$context = elgg_extract('context', $params);
	$user = elgg_extract('user', $params);
	$page_owner = elgg_extract('page_owner', $params);

	if (!elgg_instanceof($user) || !elgg_instanceof($page_owner)) {
		return $return;
	}

	if ($context == PAGEHANDLER && $user->guid == $page_owner->owner_guid) {
		return true;
	}

	return $return;
}

/**
 * Setup sitewide maps
 *
 * @param string $hook
 * @param string $type
 * @param array $return
 * @param array $params
 * @return string
 */
function setup_site_search_maps($hook, $type, $return, $params) {

	$return['places'] = array(
		'title' => elgg_echo('places:search'),
		'options' => array(
			'id' => 'objects',
			'types' => 'object',
			'subtypes' => Place::SUBTYPE,
		),
		'getter' => 'elgg_get_entities',
		'access' => 'public',
		'priority' => 500
	);

	return $return;
}
