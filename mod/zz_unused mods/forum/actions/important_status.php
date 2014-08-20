<?php
	/**
	 * @file actions/important_status.php
	 * @brief Change the important status value for a topic
	 */

	action_gatekeeper();
	
	$entity_guid = get_input('entity_guid');
	$entity = get_entity($entity_guid);
	
	if ($entity) {
		if (can_moderate_forum($entity->container_guid)) {
			if (($entity->important_topic == 'yes') || (!$entity->important_topic)) {
				$entity->important_topic = 'no';
				system_message(sprintf(elgg_echo('forum:important_status_removed'),$entity->title));
			} else {
				$entity->important_topic = 'yes';
				system_message(sprintf(elgg_echo('forum:important_status_added'),$entity->title));
			}
		} else {
			system_messages(elgg_echo('forum:can_not_edit_topic'),'errors');
		}
	}
	
	forward($_SERVER['HTTP_REFERER']);
?>