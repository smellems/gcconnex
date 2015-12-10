<?php

namespace AU\ActivityTabs;

/**
 * Hook into filter menu to replace destinations with our own
 * 
 * @param type $hook
 * @param type $type
 * @param type $returnvalue
 * @param type $params
 * @return type
 */
function filtermenu_hook($hook, $type, $returnvalue, $params) {
	if (elgg_get_context() != 'ml' || !elgg_is_logged_in()) {
		return $returnvalue;
	}

	$check = $returnvalue;

	foreach ($check as $key => $item) {
		switch ($item->getName()) {
			case 'all':
				$url = elgg_get_site_url() . 'activity/all';
				$item->setHref($url);
				$returnvalue[$key] = $item;
				break;
			case 'mine':
				$url = elgg_get_site_url() . 'activity/owner/' . elgg_get_logged_in_user_entity()->username;
				$item->setHref($url);
				$returnvalue[$key] = $item;
				break;
			case 'friend':
				$url = elgg_get_site_url() . 'activity/friends/' . elgg_get_logged_in_user_entity()->username;
				$item->setHref($url);
				$returnvalue[$key] = $item;
				break;
			default:
				break;
		}
	}

	return $returnvalue;
}

/**
 * 
 * @param type $hook
 * @param type $type
 * @param type $returnvalue
 * @param type $params
 * @return ElggMenuItem
 */
function user_hover_hook($hook, $type, $returnvalue, $params) {
	$user = $params['entity'];

	$url = elgg_get_site_url() . "ml/user/{$user->username}";

	$item = new \ElggMenuItem('ml_user_activity', elgg_echo('ml'), $url);

	if ($type == 'menu:user_hover') {
		$item->setSection('action');
		$item->setLinkClass('activity-tabs-user-hover');
		$item->setPriority(200);
	}
	$returnvalue[] = $item;

	return $returnvalue;
}
