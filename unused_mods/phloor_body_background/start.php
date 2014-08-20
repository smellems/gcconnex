<?php
/*****************************************************************************
 * Phloor Body Background                                                    *
 *                                                                           *
 * Copyright (C) 2011 Alois Leitner                                          *
 *                                                                           *
 * This program is free software: you can redistribute it and/or modify      *
 * it under the terms of the GNU General Public License as published by      *
 * the Free Software Foundation, either version 2 of the License, or         *
 * (at your option) any later version.                                       *
 *                                                                           *
 * This program is distributed in the hope that it will be useful,           *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 * GNU General Public License for more details.                              *
 *                                                                           *
 * You should have received a copy of the GNU General Public License         *
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.     *
 *                                                                           *
 * "When code and comments disagree both are probably wrong." (Norm Schryer) *
 *****************************************************************************/
?>
<?php
/**
 * Phloor Body Background
 */

elgg_register_event_handler('init',      'system', 'phloor_body_background_init');
elgg_register_event_handler('pagesetup', 'system', 'phloor_body_background_pagesetup');

function phloor_body_background_init() {
	/**
	 * LIBRARY
	 * register a library of helper functions
	 */
	$lib_path = elgg_get_plugins_path() . 'phloor_body_background/lib/';
	elgg_register_library('phloor-custom-background_image-lib', $lib_path . 'phloor_body_background.lib.php');
	elgg_load_library('phloor-custom-background_image-lib');

	/**
	 * Page handler
	 */
	elgg_register_page_handler('phloor-background', 'phloor_body_background_background_image_handler');
	elgg_register_page_handler('phloor_body_background', 'phloor_body_background_page_handler');

    elgg_register_entity_url_handler('object', 'phloor_background_image', 'phloor_body_background_background_image_url_handler');

	/**
	 * CSS
	 */
	elgg_extend_view('css/admin', 'phloor_body_background/css/admin');
	elgg_extend_view('css/admin', 'phloor_body_background/css/admin_body_background_preview');
	elgg_extend_view('css/elgg',  'phloor_body_background/css/elgg' );

	/**
	 * Admin menu
	 */
	elgg_register_admin_menu_item('configure', 'phloor_body_background', 'appearance');

	/**
	 * Actions
	 */
	$base = elgg_get_plugins_path() . 'phloor_body_background/actions/phloor_body_background';
	elgg_register_action('phloor_body_background/save', "$base/save.php");
	elgg_register_action('phloor_body_background/delete', "$base/delete.php");
	elgg_register_action('phloor_body_background/toggle_site_background', "$base/toggle_site_background.php", "admin");

    /**
	 * Hooks
	 */
	// allow background image when walled_garden is active
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'phloor_body_background_public_pages');


	elgg_register_plugin_hook_handler('prepare',  'menu:entity', 'phloor_body_background_prepare_entity_menu_setup',  999);
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'phloor_body_background_register_entity_menu_setup', 999);


	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'phloor_body_background_user_hover_menu');

	/**
	 * Events
	 */
    elgg_register_event_handler('create', 'object', 'phloor_body_background_create_event_handler');
}

/**
 * Background image page handler
 *
 * serves the background image
 *
 * @param unknown_type $_ parameters does not matter and is ignored
 */
function phloor_body_background_background_image_handler($page) {
    $site = elgg_get_site_entity();

    $image = "";
    $mime  = "";

    if(isset($page[0]) && isset($page[1])) {
        $mode = $page[0]; // "user" or "site"

        switch($mode) {
            case 'user':
            case 'site':
                $guid = get_input("guid", null, true);
                $background_image = get_entity($guid);
                if (phloor_elgg_thumbnails_instanceof($background_image)) {
                    $image = $background_image->image;
                    $mime = $background_image->mime;
                }
                break;
            default:
               break;
        }
    }

    if (empty($image) || !file_exists($image) || !is_file($image)) {
        $image = elgg_get_root_path() . "_graphics/spacer.gif";
        $mime  = 'image/gif';
    }

    // get file contents
    $contents = file_get_contents($image);
    // caching images for 10 days
    header("Content-type: $mime"); // jpeg for thumbs
    header('Expires: ' . date('r', time() + 864000));
    header("Pragma: public", true);
    header("Cache-Control: public", true);
    header("Content-Length: " . strlen($contents));
    echo $contents;

	exit();
	// return true;
}

/**
 *
 * Page handler for 'phloor_body_background'
 * and (if not overwritten) 'sponsor'
 *
 * @param unknown_type $page
 */
function phloor_body_background_page_handler($page) {
	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	// push 'all' breadcrumb for admins
	if(elgg_is_admin_logged_in()) {
	    elgg_push_breadcrumb(elgg_echo('phloor_body_background:breadcrumb:all'), "phloor_body_background/all");
	}

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			$user = get_user_by_username($page[1]);
			$params = phloor_body_background_get_page_content_list($user->guid);
			break;
		case 'group':
			$group = get_entity($page[1]);
			if(!elgg_instanceof($group, 'group')) {
				return false;
			}
			$params = phloor_body_background_get_page_content_list($group->guid);
			break;
		case 'view':
			$params = phloor_body_background_get_page_content_read($page[1]);
			break;
		case 'add':
			$params = phloor_body_background_get_page_content_edit($page_type, $page[1]);
			break;
		case 'edit':
			$params = phloor_body_background_get_page_content_edit($page_type, $page[1]);
			break;
		case 'site':
            admin_gatekeeper();
            $site = elgg_get_site_entity();
			$params = phloor_body_background_get_page_content_list($site->guid);
			break;
		case 'all':
		    // only admin can view all
		    admin_gatekeeper();
			$params = phloor_body_background_get_page_content_list();
			break;
		default:
			return false;
	}

	if (isset($params['sidebar'])) {
		$params['sidebar'] .= elgg_view('phloor_body_background/sidebar', array('page' => $page_type));
	} else {
		$params['sidebar'] = elgg_view('phloor_body_background/sidebar', array('page' => $page_type));
	}

    // only admin sees the filter (all, mine, friends)
	if(!elgg_is_admin_logged_in()) {
	    $params['filter'] = false;
	}

	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($params['title'], $body);

	return true;
}

/**
 * Format and return the URL for phloor_newss.
 *
 * @param ElggObject $entity phloor_news object
 * @return string URL of phloor_news.
 */
function phloor_body_background_background_image_url_handler($entity) {
    if (!$entity->getOwnerEntity()) {
        // default to a standard view if no owner.
        return FALSE;
    }

    return "phloor_body_background/view/{$entity->guid}";
}

/**
 * Set up the menu for the body background user settings
 *
 * @return void
 * @access private
 */
function phloor_body_background_pagesetup() {
	$page_owner = elgg_get_page_owner_entity();
	$context    = elgg_get_context();

	if ($page_owner) {
		elgg_register_menu_item('page', array(
			'name' => 'edit_profile_background',
			'href' => "phloor_body_background/owner/{$page_owner->username}/edit",
			'text' => elgg_echo('phloor_body_background:profile_background:edit'),
			'contexts' => array('profile', 'profile_edit'),
		));
	}

	if ($context == "settings") {
		$params = array(
			'name' => '2_body_background',
			'text' => elgg_echo('phloor_body_background:usersettings:menu:linktext'),
			'href' => "phloor_body_background/owner/{$page_owner->username}",
		);
		elgg_register_menu_item('page', $params);
	}

    /**
     * EXTEND THE HEAD WITH CSS
     */
	if ($context != "admin") {
    	elgg_extend_view('page/elements/head',   'phloor_body_background/css/site_body_background', 501);

    	if (phloor_body_background_user_profile_backgrounds_enabled() && $context== "profile") {
            elgg_extend_view('page/elements/head',   'phloor_body_background/css/user_profile_body_background', 502);
    	}

    }
}

function phloor_body_background_prepare_entity_menu_setup($hook, $type, $return, $params) {
	$background_image = elgg_extract('entity', $params, false);
	$handler = elgg_extract('handler', $params, false);

	$context = elgg_get_context();
	if(!phloor_body_background_instanceof($background_image)) {
		return $return;
	}

	if (strcmp("admin", $context) == 0) {
	    /**
         * UNregister items
         * unregister like and likes_count
         */
        $unregister_items = array('likes', 'likes_count');

        foreach ($return as $index => $section) {
            if(is_array($section)) {
                foreach($section as $key => $item) {
                    if(in_array($item->getName(), $unregister_items)) {
                        unset($return[$index][$key]);
                    }
                }
            }
        }
	}

	return $return;
}

/**
 *
 */
function phloor_body_background_register_entity_menu_setup($hook, $type, $return, $params) {
	$background_image = elgg_extract('entity', $params, false);
	$handler = elgg_extract('handler', $params, false);

	if(!phloor_body_background_instanceof($background_image)) {
		return $return;
	}

	$site = elgg_get_site_entity();
	if(elgg_is_admin_logged_in()) {
		if($background_image->container_guid != $site->guid) {
		    $text = elgg_echo('phloor_body_background:menu:set_site_background');
		} else {
		    $text = elgg_echo('phloor_body_background:menu:unset_site_background');
		}

        $url = "action/phloor_body_background/toggle_site_background?guid={$background_image->guid}";
		$options = array(
			'name' => 'toggle-site-background',
			'text' => $text,
			'href' => elgg_add_action_tokens_to_url($url),
		);

		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}

function phloor_body_background_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];

	if (elgg_is_logged_in() && phloor_body_background_user_profile_backgrounds_enabled()) {
		if (elgg_get_logged_in_user_guid() == $user->guid) {
			$url = "phloor_body_background/owner/$user->username/edit";
			$item = new ElggMenuItem('phloor_body_background_profile_background', elgg_echo('phloor_body_background:profile_background:edit'), $url);
			$item->setSection('action');
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Prevents ordinary users from saving more than 3 backgrounds!
 *
 * Ordinary users should not be able to upload more than 3 background images..
 */
function phloor_body_background_create_event_handler($event, $object_type, $object) {

    if (phloor_body_background_instanceof($object)) {
	    $user = elgg_get_logged_in_user_entity();

	    if (!$user->isAdmin()) {
	        $_USER_BACKGROUND_LIMIT = 3; // change this if you want

	        $count = phloor_body_background_get_background_image_entities(array(
	            'count' => true,
	            'container_guid' => $user->guid,
	        ));

	        if($count >= $_USER_BACKGROUND_LIMIT) {
	            register_error(elgg_echo('phloor_body_background:background_image:limit_reached'));
	            return false;
	        }
	    }
	}
	return TRUE;
}
