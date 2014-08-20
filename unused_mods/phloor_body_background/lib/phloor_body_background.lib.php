<?php
/*****************************************************************************
 * Phloor Body Background                                                    *
 *                                                                           *
 * Copyright (C) 2012 Alois Leitner                                          *
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
 * Default attributes
 *
 * @return array with default values
 */
function phloor_body_background_default_vars() {
	$defaults = array(
		'image'   => '',
		'mime'   => '',
	    'time' => time(),
	    'delete_image' => 'false',
	    'repeat' => 'repeat',
	    'position' => 'left top',
	    'attachment' => 'scroll',
	    'color' => 'transparent',

	    'comments_on' => 'Off',
	    'access_id' => ACCESS_PUBLIC,
	    'container_guid' => '',
	);

	return $defaults;
}

function phloor_body_background_user_profile_backgrounds_enabled() {
    $enabled = elgg_get_plugin_setting("enable_user_profile_background", "phloor_body_background");
    return strcmp("true", $enabled) == 0;
}

/**
 * Load vars from post or get requests and returns them as array
 *
 * @return array with values from the request
 */
function phloor_body_background_get_input_vars() {
	$defaults = phloor_body_background_default_vars();

	$user = elgg_get_logged_in_user_entity();

	$params = array();
	foreach($defaults as $key => $default_value) {
	    $value = get_input($key, $default_value);
		switch ($key) {
			// get the image from $_FILES array
			case 'image':
				$params['image'] = $_FILES['image'];
				break;
			case 'container_guid':
				// this can't be empty or saving the base entity fails
				if (!empty($value)) {
					if (can_write_to_container($user->getGUID(), $value)) {
						$params['container_guid'] = $value;
					}
				}
				break;
			// don't try to set the guid
			case 'guid':
				unset($params['guid']);
				break;
			default:
				$params[$key] = $value;
				break;
		}
	}

	return $params;
}

/**
 * Load vars from given site into and returns them as array
 *
 * @return array with stored values
 */
function phloor_body_background_save_vars($background_image, $params = array()) {
	// get default values
	$defaults = phloor_body_background_default_vars();

	// merge with params
	$vars = array_merge($defaults, $params);

    // check for the image
    if(!phloor_elgg_image_check_vars($background_image, $vars)) {
        return false;
    }

    // check variables
    if(!phloor_body_background_check_vars($background_image, $vars)) {
        return false;
    }

    // adopt variables
    foreach($vars as $key => $value) {
        $background_image->$key = $value;
    }

	// save site and return status
	return $background_image->save();
}

function phloor_body_background_check_vars($background_image, &$params) {
    /**
     * Color
     */
    // Check for a hex color string '#c1c2b4'
    if(preg_match('/^#[A-Fa-f0-9]{6}$/i', $params['color']) ||
       preg_match('/^#[A-Fa-f0-9]{3}$/i', $params['color'])) {
        $params['color'] = "{$params['color']}";
    }
    else if (preg_match('/^[A-Fa-f0-9]{6}$/i', $params['color']) ||
             preg_match('/^[A-Fa-f0-9]{3}$/i', $params['color'])) {
        $params['color'] = "#{$params['color']}"; // add "#"
    }
    else {
        // fall back to transparent if no hex code given
        $params['color'] = '';
    }
    /*
     * Color - END
     **/

    /**
     * Position
     */
    $positions = array(
        'left top'      => 'left top',
        'left center'   => 'left center',
        'left bottom'   => 'left bottom',
        'right top'     => 'right top',
        'right center'  => 'right center',
        'right bottom'  => 'right bottom',
        'center top'    => 'center top',
        'center center' => 'center center',
        'center bottom' => 'center bottom',
    );
    if(!in_array($params['position'], $positions)) {
        $params['position'] = 'left top';
    }
    /*
     * Position - END
     **/

    /**
     * Repeat
     */
    $repeats = array(
        'repeat'    => 'repeat',
        'repeat-x'  => 'repeat-x',
        'repeat-y'  => 'repeat-y',
        'no-repeat' => 'no-repeat',
    );
    if(!in_array($params['repeat'], $repeats)) {
        $params['repeat'] = 'repeat';
    }
    /*
     * Repeat - END
     **/

    /**
     * Attachment
     */
    $attachments = array(
        'scroll' => 'scroll',
        'fixed'  => 'fixed',
    );
    if(!in_array($params['attachment'], $attachments)) {
        $params['attachment'] = 'scroll';
    }
    /*
     * Attachment - END
     **/

	return true;
}

/**
 * Get page components to view a backgound image.
 *
 * @param int $guid GUID of a background image entity.
 * @return array
 */
function phloor_body_background_get_page_content_read($guid = NULL) {

	$return = array();

	$background_image = get_entity($guid);

	// no header or tabs for viewing an individual background image
	$return['filter'] = '';

	if (!phloor_body_background_instanceof($background_image)) {
		$return['content'] = elgg_echo('phloor_body_background:error:entity_not_found');
		return $return;
	}

	$return['title'] = htmlspecialchars($background_image->title);

	$container = $background_image->getContainerEntity();
	$crumbs_title = $container->name;

	// push the breadcrumb "site backgrounds" for admins
	if(elgg_is_admin_logged_in() && $site->guid == $container->guid) {
	    elgg_push_breadcrumb($crumbs_title, "phloor_body_background/site");
	}
	else if (elgg_instanceof($container, 'group')) {
		elgg_push_breadcrumb($crumbs_title, "phloor_body_background/group/$container->guid/all");
	}
	else {
		elgg_push_breadcrumb($crumbs_title, "phloor_body_background/owner/$container->username");
	}

	elgg_push_breadcrumb($background_image->title);
	$return['content'] = elgg_view_entity($background_image, array('full_view' => true));

	return $return;
}

/**
 * Get page components to list a user's or all background images.
 *
 * @param int $owner_guid The GUID of the page owner or NULL for all images
 * @return array
 */
function phloor_body_background_get_page_content_list($container_guid = NULL, $params = array()) {

	$return = array();

	$return['filter_context'] = $container_guid ? 'mine' : 'all';

	$options = array(
		'type' => 'object',
		'subtype' => 'phloor_background_image',
		'full_view' => FALSE,
	);

	$loggedin_userid = elgg_get_logged_in_user_guid();
	if ($container_guid) {
		// access check for closed groups
		group_gatekeeper();

		$options['container_guid'] = $container_guid;
		$container = get_entity($container_guid);
		if (!$container) {

		}
		$title = elgg_echo('phloor_body_background:title:user_phloor_body_backgrounds', array($container->name));
		if($container->guid == elgg_get_site_entity()->guid) {
		    $return['title'] = elgg_echo('phloor_body_background:title:site_phloor_body_backgrounds');
		}

        $return['title'] = $title;

		$crumbs_title = $container->name;
		elgg_push_breadcrumb($crumbs_title);

		if ($container_guid == $loggedin_userid) {
			$return['filter_context'] = 'mine';
		} else if (elgg_instanceof($container, 'group')) {
			$return['filter'] = false;
		} else {
			// do not show button or select a tab when viewing someone else's posts
			$return['filter_context'] = 'none';
		}
	} else {
		$return['filter_context'] = 'all';
		$return['title'] = elgg_echo('phloor_body_background:title:all_phloor_body_backgrounds');
		elgg_pop_breadcrumb();
		elgg_push_breadcrumb(elgg_echo('phloor_body_background:phloor_body_backgrounds'));
	}

	elgg_register_title_button();

	$list = elgg_list_entities_from_metadata($options);
	if (!$list) {
		$return['content'] = elgg_echo('phloor_body_background:none');
	} else {
		$return['content'] = $list;
	}

	$return['filter_override'] = elgg_view('phloor_body_background/backgroundfilter', array(
		'filter_context' => $return['filter_context'],
	    'context' => elgg_get_context(),
    ));


	return $return;
}



/**
 * Get page components to edit/create a background image
 *
 * @param string  $page     'edit' or 'new'
 * @param int     $guid     GUID of phloor_body_background post or container
 * @return array
 */
function phloor_body_background_get_page_content_edit($page, $guid = 0) {

	$return = array(
		'filter' => '',
	);

	$vars = array();
	$vars['id'] = 'phloor-background-image-edit';
	$vars['name'] = 'phloor_body_background_edit';
	$vars['class'] = 'elgg-form-alt';

	$site_url = elgg_get_site_url();

	if ($page == 'edit') {
		$background_image = get_entity((int)$guid);

		$title = elgg_echo('phloor_body_background:edit');
		if (phloor_body_background_instanceof($background_image) && $background_image->canEdit()) {

			elgg_push_breadcrumb($background_image->title, $background_image->getURL());
			elgg_push_breadcrumb(elgg_echo('edit'));

			// create form
    		$form = elgg_view('input/form',array(
            	'action' => "{$site_url}action/phloor_body_background/save",
            	'body' => elgg_view('forms/phloor_body_background/save', array(
    			    'entity' => $background_image,
    			)),
            	'method' => 'post',
            	'enctype' => 'multipart/form-data',
            ));

    		$content = $form;
    		$title   = elgg_echo('phloor_body_background:edit');
    		$sidebar = '';

		} else {
			$content = elgg_echo('phloor:error:cannot_edit_entity');
		}

		$sidebar = '';
	} else {
		elgg_push_breadcrumb(elgg_echo('phloor_body_background:add'));

		$body_vars = array(
		    'entity' => new PhloorBackgroundImage(),
		);

		// create form
		$form = elgg_view('input/form',array(
        	'action' => "{$site_url}action/phloor_body_background/save",
        	'body' => elgg_view('forms/phloor_body_background/save', $body_vars),
        	'method' => 'post',
        	'enctype' => 'multipart/form-data',
        ));

		$content = $form;
		$title   = elgg_echo('phloor_body_background:add');
		$sidebar = '';
	}

	$return['title']   = $title;
	$return['content'] = $content;
	$return['sidebar'] = $sidebar;
	return $return;
}


function phloor_body_background_public_pages($hook, $handler, $return, $params) {
	$pages = array('phloor-background/site', 'phloor-background/site/body.jpg');
	return array_merge($pages, $return);
}


function phloor_body_background_instanceof($background_image) {
    return elgg_instanceof($background_image, 'object', 'phloor_background_image', 'PhloorBackgroundImage');
}

function phloor_body_background_get_background_image_entities($params = array()) {
    $options = array(
		'type' => 'object',
		'subtype' => 'phloor_background_image',
		'offset' => 0,
		'limit' => 0,
    );

    $options = array_merge($params, $options);

    return elgg_get_entities($options);
}

function phloor_body_background_get_background_image_entities_by_container($container_guid) {
    $params = array();
    if(elgg_instanceof(get_entity($container_guid))) {
        $params['container_guid'] = $container_guid;
    }

    $entities = phloor_body_background_get_background_image_entities($params);

    return $entities;
}

/**
 *
function phloor_body_background_prepare_form_vars($background_image = null) {
    $defaults = phloor_body_background_default_vars();

    // input names => defaults
    $params = array(
		'entity' => $background_image,
    );

    $values = array_merge($defaults, $params);

    if ($background_image) {
        foreach (array_keys($values) as $field) {
            if (isset($background_image->$field)) {
                $values[$field] = $background_image->$field;
            }
        }
    }

    return $values;
} */


