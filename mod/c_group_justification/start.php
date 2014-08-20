<?php

elgg_register_event_handler('init', 'system', 'c_group_justification_init');


function c_group_justification_init() {

	elgg_unregister_plugin_hook_handler("register", "menu:title", "group_tools_menu_title_handler");
	elgg_register_plugin_hook_handler("register", "menu:title", "c_group_tools_menu_title_handler");

	elgg_register_library('elgg:groups', elgg_get_plugins_path() . 'c_group_justification/lib/groups.php');

	// register page handlers
	elgg_register_page_handler('c_group_justification', 'justification_page_handler');

	// action handlers
	$action_base = elgg_get_plugins_path() . 'c_group_justification/actions/c_group_justification/membership';
	elgg_unregister_action('groups/join');
	elgg_unregister_action('groups/killrequest');
	elgg_unregister_action("groups/addtogroup");

	elgg_register_action('groups/join', "$action_base/join.php");
	elgg_register_action('groups/killrequest', "$action_base/delete_request.php");
	elgg_register_action('groups/addtogroup', "$action_base/add.php");
}

function justification_page_handler($page)
{
	$plugin_path = elgg_get_plugins_path();
	$pages = $plugin_path . 'c_group_justification/pages/c_group_justification';
	elgg_log('cyu - page:'.$page[0], 'NOTICE');
	switch ($page[0])
	{
		case 'show_join_application':
			include $pages.'/join_application.php';
			break;
		case 'show_reason':
			include $pages.'/review_application.php';
			break;
		default:
			return false;
	}	
	return true;
}

function c_group_tools_menu_title_handler($hook, $type, $return_value, $params) {
	$result = $return_value;
	
	$page_owner = elgg_get_page_owner_entity();
	$user = elgg_get_logged_in_user_entity();
	
	if(!empty($result) && is_array($result)){
		if(elgg_in_context("groups")){
			// modify some group menu items
			if(!empty($page_owner) && !empty($user) && ($page_owner instanceof ElggGroup)){
				foreach($result as $menu_item){
					switch($menu_item->getText()){
						case elgg_echo("groups:joinrequest"):							

							if(check_entity_relationship($user->getGUID(), "membership_request", $page_owner->getGUID())){
								$menu_item->setText(elgg_echo("group_tools:joinrequest:already"));
								$menu_item->setTooltip(elgg_echo("group_tools:joinrequest:already:tooltip"));
								$menu_item->setHref(elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/groups/killrequest?user_guid=" . $user->getGUID() . "&group_guid=" . $page_owner->getGUID()));
							}
							
							break;
						case elgg_echo("groups:invite"):
							$invite = elgg_get_plugin_setting("invite", "group_tools");
							$invite_email = elgg_get_plugin_setting("invite_email", "group_tools");
							$invite_csv = elgg_get_plugin_setting("invite_csv", "group_tools");
							
							if(in_array("yes", array($invite, $invite_csv, $invite_email))){
								$menu_item->setText(elgg_echo("group_tools:groups:invite"));
							}
							
							break;
					}
				}
			}
			
			if(!empty($user) && !$user->isAdmin() && group_tools_is_group_creation_limited()){
				foreach($result as $index => $menu_item){
					if($menu_item->getText() == elgg_echo("groups:add")){
						unset($result[$index]);
					}
				}
			}
		}
	}
	return $result;
}
