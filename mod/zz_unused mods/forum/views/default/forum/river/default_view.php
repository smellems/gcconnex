<?php
	/**
	 * @file views/default/forum/river/default_view.php
	 * @brief Displays the river informations for plugin forum 
	 */

	$user = get_entity($vars['item']->subject_guid);
	$entity = get_entity($vars['item']->object_guid);

	$type = elgg_echo($vars['item']->subtype);
	$entity_name = '<a href="'.$entity->getURL().'">'.$entity->title.'</a>';
	$name = '<a href="'.$user->getURL().'">'.$user->name.'</a>';
	
	if ($vars['item']->action_type == 'create') {
		echo sprintf(elgg_echo('forum:river_create_message'),$type,$entity_name,$name);
	} else if ($vars['item']->action_type =='update') {
		echo sprintf(elgg_echo('forum:river_update_message'),$type,$entity_name,$name);
	}
?>