<?php
	/**
	 * @file actions/stick_topic.php
	 * @brief To change the topic stick status: stick or unstick
	 */

	action_gatekeeper();
	
	$entity_guid = get_input('entity_guid');
	$entity = get_entity($entity_guid);
	
	if ($entity) {
		if (can_moderate_forum($entity->container_guid)) {
			if ($entity->stick) {
				remove_metadata($entity->guid,'stick');
				system_message(sprintf(elgg_echo('forum:topic_unsticked'),$entity->title));
			} else {
				$entity->stick = true;
				system_message(sprintf(elgg_echo('forum:topic_sticked'),$entity->title));
			}
		} else {
			system_messages(elgg_echo('forum:can_not_edit_topic'),'errors');
		}
	}
	
	forward($_SERVER['HTTP_REFERER']);
?>