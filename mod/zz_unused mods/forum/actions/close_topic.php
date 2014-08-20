<?php
	/**
	 * @file actions/close_topic.php
	 * @brief Change the topic status between closed/opened
	 */

	action_gatekeeper();
	
	$entity_guid = get_input('entity_guid');
	$entity = get_entity($entity_guid);
	
	if ($entity) {
		if (can_moderate_forum($entity->container_guid) || can_edit_entity($entity->guid)) {
			if ($entity->status == 'closed') {
				$entity->status = 'opened';
				system_message(sprintf(elgg_echo('forum:topic_opened'),$entity->title));
			} else {
				$entity->status = 'closed';
				system_message(sprintf(elgg_echo('forum:topic_closed'),$entity->title));
			}
		} else {
			system_messages(elgg_echo('forum:can_not_edit_topic'),'errors');
		}
	}
	
	forward($_SERVER['HTTP_REFERER']);
?>